<?php
namespace SHIFT\Spotify\Test;

use DateInterval;
use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use SHIFT\Spotify\AccessToken;

class AccessTokenTest extends TestCase {
	public function testIsAlive():void {
		$expiresAt = self::createMock(DateTime::class);
		$expiresAt->expects(self::exactly(2))
			->method("getTimestamp")
			->willReturnOnConsecutiveCalls(
				strtotime("+1 hour"),
				strtotime("-1 hour"),
			);
		$sut = new AccessToken("aaa", "type", $expiresAt);
		self::assertTrue($sut->isAlive());
		self::assertFalse($sut->isAlive());
	}

	public function testToString():void {
		$sut = new AccessToken(
			"aaa",
			"type",
			self::createMock(DateTime::class)
		);
		self::assertSame("type aaa", (string)$sut);
	}
}
