<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисления CADESCOM_CONTENT_ENCODING_TYPE определяет способ кодирования данных для подписи..
 */
class CADESCOM_CONTENT_ENCODING_TYPE
{
	/**
	 * Кодировка BASE64.
	 */
	const BASE64_TO_BINARY = 0x01;

	/**
	 * Кодировка UTF-8 или UNICODE.
	 */
	const STRING_TO_UCS2LE = 0x00;

}