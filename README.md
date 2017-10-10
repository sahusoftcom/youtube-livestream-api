# sahusoftcom/youtube-livestream-api:
PHP (Laravel) Package for Google / YouTube API of Video Live Streaming with Google Auth

## Installation :
 
```shell
composer require sahusoftcom/youtube-livestream-api
```

Add Service provider to config/app.php provider's array:
```php
SahusoftCom\YoutubeApi\LiveStreamApiServiceProvider::class
```

Execute the following command to get the configurations:
```shell
php artisan vendor:publish --tag='youtube-config'
```

## Steps to create your google oauth credentials:

1. Goto `https://console.developers.google.com`
2. Login with your credentials & then create a new project.
3. Enable the following features while creating key
	- Youtube Data API
	- Youtube Analytics API
	- Youtube Reporting API
4. Then create `API key` from credentials tab.
5. Then in OAuth Consent Screen enter the `product name`(your site name). 
6. create credentials > select OAuth Client ID. (here you will get client_id and client_secret)
7. Then in the Authorized Javascript Origins section add `you site url`.
8. In the Authorized Redirect URLs section add `add a url which you want the auth code to return`(login callback)
9. You will get values (to be exact - client_id, client_secret & api_key) 
10. Now add these values - client_id, client_secret, api_key and login_callback in the env file.

## Setting Up the App:

#### Authentication and Authorization:

```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\AuthService;	// Add Code to call the api class
```

```php
$authServiceObject = new AuthService();
$authUrl = $authServiceObject->getLoginUrl;
```

* Now you will get $authUrl, upon redirecting to the same will ask permissions and authorization access to the required channel.
* Upon submitting the requirements, you'll get a authcode on the loginCallback URL (redirect url added as in google console) & you might have specified in .env file.
* Use this authcode to generate auth token as follows:

```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\AuthService;	// Add Code to call the api class
```

```php
$authServiceObject = new AuthService();
$authToken = $authServiceObject->getToken($authcode);
```

#### Creating a Youtube Event:

```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\YoutubeLiveEventService;	// Add Code to call the api class
```

```php
$ytEventObj = new YoutubeLiveEventService();
/**
* The broadcast response give details of the youtube_event_id,server_url and server_key(it needs to be saved), along with other details about event..
* using this information you will need to supply video stream to youtube for live streaming using encoder of your choice. 
*/
$ytEventObj->broadcast($authToken, $data);
```

#### Updating a Youtube Event:

```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\YoutubeLiveEventService;	// Add Code to call the api class
```

```php
$ytEventObj = new YoutubeLiveEventService();
/**
* The updateBroadcast response give details of the youtube_event_id,server_url and server_key. 
* The server_url and server_key gets updated in the process. (save the updated server_key and server_url).
*/
$ytEventObj->updateBroadcast($authToken, $data, $youtube_event_id);
```

#### Deleting a Youtube Event:

```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\YoutubeLiveEventService;	// Add Code to call the api class
```

```php
$ytEventObj = new YoutubeLiveEventService();
/**
 * Deleting the event requires authentication token for the channel in which the event is created and the youtube_event_id
 */
$ytEventObj->deleteEvent($authToken, $youtube_event_id);
```

#### Starting a Youtube Event Stream:
```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\YoutubeLiveEventService;	// Add Code to call the api class
```

```php
$ytEventObj = new YoutubeLiveEventService();
/**
 * $broadcastStatus - ["testing", "live"]
 * Starting the event takes place in 3 steps
 * 1. You start sending the stream to the server_url via server_key recieved as a response in creating the event using encoder of your choice.
 * 2. After starting to send the stream. Stream test is done by passing broadcastStatus="testing" and it will give response for stream status
 * 3. If Stream test is succesfull. We start live streaming the video by passing broadcastStatus="live" and in response it will give us the stream status.
 */ 
$ytEventObj->transitionEvent($authToken, $broadcastStatus);	
```

#### Stopping a Youtube Event Stream:

```php
<?php
namespace Your\App\NameSpace;

use  SahusoftCom\YoutubeApi\YoutubeLiveEventService;	// Add Code to call the api class
```

```php
$ytEventObj = new YoutubeLiveEventService();
/**
 * $broadcastStatus - ["complete"]
 * Once live streaming gets started succesfully. We can stop the streaming the video by passing broadcastStatus="complete" and in response it will give us the stream status.
 */
$ytEventObj->transitionEvent($authToken, $broadcastStatus);	// $broadcastStatus = ["complete"]
```
