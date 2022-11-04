<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

interface TitleAwareInterface
{
	public static function getByTitle(string $title);
}