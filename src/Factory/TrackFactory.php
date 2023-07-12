<?php
namespace SHIFT\Spotify\Factory;

use SHIFT\Spotify\Entity\AbstractEntity;
use SHIFT\Spotify\Entity\Album;
use SHIFT\Spotify\Entity\ExternalIdsObject;
use SHIFT\Spotify\Entity\ExternalUrlsObject;
use SHIFT\Spotify\Entity\RestrictionsObject;
use SHIFT\Spotify\Entity\Track;
use SHIFT\Spotify\Entity\TrackLink;
use Gt\Json\JsonObject;

class TrackFactory extends AbstractFactory {
	public function fromJsonObject(
		JsonObject $json,
		?Album $album = null,
		?array $artists = null,
	):Track {
		$externalIdsJson = $json->getObject("external_ids");
		$externalIds = new ExternalIdsObject(
			$externalIdsJson->getString("isrc"),
			$externalIdsJson->getString("ean"),
			$externalIdsJson->getString("upc"),
		);
		$linkedFrom = null;
		if($linkedFromJson = $json->getObject("linked_from")) {
			$linkedFrom = new TrackLink(
				new ExternalUrlsObject($linkedFromJson->getObject("external_urls")),
				$linkedFromJson->getString("href"),
				$linkedFromJson->getString("id"),
				$linkedFromJson->getString("uri"),
			);
		}
		$restrictions = null;
		if($restrictionsJson = $json->getObject("restrictions")) {
			$restrictions = new RestrictionsObject($restrictionsJson->getString("reason"));
		}

		return new Track(
			$album,
			$artists,
			$json->getArray("available_markets", "string"),
			$json->getInt("disc_number"),
			$json->getInt("duration_ms"),
			$json->getBool("explicit"),
			$externalIds,
			new ExternalUrlsObject($json->getObject("external_urls")),
			$json->getString("href"),
			$json->getString("id"),
			$json->getbool("is_playable"),
			$linkedFrom,
			$restrictions,
			$json->getString("name"),
			$json->getInt("popularity"),
			$json->getString("preview_url"),
			$json->getInt("track_number"),
			$json->getString("uri"),
			$json->getBool("is_local"),
		);
	}
}
