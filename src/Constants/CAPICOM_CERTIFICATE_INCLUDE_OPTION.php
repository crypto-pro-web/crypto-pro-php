<?php

namespace Webmasterskaya\CryptoPro\Constants;

class CAPICOM_CERTIFICATE_INCLUDE_OPTION
{
	/**
	 * Сохраняет все сертификаты в цепочке за исключением корневой сущности.
	 */
	const CHAIN_EXCEPT_ROOT = 0;

	/**
	 * Сохраняет полную цепочку сертификатов.
	 */
	const WHOLE_CHAIN = 1;

	/**
	 * Сохраняет только сертификат конечной сущности.
	 */
	const END_ENTITY_ONLY = 2;

}