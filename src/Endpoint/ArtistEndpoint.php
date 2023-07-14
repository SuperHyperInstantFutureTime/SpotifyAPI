<?php
namespace SHIFT\Spotify\Endpoint;

use Gt\Http\RequestMethod;
use SHIFT\Spotify\Entity\Album;
use SHIFT\Spotify\Entity\Artist;
use SHIFT\Spotify\Entity\ExternalUrlsObject;
use SHIFT\Spotify\Entity\FollowersObject;
use SHIFT\Spotify\Entity\ImageObject;
use SHIFT\Spotify\Entity\IncludeGroups;
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
		?IncludeGroups $includeGroups = null,
		?string $market = null,
		int $limit = 20,
		int $offset = 0,
	):AlbumPage {
		$kvp = [];
		if(!is_null($includeGroups)) {
			$kvp["include_groups"] = (string)$includeGroups;
		}
		if(!is_null($market)) {
			$kvp["market"] = $market;
		}
		$kvp["limit"] = $limit;
		$kvp["offset"] = $offset;

		$json = $this->client->request("artists/$id/albums", RequestMethod::GET, $kvp);
		$items = [];
		foreach($json->getArray("items") as $item) {
			array_push($items, $this->albumFactory->fromJsonObject($item));
		}
		return new AlbumPage(
			$json->getString("href"),
			$json->getInt("limit"),
			$json->getString("next"),
			$json->getInt("offset"),
			$json->getString("previous"),
			$json->getInt("total"),
			$items,
		);
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
