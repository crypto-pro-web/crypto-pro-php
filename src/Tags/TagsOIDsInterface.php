<?php

namespace Webmasterskaya\CryptoPro\Tags;

interface TagsOIDsInterface
{
	public static function codeByOid($oid);

	public static function oidByCode($code);
}