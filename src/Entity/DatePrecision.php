<?php
namespace SHIFT\Spotify\Entity;

use SHIFT\Spotify\SpotifyException;

enum DatePrecision {
	case year;
	case month;
	case day;

	public static function fromString(string $precision):self {
		foreach(self::cases() as $case) {
			if($case->name === $precision) {
				return $case;
			}
		}

		throw new SpotifyException("Unknown date precision: $precision");
	}

}
