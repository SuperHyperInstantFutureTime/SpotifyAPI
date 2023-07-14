<?php
namespace SHIFT\Spotify\Test;

use DateTime;
use Gt\Fetch\Http;
use Gt\Json\JsonObject;
use Gt\Promise\Promise;
use ReflectionObject;
use SHIFT\Spotify\AccessToken;
use SHIFT\Spotify\AccessTokenFactory;
use SHIFT\Spotify\SpotifyClient;
use PHPUnit\Framework\TestCase;

class SpotifyClientTest extends TestCase {
	public function testConstruct_expiredShouldAuthenticate():void {
		$httpClient = self::createMock(Http::class);
		$httpClient->expects(self::once())
			->method("fetch")
			->with("https://accounts.spotify.com/api/token", [
				"method" => "POST",
    				"headers" => [
					"Content-type" => "application/x-www-form-urlencoded"
				],
				"body" => "grant_type=client_credentials&client_id=c_id&client_secret=c_secret",
			])
			->willReturnCallback(function():Promise {
				return new Promise(fn()=>null);
			});

		$accessToken = new AccessToken("token", "type", new DateTime("-1 hour"));
		$accessTokenFactory = self::createMock(AccessTokenFactory::class);
		$accessTokenFactory->method("load")
			->willReturn($accessToken);

		new SpotifyClient(
			"c_id",
			"c_secret",
			$httpClient,
			$accessTokenFactory,
		);
	}

	public function testConstruct_validShouldNotReauthenticate():void {
		$httpClient = self::createMock(Http::class);
		$httpClient->expects(self::never())
			->method("fetch");

		$accessToken = new AccessToken("token", "type", new DateTime("+1 hour"));
		$accessTokenFactory = self::createMock(AccessTokenFactory::class);
		$accessTokenFactory->method("load")
			->willReturn($accessToken);

		new SpotifyClient(
			"c_id",
			"c_secret",
			$httpClient,
			$accessTokenFactory,
		);
	}

	public function testRequest():void {
		$httpClient = self::createMock(Http::class);
		$httpClient->expects(self::once())
			->method("fetch")
			->with("https://api.spotify.com/v1/example/123", [
				"method" => "GET",
				"headers" => [
					"Authorization" => "type token"
				],
			])
			->willReturnCallback(function():Promise {
				return new Promise(fn()=>null);
			});

		$accessToken = new AccessToken("token", "type", new DateTime("-1 hour"));
		$accessTokenFactory = self::createMock(AccessTokenFactory::class);
		$accessTokenFactory->method("load")
			->willReturn($accessToken);

		$sut = new SpotifyClient(
			"c_id",
			"c_secret",
			$httpClient,
			$accessTokenFactory,
			automaticallyAuthenticate: false,
		);

		$mockResponse = self::createMock(JsonObject::class);
		$refObj = new ReflectionObject($sut);
		$refProp = $refObj->getProperty("jsonObjectResponse");
		$refProp->setValue($sut, $mockResponse);

		$sut->request("example/123");
	}

	public function testRequest_getWithQueryString():void {
		$httpClient = self::createMock(Http::class);
		$httpClient->expects(self::once())
			->method("fetch")
			->with("https://api.spotify.com/v1/example/123?key1=value1&key2=value2", [
				"method" => "GET",
				"headers" => [
					"Authorization" => "type token"
				],
			]);

		$accessToken = new AccessToken("token", "type", new DateTime());
		$accessTokenFactory = self::createMock(AccessTokenFactory::class);
		$accessTokenFactory->method("load")
			->willReturn($accessToken);
		$sut = new SpotifyClient(
			"c_id",
			"c_secret",
			$httpClient,
			$accessTokenFactory,
			automaticallyAuthenticate: false,
		);
		$sut->request("example/123", kvp: [
			"key1" => "value1",
			"key2" => "value2",
		]);
	}
}
