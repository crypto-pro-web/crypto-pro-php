<?php

namespace Webmasterskaya\CryptoPro\Traits;

trait ReversMapTrait
{
	public static function reverseMap()
	{
		static $reverseMap;

		if (!isset($reverseMap))
		{
			$reverseMap = [];
			foreach (self::MAP as $key => $values)
			{
				if (is_object($values))
				{
					$values = (array) $values;
				}

				if (!is_array($values))
				{
					$reverseMap[strtolower((string) $values)] = $key;
				}
				else
				{
					foreach ($values as $value)
					{
						$reverseMap[strtolower($value)] = $key;
					}
				}
			}
		}

		return $reverseMap;
	}
}