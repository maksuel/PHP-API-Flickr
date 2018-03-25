<?php

/**
 * Flickr class.
 * 
 * PHP version 7
 * 
 * @category API
 * @package  FlickrAPI
 * @author   Maksuel Boni <me@maks.com.br>
 * @license  https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @link     https://github.com/maksuel
 */
namespace MAKS\API;

require_once 'inc/common.php';
require_once 'inc/request-token.php';
require_once 'inc/authorization.php';
require_once 'inc/access-token.php';
// require_once 'inc/rest.php';

class Flickr // phpcs:ignore
{
    private $_RequestTokenInstance;
    private $_AuthorizationInstance;
    private $_AccessTokenInstance;
    private $_RestInstance;

    /**
     * Construct method.
     * 
     * @param string $key 
     * @param string $secret 
     * @param string $tokenOrCallbackUrl  
     * @param string $tokenSecret 
     */
    public function __construct( string $key, string $secret, string $tokenOrCallbackUrl = '', string $tokenSecret = '' ) //
    {
        if (empty($token) || empty($tokenSecret) ) {

            $this->setRequestTokenInstance($key, $secret, $tokenOrCallbackUrl);

        } else {

            // TODO: if has all params, create instance to rest API
        }
    }

    /**
     * Alias for getAuthorizationUrl() in RequestToken class
     * 
     * @param string $privileges 
     * 
     * @return string
     */
    public function getAuthorizationUrl( string $privileges ) : string
    {
        $requestToken = $this->getRequestTokenInstance();

        if (! $requestToken) {

            return ''; // TODO: define error return
        }

        $response = $requestToken->getAuthorization();

        if (isset($response['oauth_callback_confirmed'])
            && $response['oauth_callback_confirmed'] == true
            && isset($response['oauth_token'])
            && isset($response['oauth_token_secret'])
        ) {
            $this->setAuthorizationInstance($response['oauth_token'], $privileges);

            $Authorization = $this->getAuthorizationInstance();



            var_dump($Authorization->getUrl());

            return '';

        } else {

            return ''; // TODO: define error return
        }
    }



    // SETTERs

    /**
     * Set Request Token Instance
     * 
     * @param string $key 
     * @param string $secret 
     * @param strign $callbackUrl 
     * 
     * @return void
     */
    public function setRequestTokenInstance( string $key, string $secret, string $callbackUrl ) //
    {
        $this->_RequestTokenInstance = new Flickr\RequestToken($key, $secret, $callbackUrl); //
    }

    /**
     * Set Authorization Instance
     * 
     * @param string $token 
     * @param string $privileges 
     * 
     * @return void
     */
    public function setAuthorizationInstance( string $token, string $privileges )
    {
        $this->_AuthorizationInstance = new Flickr\Authorization($token, $privileges); //
    }



    // GETTERs

    /**
     * Get Request Token Instance.
     * 
     * @return RequestToken|null
     */
    public function getRequestTokenInstance()
    {
        return $this->_RequestTokenInstance;
    }

    /**
     * Get Authorization Instance.
     * 
     * @return Authorization|null
     */
    public function getAuthorizationInstance()
    {
        return $this->_AuthorizationInstance;
    }
}
