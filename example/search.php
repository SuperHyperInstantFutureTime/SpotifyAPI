<?php
use SHIFT\Spotify\Entity\EntityType;
use SHIFT\Spotify\Entity\SearchFilter;
use SHIFT\Spotify\SpotifyClient;

chdir(__DIR__);
require "../vendor/autoload.php";

$config = parse_ini_file("config.ini");

$client = new SpotifyClient(
	$config["client_id"],
	$config["client_secret"],
);
$searchResults = $client->search->query("Crash of Rhinos", new SearchFilter(EntityType::artist));
