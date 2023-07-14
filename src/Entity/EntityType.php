<?php
namespace SHIFT\Spotify\Entity;

use Stringable;

enum EntityType {
	case album;
	case artist;
	case playlist;
	case track;
	case show;
	case episode;
	case audiobook;
}
