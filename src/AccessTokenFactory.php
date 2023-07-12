<?php
namespace SHIFT\Spotify;

class AccessTokenFactory {
	public function __construct(
		public readonly string $cacheFile = "access-token.dat",
	) {}

	public function load():?AccessToken {
		if(!is_file($this->cacheFile)) {
			return null;
		}

		$fileContents = file_get_contents($this->cacheFile);
		return unserialize($fileContents);
	}

	public function save(AccessToken $accessToken):void {
		file_put_contents($this->cacheFile, serialize($accessToken));
	}

}
