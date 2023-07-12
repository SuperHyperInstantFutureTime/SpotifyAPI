<?php
namespace SHIFT\Spotify\Factory;

use SHIFT\Spotify\Entity\AbstractEntity;
use Gt\Json\JsonObject;

abstract class AbstractFactory {
	abstract public function fromJsonObject(JsonObject $json):AbstractEntity;
}
