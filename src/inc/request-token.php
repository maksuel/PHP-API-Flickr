<?php

/*
Author:        Maksuel Boni
Author URI:    https://maks.com.br
Creation Date: 22/03/2018
Description:   

Version:       1.0.0
Last Modified: 22/03/2018
*/

namespace MAKS\API\Flickr;

if (! class_exists(__NAMESPACE__ . '\request_token' ) ) {
    class RequestToken extends common
    {
        const URL = 'https://www.flickr.com/services/oauth/request_token';

    }
}