<?php
namespace SHIFT\Spotify;

use DateTime;
use DateTimeInterface;
use Stringable;

readonly class AccessToken implements Stringable {
	public function __construct(
		public string $token,
		public string $type,
		public DateTimeInterface $expiresAt,
	) {}

	public function isAlive():bool {
		$now = new DateTime();
		return $this->expiresAt > $now;
	}

	public function __toString():string {
		return "$this->type $this->token";
	}
}
