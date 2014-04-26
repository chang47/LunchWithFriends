<?php
require_once ('yelp/OAuth.php');

class Yelp
{
	private $token;
	private $consumer;

	public function __construct($consumer_key, $consumer_secret, $token, $token_secret)
	{
		// Token object built using the OAuth library
		$this->token = new OAuthToken($token, $token_secret);

		// Consumer object built using the OAuth library
		$this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
	}

	public function request($request_name)
	{
		// For example, request business with id 'the-waterboy-sacramento'
		//$unsigned_url = "http://api.yelp.com/v2/business/the-waterboy-sacramento";

		// For examaple, search for 'tacos' in 'sf'
		$unsigned_url = 'http://api.yelp.com/v2/' . $request_name;

		// Yelp uses HMAC SHA1 encoding
		$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

		// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
		$oauthrequest = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, 'GET', $unsigned_url);

		// Sign the request
		$oauthrequest->sign_request($signature_method, $this->consumer, $this->token);

		// Get the signed URL
		$signed_url = $oauthrequest->to_url();

		// Send Yelp API Call
		$ch = curl_init($signed_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch); // Yelp response
		curl_close($ch);

		// Handle Yelp response data
		return json_decode($data);
	}
}
