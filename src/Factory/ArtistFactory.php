<?php
namespace SHIFT\Spotify\Factory;

use SHIFT\Spotify\Entity\Artist;
use SHIFT\Spotify\Entity\ExternalUrlsObject;
use SHIFT\Spotify\Entity\FollowersObject;
use SHIFT\Spotify\Entity\ImageObject;
use Gt\Json\JsonObject;

class ArtistFactory extends AbstractFactory {
	public function fromJsonObject(JsonObject $json):Artist {
		$followers = null;
		if($followersJson = $json->getObject("followers")) {
			$followers = new FollowersObject(
				$followersJson->getString("href"),
				$followersJson->getInt("total"),
			);
		}
		$genres = null;
		if($json->contains("genres")) {
			$genres = $json->getArray("genres", "string");
		}

		$images = null;
		if($json->contains("images")) {
			$images = [];
			/** @var JsonObject $imageJsonItem */
			foreach($json->getArray("images") as $imageJsonItem) {
				array_push($images, new ImageObject(
					$imageJsonItem->getString("url"),
					$imageJsonItem->getInt("height"),
					$imageJsonItem->getInt("width"),
				));
			}
		}

		return new Artist(
			new ExternalUrlsObject($json->getObject("external_urls")),
			$followers,
			$genres,
			$json->getString("href"),
			$json->getString("id"),
			$images,
			$json->getString("name"),
			$json->getInt("popularity"),
			$json->getString("uri"),
		);
	}
}
