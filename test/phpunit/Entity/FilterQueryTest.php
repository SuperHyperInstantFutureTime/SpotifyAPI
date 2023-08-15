<?php
namespace SHIFT\Spotify\Test\Entity;

use PHPUnit\Framework\TestCase;
use SHIFT\Spotify\Entity\FilterQuery;

class FilterQueryTest extends TestCase {
	public function testConstruct_simpleQuery():void {
		$sut = new FilterQuery("One Two Three");
		self::assertSame("One Two Three", (string)$sut);
	}

	public function testConstruct_justArtistAndTrack():void {
		$sut = new FilterQuery(artist: "Order of the Toad", track: "Spirit Man");
		self::assertSame("artist%3AOrder of the Toad track%3ASpirit Man", (string)$sut);
	}

	public function testConstruct_albumArtistTrackYear():void {
		$sut = new FilterQuery(
			album: "white",
			artist: "the",
			track: "and",
			year: "1900-2020",
		);
		self::assertSame("album%3Awhite artist%3Athe track%3Aand year%3A1900-2020", (string)$sut);
	}

	public function testConstruct_new():void {
		$sut = new FilterQuery(new: true);
		self::assertSame("tag%3Anew", (string)$sut);
	}

	public function testConstruct_hipster():void {
		$sut = new FilterQuery(hipster: true);
		self::assertSame("tag%3Ahipster", (string)$sut);
	}

	public function testConstruct_newHipster():void {
		$sut = new FilterQuery(new: true, hipster: true);
		self::assertSame("tag%3Anew tag%3Ahipster", (string)$sut);
	}
}
