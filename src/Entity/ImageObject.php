<?php
namespace SHIFT\Spotify\Entity;

readonly class ImageObject extends AbstractEntity {
	public function __construct(
		public string $url,
		public ?int $width,
		public ?int $height
	) {}
}
