<?php
namespace SHIFT\Spotify\Entity;

readonly class RestrictionsObject extends AbstractEntity {
	public function __construct(
		public string $reason
	) {}
}
