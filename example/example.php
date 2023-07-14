<?php
use SHIFT\Spotify\Entity\EntityType;
use SHIFT\Spotify\Entity\Group;
use SHIFT\Spotify\Entity\IncludeGroups;
use SHIFT\Spotify\Entity\SearchFilter;
use SHIFT\Spotify\SpotifyClient;
chdir(__DIR__);
require "../vendor/autoload.php";
$config = parse_ini_file("config.ini");
$clientId = $config["client_id"];
$clientSecret = $config["client_secret"];
//


$client = new SpotifyClient($clientId, $clientSecret);
$searchResults = $client->search->query(
    "crash of rhinos",
    new SearchFilter(EntityType::artist)
);
$artist = $client->artists->get(
    $searchResults->artists->items[0]->id
);
$albums = $client->artists->getAlbums(
    $searchResults->artists->items[0]->id,
    new IncludeGroups(Group::album)
);

echo "The matching artist, $artist->name, has ",
    number_format($artist->followers->total),
    " followers, and a popularity of $artist->popularity",
    PHP_EOL;
echo "They have $albums->total albums: ", PHP_EOL;
foreach($albums->items as $album) {
    echo "$album->name (",
        $album->releaseDate->format("Y"),
        ")",
        PHP_EOL;
}



































