<?php
session_start();
require('config.php');

//enable debugging
if(DEBUG)
{
	error_reporting(-1);
}
else
{
	error_reporting(0);
}

//includes some library
require('includes/class_yelp.php');
require('includes/facebook/facebook.php');
require('includes/functions_lunchline.php');
require('includes/functions.php');

//initialize yelp api
$yelp = new Yelp(YELP_CONSUMER_KEY, YELP_CONSUMER_SECRET, YELP_TOKEN, YELP_TOKEN_SECRET);

//initialize facebook api
$facebook = new Facebook(array(
	'appId' => FACEBOOK_APPID,
	'secret' => FACEBOOK_SECRET
));

//initailize database connection
$db = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_USERNAME, DB_PASSWORD);
if(!$db)
{
	echo 'Cannot connect to DB';
	exit;
}

//initialize user status
$user = $facebook->getUser();
if($user)
{
        try
	{
                $user_profile = $facebook->api('/me');
        }
	catch(FacebookApiException $e)
	{
                $user = null;
        }
}
