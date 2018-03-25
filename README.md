# PHP-API-Flickr

Usage:

The first step to obtaining authorization for a user is to get a Request Token using your Consumer Key. This is a temporary token that will be used to authenticate the user to your application. This token, along with a token secret, will later be exchanged for an Access Token.

Instance new RequestToken() passing a valid Flickr APP Key and Flickr APP Secret to construct method.
After, call the method getAuthorization() with a valid callback url. This method will return an array of response.
check if there are any errors using the key isset( array["errors"] )