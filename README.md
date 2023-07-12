Self-documenting Spotify Web API.
=================================

This library is an SDK to [Spotify's v1 Web API][spotify-api]. It provides a rich, type-safe, self-documenting, object oriented interface.

Example code:

```php
$client = new SpotifyClient($clientId, $clientSecret);

$album = $client->albums->get("0EU6tGR8ryGiMeEn5KE2LB");
echo "You have selected {$album->name} by {$album->artists[0]->name}.", PHP_EOL;
echo "This album has {$album->totalTracks} tracks, and was released in ", $album->releaseDate->format("Y"), ".", PHP_EOL;
```

Work in progress
----------------

We're building this API to complement the development of [Trackshift][trackshift], so our own required functionality will be developed before we reach a v1 release will full functionality.

What's left to complete:

- [x] Get Album details
- [x] Get Artist details
- [x] Get Track details
- [ ] Search API
- [ ] Exception handling
- [ ] Unit tests
- [ ] All Album API endpoints
- [ ] All Artist API endpoints
- [ ] All Track API endpoints
- [ ] All Audiobook API endpoints
- [ ] All Categories API endpoints
- [ ] All Chapters API endpoints
- [ ] All Episodes API endpoints
- [ ] All Genres API endpoints
- [ ] All Markets API endpoints
- [ ] All Player API endpoints
- [ ] All Playlists API endpoints
- [ ] All Shows API endpoints
- [ ] All Users API endpoints

[spotify-api]: https://developer.spotify.com/web-api/
[trackshift]: https://github.com/SuperHyperInstantFutureTime/Trackshift
