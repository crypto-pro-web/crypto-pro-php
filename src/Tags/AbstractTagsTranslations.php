<?php

namespace Webmasterskaya\CryptoPro\Tags;

abstract class AbstractTagsTranslations implements TagsTranslationsInterface
{
	protected const MAP = [];

	public static function translationByCode($code)
	{
		return self::MAP[$code] ?? $code;
	}
}