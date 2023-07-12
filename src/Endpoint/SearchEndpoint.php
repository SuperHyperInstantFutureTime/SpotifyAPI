<?php
namespace SHIFT\Spotify\Endpoint;

class SearchEndpoint extends AbstractEndpoint {
	/**
	 * @param array<string> $searchType
	 * @return SearchResult
	 */
	public function search(
		string $query,
		array $searchType,
		?string $market = null,
		int $limit = 20,
		int $offset = 0,
		?string $includeExternal = null,
	):SearchResult {

	}
}
