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
}