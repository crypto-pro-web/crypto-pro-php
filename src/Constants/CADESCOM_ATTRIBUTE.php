<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисления CADESCOM_ATTRIBUTE определяет тип атрибута, связанного с сигнатурой.
 */
class CADESCOM_ATTRIBUTE
{
	/**
	 * Прочие атрибуты.
	 */
	const OTHER = 0xffffffff;

	/**
	 * Описание документа.
	 */
	const DOCUMENT_DESCRIPTION = 2;

	/**
	 * Название документа.
	 */
	const DOCUMENT_NAME = 1;

	/**
	 * Время подписи.
	 */
	const SIGNING_TIME = 0;
}