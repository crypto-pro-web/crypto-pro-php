<?php

namespace Webmasterskaya\CryptoPro\Tags;

use Webmasterskaya\CryptoPro\Traits\ReversMapInterface;
use Webmasterskaya\CryptoPro\Traits\ReversMapTrait;

abstract class AbstractTagsOIDs implements TagsOIDsInterface, ReversMapInterface
{
	protected const MAP = [];

	use ReversMapTrait;

	public static function codeByOid($oid)
	{
		return self::MAP[$oid] ?? null;
	}

	public static function oidByCode($code)
	{
		$reverseMap = self::reverseMap();

		return $reverseMap[strtolower($code)] ?? null;
	}
}