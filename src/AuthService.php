<?php 
namespace sahusoftcom\YoutubeApi;

use Log;
use Exception;

/**
*  Api Service For Auth
*/
class AuthService 
{	
	protected $client;

	public function __construct()
	{
		$this->client = new \Google_Client;

		$this->client->setClientId(\Config::get('google.client_id'));
		$this->client->setClientSecret(\Config::get('google.client_secret'));
		$this->client->setDeveloperKey(\Config::get('google.api_key'));
		$this->client->setRedirectUri(\Config::get('google.redirect_url'));

		$this->client->setScopes([
		                             'https://www.googleapis.com/auth/youtube',
		                         ]);
		$this->client->setAccessType('offline');
		$this->client->setPrompt('consent');
	}

	/**	
	 * [getToken -generate token from response code recived on visiting the login url generated]
	 * @param  [type] $code [code for auth]
	 * @return [type]       [authorization token]
	 */
	public function getToken($code)
	{
		try {
			
			$this->client->authenticate($code);
			$token = $this->client->getAccessToken();
			return $token;

		} catch ( \Google_Service_Exception $e ) {

			Log::info('--------- GOOGLE SERVICE EXCEPTION ------------');
			Log::info(json_encode($e->getMessage()));

		} catch ( \Google_Exception $e ) {

			Log::info('--------- GOOGLE EXCEPTION ------------');
			Log::info(json_encode($e->getMessage()));
		} catch ( Exception $e ) {

			Log::info('--------- GOOGLE EXCEPTION ------------');
			Log::info(json_encode($e->getMessage()));
		} 
	}

	/**
	 * [getLoginUrl - generates the url login url to generate auth token]
	 * @param  [type] $youtube_email [account to be authenticated]
	 * @param  [type] $channelId     [return identifier]
	 * @return [type]                [auth url to generate]
	 */
	public function getLoginUrl( $youtube_email, $channelId = null )
	{	
		try
		{	
			if(!empty($channelId))
				$this->client->setState($channelId);

			$this->client->setLoginHint($youtube_email);
			$authUrl = $this->client->createAuthUrl();
			return $authUrl;

		} catch ( \Google_Service_Exception $e ) {

			Log::info('--------- GOOGLE SERVICE EXCEPTION ------------');
			Log::info(json_encode($e->getMessage()));

		} catch ( \Google_Exception $e ) {

			Log::info('--------- GOOGLE EXCEPTION ------------');
			Log::info(json_encode($e->getMessage()));
		} catch ( Exception $e ) {

			Log::info('--------- GOOGLE EXCEPTION ------------');
			Log::info(json_encode($e->getMessage()));
		} 
		
	}

}