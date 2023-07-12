<?php
use SHIFT\Spotify\SpotifyClient;

chdir(__DIR__);
require "../vendor/autoload.php";

$config = parse_ini_file("config.ini");

$client = new SpotifyClient(
	$config["client_id"],
	$config["client_secret"],
);
$artist = $client->artists->get("183vQCgpuNJHxdDCYIpkA4");

echo "You have selected {$artist->name}.", PHP_EOL;
echo "They have {$artist->followers->total} followers and a popularity of {$artist->popularity}.", PHP_EOL;
echo "Their genres are: ", implode(", ", $artist->genres), ".", PHP_EOL;
