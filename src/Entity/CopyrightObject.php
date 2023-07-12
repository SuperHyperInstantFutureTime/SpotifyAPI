<?php
namespace SHIFT\Spotify\Entity;

readonly class CopyrightObject extends AbstractEntity {
	public function __construct(
		public string $text,
		public CopyrightType $type,
	) {}
}
