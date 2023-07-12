<?php
namespace SHIFT\Spotify\Entity;

readonly class ExternalIdsObject extends AbstractEntity {
	public function __construct(
		public ?string $isrc,
		public ?string $ean,
		public ?string $upc,
	) {}
}
