<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

trait RDNAwareTrait
{
	public static function getByRDN(string $RDN)
	{
		$RDN = mb_strtolower(trim($RDN));

		$map = static::getRDNMap();

		return isset($map[$RDN]) ? static::getResult($map[$RDN]) : null;
	}

	protected static function getRDNMap()
	{
		static $RDNMap;

		if (!isset($RDNMap))
		{
			foreach (static::getMap() as $row)
			{
				if (isset($row['RDN']))
				{
					$variant = mb_strtolower($row['RDN']);
					if (!isset($RDNMap[$variant]))
					{
						$RDNMap[$variant] = $row;
					}
				}
			}
		}

		return $RDNMap;
	}
}