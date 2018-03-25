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

class Common // phpcs:ignore
{
    private $_errors = array();

    /**
     * Check length and if is hexadecimal of string.
     * 
     * @param string $key  must be checked
     * @param string $size size of key
     * 
     * @return string|bool
     */
    protected function sanitizeHexadecimalKey( string $key, int $size ) : mixed
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
     * Remote get.
     * 
     * @return array
     */
    protected function remoteGet() : array
    {
        

    }

    /**
     * Get query
     * 
     * @param string $method      GET or POST
     * @param string $url         
     * @param array  $args        array to concatenate
     * @param string $key         
     * @param string $secret      
     * @param string $token       
     * @param string $tokenSecret 
     * 
     * @return array
     */
    protected function getRequestArgs( string $method, string $url, array $args, string $key, string $secret, string $token = '', string $tokenSecret = '' ) : array //
    {
        $args = $this->_getRequiredArgs($key, $token, $args);

        $args['oauth_signature'] = $this->_getOAuthSignature(
            $secret,
            $this->_getBaseString($method, $url, $query),
            $tokenSecret
        );

        ksort($args);

        return $args;
    }

    /**
     * Private method get required args and merge if necessary.
     * 
     * @param string $key   
     * @param string $token 
     * @param array  $args  
     * 
     * @return array
     */
    private function _getRequiredArgs( string $key, string $token = '', array $args = [] ) : array //
    {
        $required = array(
            'oauth_consumer_key'     => $key,
            'oauth_nonce'            => substr(
                hash_hmac('md5', random_bytes(32), $key), -12, 10 // WP reference
            ),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp'        => time(),
            'oauth_version'          => '1.0'
        );

        if (! empty($token) ) {
            $required['oauth_token'] = $token;
        }

        return array_merge($args, $required);
    }

    /**
     * Get OAuth Signature
     * 
     * @param string $secret      
     * @param string $data        
     * @param strign $tokenSecret 
     * 
     * @return string
     */
    private function _getOAuthSignature( string $secret, string $data, string $tokenSecret ) : string //
    {
        $key = "{$secret}&{$tokenSecret}";

        return base64_encode(
            hash_hmac('sha1', $data, $key, true)
        );
    }

    /**
     * Get base string.
     * 
     * @param string $method GET or POST
     * @param string $url    
     * @param array  $args   
     * 
     * @return string
     */
    private function _getBaseString( string $method, string $url, array $args ) : string //
    {
        $supported_methods = [ 'GET', 'POST' ];
        $excluded_keys     = [ 'photo' ];

        $method = strtoupper($method);

        if (! in_array($method, $supported_methods) ) {

            $this->pushError("Method '$method' not supported.");

            return '';
        }

        ksort($args);

        $queryString = '';

        foreach ( $args as $key => $value ) {

            if (in_array($key, $excluded_keys) ) {
                continue;
            }

            $value = rawurlencode($value);

            $queryString .= empty($queryString) ? "{$key}={$value}" : "&{$key}={$value}"; //
        }
        
        $url    = rawurlencode($url);
        $queryString = rawurlencode($queryString);

        return "{$method}&{$url}&{$queryString}";
    }

    /**
     * Push error.
     * 
     * @param string $message Error message
     * @param string $code    Error code
     * 
     * @return void
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
        return array('errors' => $this->_errors);
    }
}