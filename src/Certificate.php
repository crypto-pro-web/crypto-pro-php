<?php

namespace Webmasterskaya\CryptoPro;

class Certificate
{
	/**
	 * возвращает флаг действительности сертификата
	 *
	 * @return void
	 */
	public function isValid()
	{
	}

	/**
	 * возвращает указанное внутренее свойство у сертификата в формате Cades
	 *
	 * @return void
	 */
	public function getCadesProp()
	{
	}

	/**
	 * возвращает сертификат в формате base64
	 *
	 * @return void
	 */
	public function exportBase64()
	{
	}

	/**
	 * возвращает информацию об алгоритме сертификата
	 *
	 * @return void
	 */
	public function getAlgorithm()
	{
	}

	/**
	 * возвращает расшифрованную информацию о владельце сертификата
	 *
	 * @return void
	 */
	public function getOwnerInfo()
	{
	}

	/**
	 * возвращает расшифрованную информацию об издателе сертификата
	 *
	 * @return void
	 */
	public function getIssuerInfo()
	{
	}

	/**
	 * возвращает ОИД'ы сертификата
	 *
	 * @return void
	 */
	public function getExtendedKeyUsage()
	{
	}

	/**
	 * возвращает расшифрованные ОИД'ы
	 *
	 * @return void
	 */
	public function getDecodedExtendedKeyUsage()
	{
	}

	/**
	 * проверяет наличие ОИД'а (ОИД'ов) у сертификата
	 *
	 * @return void
	 */
	public function hasExtendedKeyUsage()
	{
	}
}