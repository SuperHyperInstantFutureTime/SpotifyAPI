<?php
namespace SHIFT\Spotify\Endpoint;

use SHIFT\Spotify\Entity\Album;
use SHIFT\Spotify\Entity\Artist;
use SHIFT\Spotify\Entity\ExternalUrlsObject;
use SHIFT\Spotify\Entity\FollowersObject;
use SHIFT\Spotify\Entity\ImageObject;
use SHIFT\Spotify\Entity\Track;
use SHIFT\Spotify\Page\AlbumPage;

class ArtistEndpoint extends AbstractEndpoint {
	public function get(string $id):Artist {
		$json = $this->client->request("artists/$id");
		return $this->artistFactory->fromJsonObject($json);
	}

	/** @return array<Artist> */
	public function getSeveral(array $idList):array {

	}

	/**
	 * @param ?array<string> $includeGroups
	 */
	public function getAlbums(
		string $id,
		?array $includeGroups = null,
		?string $market = null,
		int $limit = 20,
		int $offset = 0,
	):AlbumPage {

	}

	/** @return array<Track> */
	public function getTopTracks(
		string $id,
		?string $market = null,
	):array {

	}

	/** @return array<Artist> */
	public function getRelatedArtists(
		string $id,
	):array {

	}
}
