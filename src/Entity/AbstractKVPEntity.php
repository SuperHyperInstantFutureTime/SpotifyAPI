<?php
namespace SHIFT\Spotify\Entity;

use ArrayAccess;
use SHIFT\Spotify\SpotifyException;
use Gt\Json\JsonKvpObject;

readonly class AbstractKVPEntity extends AbstractEntity implements ArrayAccess {
	public function __construct(private ?JsonKvpObject $kvp) {}

	public function offsetExists(mixed $offset):bool {
		return $this->kvp->contains($offset);
	}

	public function offsetGet(mixed $offset):string {
		return $this->kvp->getString($offset);
	}

	public function offsetSet(mixed $offset, mixed $value):void {
		throw new SpotifyException("Trying to set an offset of a readonly entity");
	}

	public function offsetUnset(mixed $offset): void {
		throw new SpotifyException("Trying to unset an offset of a readonly entity");
	}
}
