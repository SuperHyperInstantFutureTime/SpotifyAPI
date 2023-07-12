<?php
namespace SHIFT\Spotify\Endpoint;

use DateTimeImmutable;
use SHIFT\Spotify\Entity\Album;
use SHIFT\Spotify\Entity\AlbumType;
use SHIFT\Spotify\Entity\Artist;
use SHIFT\Spotify\Entity\CopyrightObject;
use SHIFT\Spotify\Entity\DatePrecision;
use SHIFT\Spotify\Entity\ExternalIdsObject;
use SHIFT\Spotify\Entity\ExternalUrlsObject;
use SHIFT\Spotify\Entity\ImageObject;
use SHIFT\Spotify\Entity\RestrictionsObject;
use SHIFT\Spotify\Page\AlbumPage;
use SHIFT\Spotify\Page\TrackPage;

class AlbumEndpoint extends AbstractEndpoint {
	public function get(
		string $id,
		?string $market = null,
	):Album {
		$json = $this->client->request("albums/$id");

		$artists = [];
		foreach($json->getArray("artists") as $artist) {
			array_push($artists, $this->artistFactory->fromJsonObject($artist));
		}

		return $this->albumFactory->fromJsonObject($json, $artists);
	}

	/**
	 * @param array<string> $idList
	 * @return array<Album>
	 */
	public function getSeveral(
		array $idList,
		?string $market = null,
	):array {

	}

	public function getTracks(
		string $id,
		?string $market = null,
		int $limit = 20,
		int $offset = 0,
	):TrackPage {

	}

	public function getUserSaved(
		int $limit = 20,
		int $offset = 0,
		?string $market = null,
	):AlbumPage {

	}

	/** @param array<string> $idList */
	public function saveForUser(array $idList):void {

	}

	/** @param array<string> $idList */
	public function removeUserSaved(array $idList):void {

	}

	/**
	 * @param array<string> $idList
	 * @return array<bool>
	 */
	public function checkUserSaved(array $idList):array {

	}

	public function getNewReleases(
		?string $country = null,
		int $limit = 10,
		int $offset = 0,
	):AlbumPage {

	}
}
