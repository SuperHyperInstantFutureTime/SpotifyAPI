<?php
use SHIFT\Spotify\Entity\Album;
use SHIFT\Spotify\Entity\EntityType;
use SHIFT\Spotify\Entity\Group;
use SHIFT\Spotify\Entity\IncludeGroups;
use SHIFT\Spotify\Entity\SearchFilter;
use SHIFT\Spotify\Entity\Track;
use SHIFT\Spotify\SpotifyClient;

chdir(__DIR__);
require "../vendor/autoload.php";

$config = parse_ini_file("config.ini");

$clientId = $config["client_id"];
$clientSecret = $config["client_secret"];

$artistName = "Order of the Toad";
$trackName = "Spirit Man";

$client = new SpotifyClient($clientId, $clientSecret);
$query = new FilterQuery(artist: $artistName, album: $trackName);

$searchResults = $client->search->query(
	$query,
	new SearchFilter(EntityType::album, EntityType::track),
	"GB",
	limit: 5
);

/** @var Album|Track $match */
foreach(array_merge($searchResults->albums->items, $searchResults->tracks->items) as $match) {
	if($match->name !== $trackName) {
		echo "Skipping $match->name ...", PHP_EOL;
		continue;
	}

	/** @var ?Album $album */
	if($match instanceof Track) {
		$album = $match->album;
	}
	else {
		$album = null;
	}

	if(!$album) {
		continue;
	}

	if($image = $album->images[0] ?? null) {
		echo "Match: $match->name - ", $image->url, PHP_EOL;
		break;
	}

	echo "No images.", PHP_EOL;
}
