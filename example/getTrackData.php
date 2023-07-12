<?php
use SHIFT\Spotify\SpotifyClient;

chdir(__DIR__);
require "../vendor/autoload.php";

$config = parse_ini_file("config.ini");

$client = new SpotifyClient(
	$config["client_id"],
	$config["client_secret"],
);
$track = $client->tracks->get("2YLtiKqJcwF8arLMuZtB3q");

$seconds = $track->durationMilliseconds / 1000;
$minutes = floor($seconds / 60);
$duration = "{$minutes}m " . ($seconds % 60) . "s";
echo "You have selected $track->name by {$track->artists[0]->name}, from the album {$track->album->name}.", PHP_EOL;
echo "This is track $track->trackNumber of {$track->album->totalTracks}, and lasts $duration.", PHP_EOL;
