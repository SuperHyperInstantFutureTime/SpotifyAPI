<?php
namespace SHIFT\Spotify\Test;

use DateTime;
use PHPUnit\Framework\TestCase;
use SHIFT\Spotify\AccessToken;
use SHIFT\Spotify\AccessTokenFactory;

class AccessTokenFactoryTest extends TestCase {
	public function testLoad_noFile():void {
		$tmpFile = sys_get_temp_dir() . "/SHIFT_SpotifyAPI_doesNotExist";
		$sut = new AccessTokenFactory($tmpFile);
		self::assertNull($sut->load());
	}

	public function testSave():void {
		$tempFile = sys_get_temp_dir() . uniqid("/SHIFT_SpotifyAPI_");
		$sut = new AccessTokenFactory($tempFile);
		self::assertFileDoesNotExist($tempFile);
		$sut->save(new AccessToken("aaa", "type", new DateTime()));
		self::assertFileExists($tempFile);
		unlink($tempFile);
	}

	public function testSave_thenLoad():void {
		$tempFile = sys_get_temp_dir() . uniqid("/SHIFT_SpotifyAPI_");
		$sut = new AccessTokenFactory($tempFile);
		$accessToken = new AccessToken("aaa", "type", new DateTime());
		$sut->save($accessToken);
		unset($accessToken);

		$newAccessToken = $sut->load();
		self::assertSame("type aaa", (string)$newAccessToken);
	}
}
