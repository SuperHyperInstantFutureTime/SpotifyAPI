<?php
namespace SHIFT\Spotify\Entity;

readonly class FollowersObject extends AbstractEntity {
	public function __construct(
		public ?string $href,
		public int $total,
	) {}
}
