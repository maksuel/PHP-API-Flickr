<?php

/**
 * Common class.
 * 
 * PHP version 7
 * 
 * @category API
 * @package  FlickrAPI
 * @author   Maksuel Boni <me@maks.com.br>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @link     https://github.com/maksuel
 */
namespace MAKS\API\Flickr;

class Common
{
    private $_errors = array();

    /**
     * Check length and if is hexadecimal of string.
     * 
     * @param string $key  must be checked
     * @param string $size size of key
     * 
     * @return mixed or throw new Exception()
     */
    protected function checkHexadecimalKey( string $key, int $size ) : mixed
    {
        $isHexadecimal = ctype_xdigit($key);
        $keySize       = strlen($key);

        if ($isHexadecimal && $keySize === $size) {

            return $key;

        } else {

            $this->pushError(
                "The key '$key' must contain $size characters and be hexadecimal."
            );

            return false;
        }
    }

    /**
     * Push error.
     * 
     * @param string $message Error message
     * @param string $code    Error code
     * 
     * @return NO
     */
    protected function pushError( string $message, int $code = 0 )
    {
        array_push(
            $this->_errors,
            array(
                'time'    => time(),
                'message' => $message,
                'code'    => $code !== 0 ? $code : false
            )
        );
    }

    /**
     * Get all errors.
     * 
     * @return array of errors
     */
    protected function getErrors() : array
    {
        return $this->_errors;
    }







    protected function common_get_query( string $method, string $url, array $args, string $key, string $secret, string $token = '', string $token_secret = '' )
    {
        $query = $this->get_query($key, $token, $args);

        $query['oauth_signature'] = $this->get_oauth_signature(
            $secret,
            $this->get_base_string($method, $url, $query),
            $token_secret
        );

        ksort($query);

        return $query;
    }

    private function get_query( string $key, string $token, array $args = [] ) : array
    {
        $required = array(
            'oauth_consumer_key'     => $key,
            'oauth_nonce'            => wp_create_nonce(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp'        => time(),
            'oauth_version'          => '1.0'
        );

        if(! empty($token) ) {
            $required['oauth_token'] = $token;
        }

        return array_merge($args, $required);
    }

    private function get_oauth_signature( string $secret, string $data, string $token_secret ) : string
    {
        $key = "{$secret}&{$token_secret}";

        return base64_encode(
            hash_hmac('sha1', $data, $key, true)
        );
    }

    private function get_base_string( string $method, string $url, array $query ) : string
    {
        $supported_methods = [ 'GET', 'POST' ];
        $excluded_keys     = [ 'photo' ];

        $method = strtoupper($method);

        if(! in_array($method, $supported_methods) ) { return '';
        }

        ksort($query);

        $params = '';

        foreach( $query as $key => $value )
        {
            if(in_array($key, $excluded_keys) ) { continue;
            }

            $value = rawurlencode($value);

            $params .= empty($params) ? "{$key}={$value}" : "&{$key}={$value}";
        }
        
        $url    = rawurlencode($url);
        $params = rawurlencode($params);

        return "{$method}&{$url}&{$params}";
    }
}