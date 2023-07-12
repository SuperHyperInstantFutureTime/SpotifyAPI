<?php
namespace SHIFT\Spotify\Entity;

use Gt\Json\JsonKvpObject;

readonly class TrackLink extends AbstractEntity {
	public function __construct(
		public ExternalUrlsObject $externalUrls,
		public string $href,
		public string $id,
		public string $uri,
	) {
	}
}
