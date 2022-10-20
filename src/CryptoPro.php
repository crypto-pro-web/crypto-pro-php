<?php

namespace Webmasterskaya\CryptoPro;

class CryptoPro
{
	/**
	 * возвращает список сертификатов, доступных пользователю в системе
	 *
	 * @return void
	 */
	public static function getUserCertificates(bool $resetCache = false)
	{
	}

	/**
	 * возвращает список сертификатов, доступных пользователю в системе, в том числе просроченные и без закрытого ключа
	 *
	 * @return void
	 */
	public static function getAllUserCertificates(bool $resetCache = false)
	{
	}

	/**
	 * возвращает список сертификатов, из закрытых ключей и/или сертификаты не установленные всистеме*
	 *
	 * @return void
	 */
	public static function getContainerCertificates(bool $resetCache = false)
	{
	}

	/**
	 * возвращает список сертификатов, из закрытых ключей и/или сертификаты не установленные всистеме*, в том числе просроченные и без закрытого ключа
	 *
	 * @return void
	 */
	public static function getAllContainerCertificates(bool $resetCache = false)
	{
	}

	/**
	 * возвращает сертификат по отпечатку
	 *
	 * @return void
	 */
	public static function getCertificate()
	{
	}

	/**
	 * создает совмещенную (присоединенную) подпись сообщения
	 *
	 * @return void
	 */
	public static function createAttachedSignature()
	{
	}

	/**
	 * создает отсоединенную (открепленную) подпись сообщения
	 *
	 * @return void
	 */
	public static function createDetachedSignature()
	{
	}

	/**
	 * добавляет совмещенную (присоединенную) подпись к раннее подписанному документу (реализует метод coSign)
	 *
	 * @return void
	 */
	public static function addAttachedSignature()
	{
	}

	/**
	 * добавляет отсоединенную (открепленную) подпись к раннее подписанному документу (реализует метод coSign)
	 *
	 * @return void
	 */
	public static function addDetachedSignature()
	{
	}

	/**
	 * создает XML подпись для документа в формате XML
	 *
	 * @return void
	 */
	public static function createXMLSignature()
	{
	}

	/**
	 * создает хеш сообщения по ГОСТ Р 34.11-2012 256 бит
	 *
	 * @return void
	 */
	public static function createHash()
	{
	}

	/**
	 * возвращает информацию о CSP и плагине
	 *
	 * @return void
	 */
	public static function getSystemInfo()
	{
	}

}