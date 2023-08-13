<?php
namespace SHIFT\Spotify;

use DateTime;
use Gt\Http\URLSearchParams;
use Gt\Json\JsonPrimitive\JsonNullPrimitive;
use SHIFT\Spotify\Endpoint\AlbumEndpoint;
use SHIFT\Spotify\Endpoint\ArtistEndpoint;
use SHIFT\Spotify\Endpoint\SearchEndpoint;
use SHIFT\Spotify\Endpoint\TrackEndpoint;
use SHIFT\Spotify\Factory\AlbumFactory;
use SHIFT\Spotify\Factory\ArtistFactory;
use SHIFT\Spotify\Factory\TrackFactory;
use Gt\Fetch\Http;
use Gt\Http\FormData;
use Gt\Http\RequestMethod;
use Gt\Http\Response;
use Gt\Json\JsonDecodeException;
use Gt\Json\JsonObject;
use Throwable;

class SpotifyClient {
	const BASE_ENDPOINT = "https://api.spotify.com/v1/";

	public readonly ArtistEndpoint $artists;
	public readonly AlbumEndpoint $albums;
	public readonly TrackEndpoint $tracks;
	public readonly SearchEndpoint $search;

	private Http $http;
	private ?AccessToken $accessToken;
	private JsonObject $jsonObjectResponse;

	public function __construct(
		string $clientID,
		string $clientSecret,
		?Http $httpClient = null,
		?AccessTokenFactory $accessTokenFactory = null,
		?AlbumFactory $albumFactory = null,
		?ArtistFactory $artistFactory = null,
		?TrackFactory $trackFactory = null,
		bool $automaticallyAuthenticate = true,
	) {
		$this->http = $httpClient ?? new Http();
		$albumFactory = $albumFactory ?? new AlbumFactory();
		$artistFactory = $artistFactory ?? new ArtistFactory();
		$trackFactory = $trackFactory ?? new TrackFactory();

		$accessTokenFactory = $accessTokenFactory ?? new AccessTokenFactory();
		$this->accessToken = $accessTokenFactory->load();

		if($this->accessToken?->isAlive()) {
			echo "Token still alive", PHP_EOL;
		}
		else {
			if($automaticallyAuthenticate) {
				echo "Generating new Access Token ...", PHP_EOL;
				$this->requestNewAccessToken($clientID, $clientSecret);
				$accessTokenFactory->save($this->accessToken);
			}
			else {
				echo "Requires token generation.", PHP_EOL;
				return;
			}
		}

		$this->artists = new ArtistEndpoint(
			$this,
			$albumFactory,
			$artistFactory,
			$trackFactory,
		);
		$this->albums = new AlbumEndpoint(
			$this,
			$albumFactory,
			$artistFactory,
			$trackFactory,
		);
		$this->tracks = new TrackEndpoint(
			$this,
			$albumFactory,
			$artistFactory,
			$trackFactory,
		);
		$this->search = new SearchEndpoint(
			$this,
			$albumFactory,
			$artistFactory,
			$trackFactory,
		);
	}

	private function requestNewAccessToken(string $clientID, string $clientSecret):void {
		$jsonObject = $this->request(
			"https://accounts.spotify.com/api/token",
			RequestMethod::POST,
			[
				"grant_type" => "client_credentials",
				"client_id" => $clientID,
				"client_secret" => $clientSecret,
			],
		);
		$this->accessToken = new AccessToken(
			$jsonObject->getString("access_token") ?? "",
			$jsonObject->getString("token_type") ?? "",
			new DateTime("+" . ($jsonObject->getInt("expires_in") ?? "0") . " seconds"),
		);

	}

	public function request(string $endpoint, RequestMethod $method = RequestMethod::GET, ?array $kvp = null):JsonObject {
		echo "Requesting $endpoint ... ", PHP_EOL;
		$return = null;

		if(!str_contains($endpoint, "://")) {
			$endpoint = self::BASE_ENDPOINT . $endpoint;
		}

		$init = [
			"method" => $method->name,
			"headers" => [],
		];
		if($kvp) {
			if($method === RequestMethod::GET) {
				$query = new URLSearchParams($kvp);
				$endpoint .= "?$query";
			}
			else {
				$formData = new FormData();
				foreach($kvp as $key => $value) {
					$formData->set($key, $value);
				}

				$init["body"] = (string)$formData;
				$init["headers"]["Content-type"] = "application/x-www-form-urlencoded";
			}
		}

		if($this->accessToken && !str_contains($endpoint, "https://accounts.spotify.com")) {
			$init["headers"]["Authorization"] = (string)$this->accessToken;
		}

// TODO: cache requests for an hour at this point.
// @codeCoverageIgnoreStart
		$this->http->fetch($endpoint, $init)
			->then(function(Response $response) {
				if(!$response->ok) {
					throw new SpotifyException("Error connecting to Spotify API (HTTP $response->status)");
				}

				return $response->json();
			})->then(function(JsonObject $jsonObject) {
				$this->jsonObjectResponse = $jsonObject;
			});
// @codeCoverageIgnoreEnd

		$this->http->wait();
		return $this->jsonObjectResponse ?? new JsonNullPrimitive();
	}
}
