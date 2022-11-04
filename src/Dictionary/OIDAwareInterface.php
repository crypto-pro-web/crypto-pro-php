<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

interface OIDAwareInterface
{
	public static function getByOID(string $oid);
}