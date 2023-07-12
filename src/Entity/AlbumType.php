<?php
namespace SHIFT\Spotify\Entity;

use SHIFT\Spotify\SpotifyException;

enum AlbumType {
	case album;
	case single;
	case compilation;

	public static function fromString(string $type):self {
		foreach(self::cases() as $case) {
			if($type === $case->name) {
				return $case;
			}
		}

		throw new SpotifyException("Unknown album type: $type");
	}

}
