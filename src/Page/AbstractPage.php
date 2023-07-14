<?php
namespace SHIFT\Spotify\Page;

use Gt\Json\JsonObject;
use SHIFT\Spotify\Entity\AbstractEntity;

abstract class AbstractPage {
	/** @param array<AbstractEntity> $items */
	public function __construct(
		public string $href,
		public int $limit,
		public ?string $next,
		public int $offset,
		public ?string $previous,
		public int $total,
		public array $items,
	) {}
}
