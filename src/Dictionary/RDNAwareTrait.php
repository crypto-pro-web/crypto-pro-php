<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

trait RDNAwareTrait
{
	public static function getByRDN(string $RDN)
	{
		$RDN = mb_strtolower(trim($RDN));

		$map = self::getRDNMap();

		return isset($map[$RDN]) ? self::getResult($map[$RDN]) : null;
	}

	protected static function getRDNMap()
	{
		static $RDNMap;

		if (!isset($RDNMap))
		{
			foreach (self::MAP as $row)
			{
				if (isset($row['RDN']))
				{
					$variant          = mb_strtolower($row['RDN']);
					$RDNMap[$variant] = $row;
				}
			}
		}

		return $RDNMap;
	}
}