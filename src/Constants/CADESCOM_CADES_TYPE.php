<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисления CADESCOM_CADES_TYPE определяет тип усовершенствованной подписи.
 */
class CADESCOM_CADES_TYPE
{
	/**
	 * Тип подписи CAdES BES.
	 */
	const CADES_BES = 0x01;

	/**
	 * Тип подписи по умолчанию (CAdES-X Long Type 1).
	 */
	const CADES_DEFAULT = 0x00;

	/**
	 * Тип подписи CAdES T.
	 */
	const CADES_T = 0x05;

	/**
	 * Тип подписи CAdES-X Long Type 1.
	 */
	const CADES_X_LONG_TYPE_1 = 0x5D;

	/**
	 * Тип подписи PKCS7.
	 */
	const PKCS7_TYPE = 0xffff;
}