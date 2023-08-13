<?php
namespace SHIFT\Spotify\Endpoint;

use Gt\Http\RequestMethod;
use Gt\Json\JsonObject;
use SHIFT\Spotify\Entity\SearchFilter;
use SHIFT\Spotify\Entity\SearchResult;
use SHIFT\Spotify\Page\AbstractPage;
use SHIFT\Spotify\Page\AlbumPage;
use SHIFT\Spotify\Page\ArtistPage;
use SHIFT\Spotify\Page\TrackPage;

class SearchEndpoint extends AbstractEndpoint {
	public function query(
		string $query,
		SearchFilter $searchType,
		?string $market = null,
		int $limit = 20,
		int $offset = 0,
		?string $includeExternal = null,
	):SearchResult {
		$params = [
			"q" => $query,
			"type" => (string)$searchType,
			"limit" => $limit,
			"offset" => $offset,
		];
		if($market) {
			$params["market"] = $market;
		}
		if($includeExternal) {
			$params["include_external"] = $includeExternal;
		}

		$json = $this->client->request("search", RequestMethod::GET, $params);
		$tracks = null;
		if($tracksJson = $json->getObject("tracks")) {
			$tracks = $this->constructPage(
				TrackPage::class,
				$tracksJson->getString("href"),
				$tracksJson->getInt("limit"),
				$tracksJson->getString("next"),
				$tracksJson->getInt("offset"),
				$tracksJson->getString("previous"),
				$tracksJson->getInt("total"),
				$tracksJson->getArray("items"),
			);
		}
		$artists = null;
		if($artistsJson = $json->getObject("artists")) {
			$artists = $this->constructPage(
				ArtistPage::class,
				$artistsJson->getString("href"),
				$artistsJson->getInt("limit"),
				$artistsJson->getString("next"),
				$artistsJson->getInt("offset"),
				$artistsJson->getString("previous"),
				$artistsJson->getInt("total"),
				$artistsJson->getArray("items"),
			);
		}
		$albums = null;
		if($albumsJson = $json->getObject("albums")) {
			$albums = $this->constructPage(
				AlbumPage::class,
				$albumsJson->getString("href"),
				$albumsJson->getInt("limit"),
				$albumsJson->getString("next"),
				$albumsJson->getInt("offset"),
				$albumsJson->getString("previous"),
				$albumsJson->getInt("total"),
				$albumsJson->getArray("items"),
			);
		}
		$playlists = null;
		if($playlistsJson = $json->getObject("playlists")) {
			$playlists = $this->constructPage(
				PlaylistPage::class,
				$playlistsJson->getString("href"),
				$playlistsJson->getInt("limit"),
				$playlistsJson->getString("next"),
				$playlistsJson->getInt("offset"),
				$playlistsJson->getString("previous"),
				$playlistsJson->getInt("total"),
				$playlistsJson->getArray("items"),
			);
		}
		$shows = null;
		if($showsJson = $json->getObject("shows")) {
			$shows = $this->constructPage(
				ShowPage::class,
				$showsJson->getString("href"),
				$showsJson->getInt("limit"),
				$showsJson->getString("next"),
				$showsJson->getInt("offset"),
				$showsJson->getString("previous"),
				$showsJson->getInt("total"),
				$showsJson->getArray("items"),
			);
		}
		$episodes = null;
		if($episodesJson = $json->getObject("episodes")) {
			$episodes = $this->constructPage(
				EpisodePage::class,
				$episodesJson->getString("href"),
				$episodesJson->getInt("limit"),
				$episodesJson->getString("next"),
				$episodesJson->getInt("offset"),
				$episodesJson->getString("previous"),
				$episodesJson->getInt("total"),
				$episodesJson->getArray("items"),
			);
		}
		$audiobooks = null;
		if($audiobooksJson = $json->getObject("audiobooks")) {
			$audiobooks = $this->constructPage(
				AudiobookPage::class,
				$audiobooksJson->getString("href"),
				$audiobooksJson->getInt("limit"),
				$audiobooksJson->getString("next"),
				$audiobooksJson->getInt("offset"),
				$audiobooksJson->getString("previous"),
				$audiobooksJson->getInt("total"),
				$audiobooksJson->getArray("items"),
			);
		}

		return new SearchResult($tracks, $artists, $albums, $playlists, $shows, $episodes, $audiobooks);
	}

	/**
	 * @template T
	 * @param class-string<T> $className
	 * @param array<JsonObject> $items
	 * @return T
	 */
	private function constructPage(
		string $className,
		string $href,
		int $limit,
		?string $next,
		int $offset,
		?string $previous,
		int $total,
		array $items,
	):AbstractPage {
		$entityFactory = match($className) {
			TrackPage::class => $this->trackFactory,
			ArtistPage::class => $this->artistFactory,
			AlbumPage::class => $this->albumFactory,
		};
		$entityList = [];
		foreach($items as $item) {
			array_push($entityList, $entityFactory->fromJsonObject($item));
		}

		return new $className(
			$href,
			$limit,
			$next,
			$offset,
			$previous,
			$total,
			$entityList,
		);
	}

}
