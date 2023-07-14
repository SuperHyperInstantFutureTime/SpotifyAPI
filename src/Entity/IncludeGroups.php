<?php
namespace SHIFT\Spotify\Entity;

use Stringable;

readonly class IncludeGroups extends AbstractEntity implements Stringable {
	/** @var array<Group> */
	public array $groupList;

	public function __construct(
		Group...$groupList
	) {
		$this->groupList = $groupList;
	}

	public function __toString():string {
		$string = "";
		foreach($this->groupList as $group) {
			if(!empty($string)) {
				$string .= ",";
			}
			$string .= $group->name;
		}

		return $string;
	}
}
