# youtube-livestream-api
========================================

PHP (Laravel) Package for Google / YouTube API of Video Live Streaming with Google Auth

## Installation :
 
`composer require sahusoftcom/youtube-livestream-api`

Add ServiceProvider
`php artisan vendor:publish --provider="SahusoftCom\YoutubeApi\LiveStreamApiServiceProvider"`


## Setting Up

client_id , client_secret , and api_key for OAuth from `https://console.developers.google.com`

login with your credentials, then create a new project .
 #### enable
 - Youtube Data API, 
 - Youtube Analytics API, 
 - Youtube Reporting API.

Then, create `API key` from credentials tab. 
Then in OAuth Consent Screen enter a `product name`(your site name). 
create credentials > select OAuth Client ID. (here you will get client_id and client_secret)

Then,in the Authorized Javascript Origins add `you site url`.
In the Authorized Redirect URLs add `add a url which you want the auth code to return`(login callback)

Now add these client_id client_id , client_secret , api_key and login_callback in the env file.

## Applications

#### Authentication and Authorization
	`use  SahusoftCom\YoutubeApi\AuthService`(use the class)

	`$authServiceObject = new AuthService();`
    `$authUrl = $authServiceObject->getLoginUrl;`

Visit the $authUrl and authorize access to the required channel.

Now, you'll get a authcode on the logincallback (redirect url as in google console) url you specified in .env file.

Use this authcode to generate auth token as follows:
	`use  SahusoftCom\YoutubeApi\AuthService`(use the class)

	`$authServiceObject = new AuthService();`
	`$authToken = $authServiceObject->getToken($authcode);``$authToken = $authServiceObject->getToken($authcode);`

#### Creating a Youtube Event
	`use  SahusoftCom\YoutubeApi\YoutubeLiveEventService`(use the class)

	`$ytEventObj = new YoutubeLiveEventService();`
	`$ytEventObj->broadcast($authToken, $data);`

#### Updating a Youtube Event
	`use  SahusoftCom\YoutubeApi\YoutubeLiveEventService`(use the class)

	`$ytEventObj = new YoutubeLiveEventService();`
	`$ytEventObj->updateBroadcast($authToken, $data, $youtube_event_id);`

#### Deleting a Youtube Event
	`use  SahusoftCom\YoutubeApi\YoutubeLiveEventService`(use the class)

	`$ytEventObj = new YoutubeLiveEventService();`
	`$ytEventObj->deleteEvent($authToken, $youtube_event_id);`

#### Starting a Youtube Event Stream
	`use  SahusoftCom\YoutubeApi\YoutubeLiveEventService`(use the class)

	`$ytEventObj = new YoutubeLiveEventService();`
	`$ytEventObj->transitionEvent($authToken, $broadcastStatus);`["testing","live"]

#### Stoping a Youtube Event Stream
	`use  SahusoftCom\YoutubeApi\YoutubeLiveEventService`(use the class)

	`$ytEventObj = new YoutubeLiveEventService();`
	`$ytEventObj->transitionEvent($authToken, $broadcastStatus);`["complete"]

