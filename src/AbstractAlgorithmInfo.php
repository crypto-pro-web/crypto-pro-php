<?php

namespace Webmasterskaya\CryptoPro;

/**
 * @property-read $algorithm
 * @property-read $oid
 */
abstract class AbstractAlgorithmInfo implements AlgorithmInfoInterface
{
	protected $algorithm;
	protected $oid;

	public function __construct($algorithm, $oid)
	{
		$this->algorithm = $algorithm;
		$this->oid       = $oid;
	}

	/**
	 * @param $name
	 *
	 * @return string|void
	 */
	public function __get($name)
	{
		switch ($name)
		{
		case 'algorithm':
		case 'oid':
			return $this->{$name};
		}
	}
}