<?php

/**
 * Creation Date: 27/02/2018
 * Description:   
 * 
 * Version:       1.0.0
 * Last Modified: 27/02/2018
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

if (! class_exists(__NAMESPACE__ . '\Flickr') ) {

    include_once 'inc/common.php';
    include_once 'inc/request-token.php';
    include_once 'inc/rest.php';
    include_once 'inc/upload.php';

    class Flickr
    {
        private $_key;
        private $_secret;
        private $_access_token;
        private $_access_token_secret;

        /**
         * Construct function
         * 
         * @param string $consumer_key_or_key description
         * @param string $secret              description
         * @param string $access_token        description
         * @param string $access_token_secret description
         */
        public function __construct( string $consumer_key_or_key, string $secret, string $access_token = '', string $access_token_secret = '' )
        {
            
        }
    }
}
