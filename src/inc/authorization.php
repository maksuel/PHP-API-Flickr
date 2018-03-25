<?php

/**
 * Authorization class.
 * 
 * Deal with Authorization Token and Privileges.
 * Can build an URL to anchor Flickr's page to authorize application.
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

class Authorization extends Common // phpcs:ignore
{
    const URL = 'https://www.flickr.com/services/oauth/authorize';

    private $_token      = '';
    private $_privileges = '';

    /**
     * Construct method
     * 
     * @param string $token 
     * @param string $privileges 
     */
    public function __construct( string $token, string $privileges = '' )
    {
        $this->setToken($token);
        $this->setPrivileges($privileges);
    }



    // SETTERs

    /**
     * Set Authorization Token
     * 
     * @param string $token example: 72157626737672178-022bbd2f4c2f3432
     * 
     * @return void
     */
    public function setToken( string $token )
    {
        $token = explode('-', $token);

        if (sizeof($token) !== 2) {

            $this->pushError(
                "Invalid Authorization Token format."
            );

            return;
        }

        $token[0] = $this->filterNumbersString($token[0], 17);
        $token[1] = $this->filterHexadecimalString($token[1], 16);

        if (empty($token[0]) || empty($token[1]) ) {

            $this->pushError(
                "Error on sanitize Authorization Token."
            );

        } else {

            $this->_token = implode('-', $token);
        }
    }

    /**
     * Set Authorization Privileges
     * 
     * @param string $privileges read, write or delete
     * 
     * @return void
     */
    public function setPrivileges( string $privileges )
    {
        $defaults = ['read', 'write', 'delete'];

        $privileges   = strtolower($privileges);
        $isInDefaults = in_array($privileges, $defaults);

        if (empty($privileges) || ! $isInDefaults) {

            $this->_privileges = $defaults[0];

        } else {

            $this->_privileges = $privileges;
        }
    }



    // GETTERs

    /**
     * Get Authorization Token
     * 
     * @return string
     */
    public function getToken() : string
    {
        return $this->_token;
    }

    /**
     * Get Authorization Privileges
     * 
     * @return string
     */
    public function getPrivileges() : string
    {
        return $this->_privileges;
    }

    /**
     * Get Authorization Url
     * 
     * @return string
     */
    public function getUrl() : string
    {
        $args = array(
            'oauth_token' => $this->getToken(),
            'perms'       => $this->getPrivileges()
        );

        return $this->buildUrl(self::URL, $args);
    }
}