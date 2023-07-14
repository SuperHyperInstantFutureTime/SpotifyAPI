<?php
namespace SHIFT\Spotify\Entity;

use Stringable;

readonly class SearchFilter extends AbstractEntity implements Stringable {
	/** @var EntityType[] */
	public array $typeList;

	public function __construct(
		EntityType...$typeList
	) {
		$this->typeList = $typeList;
	}

	public function __toString():string {
		$string = "";
		foreach($this->typeList as $type) {
			if(!empty($string)) {
				$string .= ",";
			}
			$string .= $type->name;
		}
		return $string;
	}
}
