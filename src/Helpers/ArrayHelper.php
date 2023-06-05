<?php

namespace Webmasterskaya\CryptoPro\Helpers;

class ArrayHelper
{
	/**
	 * @param   array     $array
	 * @param   callable  $fn
	 *
	 * @return bool
	 */
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

	/**
	 * @param   array     $array
	 * @param   callable  $fn
	 *
	 * @return bool
	 */
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

	/**
	 * @param   array     $array
	 * @param   callable  $fn
	 *
	 * @return mixed|void
	 */
	public static function find(array $array, callable $fn)
	{
		foreach ($array as $key => $value)
		{
			if ($fn($value, $key, $array))
			{
				return $value;
			}
		}
	}
}