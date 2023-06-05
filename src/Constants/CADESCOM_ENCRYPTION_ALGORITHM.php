<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисление CADESCOM_ENCRYPTION_ALGORITHM описывает Алгоритмы шифрования.
 */
class CADESCOM_ENCRYPTION_ALGORITHM
{
	/**
	 * Алгоритм 3DES.
	 */
	const ENCRYPTION_3DES = 3;

	/**
	 * Алгоритм AES.
	 */
	const ENCRYPTION_AES = 4;

	/**
	 * Алгоритм DES.
	 */
	const ENCRYPTION_DES = 2;

	/**
	 * Алгоритм ГОСТ 28147-89.
	 */
	const ENCRYPTION_GOST_28147_8 = 25;

	/**
	 * Алгоритм RSA RC2.
	 */
	const ENCRYPTION_RC2 = 0;

	/**
	 * Алгоритм RSA RC4.
	 */
	const ENCRYPTION_RC4 = 1;
}