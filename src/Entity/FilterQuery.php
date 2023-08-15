<?php
namespace SHIFT\Spotify\Entity;

use Stringable;

/**
 * There's an explanation for the weird use of "%3A" in the strings.
 * Spotify's API doesn't make perfect matches on all searches unless the colons are urlencoded.
 * However, if the whole string is encoded (spaces becoming %20), results are mis-matched again.
 * From going through a lot of test data, encoding ONLY the colons is the only way to
 * get a correct match all of the time from the live API. This may be a bug on Spotify's end,
 * but whatever the cause, this is a solution battle tested by TrackShift.
 */
readonly class FilterQuery implements Stringable {
	public function __construct(
		public string $baseQuery = "",
		public ?string $album = null,
		public ?string $artist = null,
		public ?string $track = null,
		public ?string $year = null,
		public ?string $upc = null,
		public ?string $genre = null,
		public bool $new = false,
		public bool $hipster = false,
	) {}

	public function __toString():string {
		$stringParts = [];
		if($this->baseQuery) {
			array_push($stringParts, $this->baseQuery);
		}

		if($this->album) {
			array_push($stringParts, "album%3A$this->album");
		}
		if($this->artist) {
			array_push($stringParts, "artist%3A$this->artist");
		}
		if($this->track) {
			array_push($stringParts, "track%3A$this->track");
		}
		if($this->year) {
			array_push($stringParts, "year%3A$this->year");
		}
		if($this->upc) {
			array_push($stringParts, "upc%3A$this->upc");
		}
		if($this->genre) {
			array_push($stringParts, "genre%3A$this->genre");
		}
		if($this->new) {
			array_push($stringParts, "tag%3Anew");
		}
		if($this->hipster) {
			array_push($stringParts, "tag%3Ahipster");
		}

		return implode(" ", $stringParts);
	}
}
