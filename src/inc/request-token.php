<?php

/**
 * Request Token class.
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

class RequestToken extends Common // phpcs:ignore
{
    const URL = 'https://www.flickr.com/services/oauth/request_token';

    private $_key;
    private $_secret;

    /**
     * Construct method.
     * 
     * @param string $key    Flickr APP Key
     * @param string $secret Flickr APP Secret
     */
    public function __construct( string $key, string $secret )
    {
        $this->setKeys($key, $secret);
    }

    /**
     * Set Request Token key and Rquest Token secret.
     * 
     * @param string $key    Flickr APP Key
     * @param string $secret Flickr APP Secret
     * 
     * @return bool
     */
    public function setKeys( string $key, string $secret ) : bool
    {
        $key    = $this->checkHexadecimalKey($key, 32);
        $secret = $this->checkHexadecimalKey($secret, 16);

        if ($key && $secret) {

            $this->$_key    = $key;
            $this->$_secret = $secret;

            return true;

        } else {

            $this->pushError('Request Token $key and $secret not setted.');

            return false;
        }
    }

    /**
     * Get Request Token key.
     * 
     * @return string
     */
    public function getKey() : string
    {
        return $this->_key;
    }

    /**
     * Get Request Token secret.
     * 
     * @return string
     */
    public function getSecret() : string
    {
        return $this->_secret;
    }

    /**
     * Get Request Token array
     * 
     * @param string $callbackUrl must be a valid url
     * 
     * @return array
     */
    public function getRequestToken( string $callbackUrl ) : array
    {
        // check callbackUrl
        //

    }
}