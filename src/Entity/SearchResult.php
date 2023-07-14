<?php
namespace SHIFT\Spotify\Entity;

use SHIFT\Spotify\Page\AlbumPage;
use SHIFT\Spotify\Page\ArtistPage;
use SHIFT\Spotify\Page\TrackPage;

readonly class SearchResult extends AbstractEntity {
	public function __construct(
		public ?TrackPage $tracks,
		public ?ArtistPage $artists,
		public ?AlbumPage $albums,
		public ?PlaylistPage $playlists,
		public ?ShowPage $shows,
		public ?EpisodePage $episodes,
		public ?AudiobookPage $audiobooks,
	) {}
}
