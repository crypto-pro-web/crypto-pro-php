<?php

namespace Webmasterskaya\CryptoPro\Tags;

use Webmasterskaya\CryptoPro\Traits\ReversMapInterface;
use Webmasterskaya\CryptoPro\Traits\ReversMapTrait;

abstract class AbstractTagsCodes implements TagsCodesInterface, ReversMapInterface
{
	protected const MAP = [];

	use ReversMapTrait;

	public static function codeByName($name)
	{
		$reverseMap = self::reverseMap();

		return $reverseMap[strtolower($name)] ?? null;
	}
}