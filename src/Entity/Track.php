<?php
namespace SHIFT\Spotify\Entity;

readonly class Track extends AbstractEntity {
	/**
	 * @param array<artist> $artists
	 * @param array<string> $availableMarkets
	 */
	public function __construct(
		public ?Album $album,
		public array $artists,
		public array $availableMarkets,
		public int $discNumber,
		public int $durationMilliseconds,
		public bool $explicit,
		public ExternalIdsObject $externalIds,
		public ExternalUrlsObject $externalUrlsObject,
		public string $href,
		public string $id,
		public ?bool $isPlayable,
		public ?TrackLink $linkedFrom,
		public ?RestrictionsObject $restrictions,
		public string $name,
		public int $popularity,
		public ?string $previewUrl,
		public int $trackNumber,
		public string $uri,
		public bool $isLocal,
	) {}
}
