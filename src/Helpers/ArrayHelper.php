<?php

namespace Webmasterskaya\CryptoPro\Helpers;

class ArrayHelper
{
	public static function any(array $array, callable $fn)
	{
		foreach ($array as $value)
		{
			if ($fn($value))
			{
				return true;
			}
		}

		return false;
	}

	public static function every(array $array, callable $fn)
	{
		foreach ($array as $value)
		{
			if (!$fn($value))
			{
				return false;
			}
		}

		return true;
	}
}