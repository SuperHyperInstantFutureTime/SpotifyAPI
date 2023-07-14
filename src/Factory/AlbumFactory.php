<?php
namespace SHIFT\Spotify\Factory;

use DateTimeImmutable;
use SHIFT\Spotify\Entity\Album;
use SHIFT\Spotify\Entity\AlbumType;
use SHIFT\Spotify\Entity\Artist;
use SHIFT\Spotify\Entity\DatePrecision;
use SHIFT\Spotify\Entity\ExternalIdsObject;
use SHIFT\Spotify\Entity\ExternalUrlsObject;
use SHIFT\Spotify\Entity\ImageObject;
use SHIFT\Spotify\Entity\RestrictionsObject;
use Gt\Json\JsonObject;

class AlbumFactory extends AbstractFactory {
	/** @param array<Artist> $artists */
	public function fromJsonObject(
		JsonObject $json,
		array $artists = [],
		array $tracks = [],
	):Album {
		$images = [];
		/** @var JsonObject $image */
		foreach($json->getArray("images") as $image) {
			array_push($images, new ImageObject(
				$image->getString("url"),
				$image->getInt("height"),
				$image->getInt("width"),
			));
		}
		$copyrights = [];

		$externalIds = null;
		if($externalIdsJson = $json->get("external_ids")) {
			$externalIds = new ExternalIdsObject(
				$externalIdsJson->getString("isrc"),
				$externalIdsJson->getString("ean"),
				$externalIdsJson->getString("upc"),
			);
		}

		$restrictions = null;
		if($restrictionsJson = $json->getObject("restrictions")) {
			$restrictions = new RestrictionsObject(
				$restrictionsJson->getString("reason"),
			);
		}

		return new Album(
			AlbumType::fromString($json->getString("album_type")),
			$json->getInt("total_tracks"),
			$json->getArray("available_markets", "string"),
			new ExternalUrlsObject($json->getObject("external_urls")),
			$json->getString("href"),
			$json->getString("id"),
			$images,
			$json->getString("name"),
			new DateTimeImmutable($json->getString("release_date")),
			DatePrecision::fromString($json->getString("release_date_precision")),
			$restrictions,
			$json->getString("uri"),
			$copyrights,
			$externalIds,
			$json->getArray("genres", "string"),
			$json->getString("label"),
			$json->getInt("popularity"),
			$artists,
			$tracks,
		);
	}

}
