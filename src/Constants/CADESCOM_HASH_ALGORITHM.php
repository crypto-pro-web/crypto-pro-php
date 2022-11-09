<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисление CADESCOM_HASH_ALGORITHM описывает алгоритмы хэширования.
 */
class CADESCOM_HASH_ALGORITHM
{
	/**
	 * Алгоритм ГОСТ Р 34.11-94.
	 */
	const HASH_CP_GOST_3411 = 100;

	/**
	 * Алгоритм ГОСТ Р 34.11-2012.
	 */
	const HASH_CP_GOST_3411_2012_256 = 101;

	/**
	 * Алгоритм ГОСТ Р 34.11-2012 HMAC.
	 */
	const HASH_CP_GOST_3411_2012_256_HMAC = 111;

	/**
	 * Алгоритм ГОСТ Р 34.11-2012.
	 */
	const HASH_CP_GOST_3411_2012_512 = 102;

	/**
	 * Алгоритм ГОСТ Р 34.11-2012 HMAC.
	 */
	const HASH_CP_GOST_3411_2012_512_HMAC = 112;

	/**
	 * Алгоритм ГОСТ Р 34.11-94 HMAC.
	 */
	const HASH_CP_GOST_3411_HMAC = 110;

	/**
	 * Алгоритм MD2.
	 */
	const HASH_MD2 = 1;

	/**
	 * Алгоритм MD4.
	 */
	const HASH_MD4 = 2;

	/**
	 * Алгоритм MD5.
	 */
	const HASH_MD5 = 3;

	/**
	 * Алгоритм SHA1 с длиной ключа 256 бит.
	 */
	const HASH_SHA_256 = 4;

	/**
	 * Алгоритм SHA1 с длиной ключа 384 бита.
	 */
	const HASH_SHA_384 = 5;

	/**
	 * Алгоритм SHA1 с длиной ключа 512 бит.
	 */
	const HASH_SHA_512 = 6;

	/**
	 * Алгоритм SHA1.
	 */
	const HASH_SHA1 = 0;
}