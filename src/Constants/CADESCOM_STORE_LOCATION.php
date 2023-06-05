<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисление CADESCOM_STORE_LOCATION описывает расположение хранилища сертификатов
 */
class CADESCOM_STORE_LOCATION
{
	/**
	 * Хранилище сертификатов в памяти компьютера.
	 */
	const MEMORY_STORE = 0;

	/**
	 * Хранилище сертификатов компьютера.
	 */
	const LOCAL_MACHINE_STORE = 1;

	/**
	 * Хранилище сертификатов текущего пользователя.
	 */
	const CURRENT_USER_STORE = 2;

	/**
	 * Хранилище сертификатов в Active Directory.
	 */
	const ACTIVE_DIRECTORY_USER_STORE = 3;

	/**
	 * Хранилище сертификатов на смарткартах (поддерживается только с КриптоПро CSP 5.0.11823 и выше).
	 */
	const SMART_CARD_USER_STORE = 4;

	/**
	 * Хранилище сертификатов из контейнеров закрытых ключей. В данный Store попадают все сертификаты из контейнеров закрытых ключей, которые доступны в системе в момент открытия.
	 */
	const CONTAINER_STORE = 100;
}