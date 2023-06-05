<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

interface RDNAwareInterface
{
	public static function getByRDN(string $RDN);
}