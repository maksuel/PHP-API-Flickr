<?php

/*
Author:        Maksuel Boni
Author URI:    https://maks.com.br
Creation Date: 27/02/2018
Description:   

Version:       1.0.0
Last Modified: 27/02/2018
*/

namespace MAKS\API;

if( !class_exists( __NAMESPACE__ . '\Flickr' ) )
{
    require_once('common.php');
    require_once('rest.php');
    require_once('upload.php');

    class Flickr extends common
    {
        private $key;
        private $secret;
        private $access_token;
        private $access_token_secret;

        public function __construct( string $consumer_key_or_key, string $secret, string $access_token = '', string $access_token_secret = '' )
        {
            
        }
    }
}
