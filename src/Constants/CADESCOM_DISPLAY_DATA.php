<?php

namespace Webmasterskaya\CryptoPro\Constants;

class CADESCOM_DISPLAY_DATA
{
	/**
	 * Отображаемые данные лежат в подписанном атрибуте сообщения.
	 */
	const ATTRIBUTE = 0x2;

	/**
	 * Отображаемые данные лежат в теле сообщения.
	 */
	const CONTENT = 0x1;

	/**
	 * Данные не будут пересылаться в устройство.
	 */
	const NONE = 0x0;
}