<?php
namespace SHIFT\Spotify\Endpoint;

use SHIFT\Spotify\Entity\AbstractEntity;
use SHIFT\Spotify\Factory\AlbumFactory;
use SHIFT\Spotify\Factory\ArtistFactory;
use SHIFT\Spotify\Factory\TrackFactory;
use SHIFT\Spotify\SpotifyClient;
use Gt\Fetch\Http;

abstract class AbstractEndpoint {
	public function __construct(
		protected readonly SpotifyClient $client,
		protected readonly AlbumFactory $albumFactory,
		protected readonly ArtistFactory $artistFactory,
		protected readonly TrackFactory $trackFactory,
	) {}

	abstract public function get(string $id):AbstractEntity;

	/**
	 * @param array<string> $idList
	 * @return array<AbstractEntity>
	 */
	abstract public function getSeveral(array $idList):array;
}
