<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Тип перечисления CAPICOM_STORE_OPEN_MODE используется с методом \CPStore->Open() для указания способа открытия хранилища сертификатов.
 */
class CAPICOM_STORE_OPEN_MODE
{
	/**
	 * Откройте хранилище в режиме только для чтения.
	 */
	const READ_ONLY = 0;

	/**
	 * Откройте хранилище в режиме чтения и записи.
	 */
	const READ_WRITE = 1;

	/**
	 * Откройте хранилище в режиме чтения и записи, если у пользователя есть разрешения на чтение и запись.
	 * Если у пользователя нет разрешений на чтение и запись, откройте хранилище в режиме только для чтения.
	 */
	const MAXIMUM_ALLOWED = 2;

	/**
	 * Открывать только существующие магазины; не создавайте новое хранилище.
	 */
	const EXISTING_ONLY = 128;

	/**
	 * Включите архивные сертификаты при использовании хранилища.
	 */
	const INCLUDE_ARCHIVED = 256;

}