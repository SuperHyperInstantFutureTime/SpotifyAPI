<?php
namespace SHIFT\Spotify\Entity;

readonly class Artist extends AbstractEntity {
	/**
	 * @param array<ImageObject> $images
	 */
	public function __construct(
		public ExternalUrlsObject $externalUrls,
		public ?FollowersObject $followers,
		public ?array $genres,
		public string $href,
		public string $id,
		public ?array $images,
		public string $name,
		public ?int $popularity,
		public string $uri,
	) {}
}
