<?php
namespace SHIFT\Spotify\Endpoint;

use SHIFT\Spotify\Entity\Track;
use SHIFT\Spotify\Page\TrackPage;

class TrackEndpoint extends AbstractEndpoint {
	public function get(
		string $id,
		?string $market = null
	):Track {
		$json = $this->client->request("tracks/$id");
		$album = $this->albumFactory->fromJsonObject($json->getObject("album"));
		$artists = [];
		foreach($json->getArray("artists") as $artistJson) {
			array_push($artists, $this->artistFactory->fromJsonObject($artistJson));
		}
		return $this->trackFactory->fromJsonObject($json, $album, $artists);
	}

	/**
	 * @param array<string> $idList
	 * @return array<Track>
	 */
	public function getSeveral(
		array $idList,
		?string $market = null,
	):array {

	}

	public function getUserSaved():TrackPage {

	}

	public function saveForUser(
		string...$idList,
	):void {

	}

	public function removeUserSaved(
		string...$idList,
	):void {

	}

	public function checkUserSaved(
		string...$idList,
	):array {

	}

	public function getAudioFeatures(
		string...$idList,
	):AudioFeatures {

	}

	public function getAudioAnalysis(
		string $id,
	):AudioAnalysis {

	}

	public function getRecommendations(string $id):RecommendationSet {}
}
