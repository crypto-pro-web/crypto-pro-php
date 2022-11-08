<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

abstract class AbstractDictionary implements DictionaryInterface
{
	protected const MAP = [];

	protected static function getResult($data)
	{
		$implements = class_implements(static::class) ?: [];

		$options = [];

		if (in_array(TitleAwareInterface::class, $implements))
		{
			$options['title'] = $data['title'] ?? null;
		}

		if (in_array(OIDAwareInterface::class, $implements))
		{
			$options['OID'] = $data['OID'] ?? null;
		}

		if (in_array(RDNAwareInterface::class, $implements))
		{
			$options['RDN'] = $data['RDN'] ?? null;
		}

		return DictionaryItem::getItem($options);
	}

	public static function getMap()
	{
		$map = [];

		$class = static::class;

		do
		{
			array_push($map, ...$class::MAP);
		} while (($class = get_parent_class($class)) != self::class);

		array_push($map, ...$class::MAP);

		return $map;
	}
}