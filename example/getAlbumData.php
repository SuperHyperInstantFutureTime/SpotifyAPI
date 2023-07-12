<?php
use SHIFT\Spotify\SpotifyClient;

chdir(__DIR__);
require "../vendor/autoload.php";

$config = parse_ini_file("config.ini", true);

$client = new SpotifyClient(
	$config["spotify"]["client_id"],
	$config["spotify"]["client_secret"],
);

$album = $client->albums->get("0EU6tGR8ryGiMeEn5KE2LB");
echo "You have selected {$album->name} by {$album->artists[0]->name}.", PHP_EOL;
echo "This album has {$album->totalTracks} tracks, and was released in ", $album->releaseDate->format("Y"), ".", PHP_EOL;
