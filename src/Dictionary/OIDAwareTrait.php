<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

trait OIDAwareTrait
{
	public static function getByOID(string $oid)
	{
		$oid = mb_strtolower(trim($oid));

		$map = static::getOIDMap();

		return isset($map[$oid]) ? static::getResult($map[$oid]) : null;
	}

	protected static function getOIDMap()
	{
		static $OIDMap;

		if (!isset($OIDMap))
		{
			foreach (static::getMap() as $row)
			{
				if (isset($row['OID']))
				{
					$variant = mb_strtolower($row['OID']);
					if (!isset($OIDMap[$variant]))
					{
						$OIDMap[$variant] = $row;
					}
				}
			}
		}

		return $OIDMap;
	}
}