<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Тип перечисления CAPICOM_ENCODING_TYPE указывает используемый тип кодирования.
 *
 * @link https://learn.microsoft.com/windows/win32/seccrypto/capicom-encoding-type?redirectedfrom=MSDN
 */
class CAPICOM_ENCODE
{
	const ANY = 0xffffffff; // Данные сохраняются в виде строки в кодировке Base64 или чистой двоичной последовательности. Этот тип кодирования используется только для входных данных с неизвестным типом кодирования. Представлен в CAPICOM 2.0.

	const BASE64 = 0; // Данные сохраняются в виде строки в кодировке Base64.

	const BINARY = 1; // Данные сохраняются в виде чистой двоичной последовательности.
}