<?php

/**
 * Request Token class.
 * 
 * Can get a valid token to authorize an application.
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

    private $_key         = '';
    private $_secret      = '';
    private $_callbackUrl = '';

    /**
     * Construct method.
     * 
     * @param string $key 
     * @param string $secret 
     * @param string $callbackUrl 
     */
    public function __construct( string $key, string $secret, string $callbackUrl )
    {
        $this->setKey($key);
        $this->setSecret($secret);
        $this->setCallbackUrl($callbackUrl);
    }

    /**
     * Get Authorization response.
     * 
     * @return array
     */
    public function getAuthorization() : array
    {
        $url = $this->buildUrl(
            self::URL,
            $this->getRequestArgs(
                'GET',
                self::URL,
                array(
                    'oauth_callback' => $this->getCallbackUrl()
                ),
                $this->getKey(),
                $this->getSecret()
            )
        );

        $response = $this->remoteGet($url);

        if (isset($response['body']) ) {

            parse_str($response['body'], $body);

            return $body;

        } else {

            return $this->getErrors();
        }
    }    



    // SETTERs

    /**
     * Set Request Token key.
     * 
     * @param string $key 
     * 
     * @return void
     */
    public function setKey( string $key )
    {
        $this->_key = $this->filterHexadecimalString($key, 32);
    }

    /**
     * Set Request Token secret.
     * 
     * @param string $secret 
     * 
     * @return void
     */
    public function setSecret( string $secret )
    {
        $this->_secret = $this->filterHexadecimalString($secret, 16);
    }

    /**
     * Set Request Token callback url.
     * 
     * @param string $callbackUrl 
     * 
     * @return void
     */
    public function setCallbackUrl( string $callbackUrl )
    {
        $this->_callbackUrl = $this->filterValidUrl($callbackUrl);
    }



    // GETTERs

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
     * Get Request Token callback url.
     * 
     * @return string
     */
    public function getCallbackUrl() : string
    {
        return $this->_callbackUrl;
    }
}