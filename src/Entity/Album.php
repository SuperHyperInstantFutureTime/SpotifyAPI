<?php
namespace SHIFT\Spotify\Entity;

use DateTimeImmutable;

readonly class Album extends AbstractEntity {
	/**
	 * @param array<string> $availableMarkets
	 * @param array<ImageObject> $images
	 * @param array<CopyrightObject> $copyrights
	 * @param array<string> $genres
	 * @param array<Artist> $artists
	 * @param array<Track> $tracks
	 */
	public function __construct(
		public AlbumType $albumType,
		public int $totalTracks,
		public array $availableMarkets,
		public ExternalUrlsObject $externalUrls,
		public string $href,
		public string $id,
		public array $images,
		public string $name,
		public DateTimeImmutable $releaseDate,
		public DatePrecision $releaseDatePrecision,
		public ?RestrictionsObject $restrictions,
		public string $uri,
		public array $copyrights,
		public ?ExternalIdsObject $externalIds,
		public ?array $genres,
		public ?string $label,
		public ?int $popularity,
		public array $artists,
		public array $tracks,
	) {}
}
