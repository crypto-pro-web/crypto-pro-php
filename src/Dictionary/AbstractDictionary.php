<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

abstract class AbstractDictionary implements DictionaryInterface
{
	protected const MAP = [];

	protected static function getResult($data)
	{
		$implements = class_implements(static::class) ?: [];

		$options = [];

		if (!!$implements[TitleAwareInterface::class])
		{
			$options['title'] = $data['title'] ?? null;
		}

		if (!!$implements[OIDAwareInterface::class])
		{
			$options['OID'] = $data['OID'] ?? null;
		}

		if (!!$implements[RDNAwareInterface::class])
		{
			$options['RDN'] = $data['RDN'] ?? null;
		}

		return DictionaryItem::getItem($options);
	}
}