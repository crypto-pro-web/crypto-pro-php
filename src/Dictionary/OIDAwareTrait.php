<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

trait OIDAwareTrait
{
	public static function getByOID(string $oid)
	{
		$oid = mb_strtolower(trim($oid));

		$map = self::getOIDMap();

		return isset($map[$oid]) ? self::getResult($map[$oid]) : null;
	}

	protected static function getOIDMap()
	{
		static $OIDMap;

		if (!isset($OIDMap))
		{
			foreach (self::MAP as $row)
			{
				if (isset($row['OID']))
				{
					$variant          = mb_strtolower($row['OID']);
					$OIDMap[$variant] = $row;
				}
			}
		}

		return $OIDMap;
	}
}