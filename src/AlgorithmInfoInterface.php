<?php

namespace Webmasterskaya\CryptoPro;

interface AlgorithmInfoInterface
{
	public function __construct(string $algorithm, string $oid);
}