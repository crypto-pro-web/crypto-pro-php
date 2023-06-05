<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Перечисление CAPICOM_PROPID определяет идентификаторы свойств CAPICOM.
 *
 * @remarks Тип перечисления CAPICOM_PROPID используется в качестве аргумента $varCriteria метода \CPCertificates::Find(),
 *          если $FindType установлен как CAPICOM_CERTIFICATE_FIND_EXTENDED_PROPERTY
 * @see     \CPCertificates::Find()
 * @link    https://learn.microsoft.com/ru-ru/windows/win32/seccrypto/capicom-propid
 */
class CAPICOM_PROPID
{
	const UNKNOWN = 0; // Тип свойства неизвестен.

	const KEY_PROV_HANDLE = 1; // Дескриптор контейнера ключей в поставщике служб шифрования (CSP).

	const KEY_PROV_INFO = 2; // Сведения о контейнере ключей в CSP.

	const SHA1_HASH = 3; // Хэш-объект SHA1.

	const HASH_PROP = 3; // Свойства хэш-объекта.

	const MD5_HASH = 4; // Хэш-объект MD5.

	const KEY_CONTEXT = 5; // Контекст ключа.

	const KEY_SPEC = 6; // Спецификации ключа.

	const IE30_RESERVED = 7; // Сведения о том, зарезервирован ли объект в Internet Explorer 3.0.

	const PUBKEY_HASH_RESERVED = 8; // Сведения о том, зарезервирован ли хэш открытого ключа.

	const ENHKEY_USAGE = 9; // Расширенное использование ключа (EKU).

	const CTL_USAGE = 9; // Использование списка доверия сертификатов (CTL).

	const NEXT_UPDATE_LOCATION = 10; // Расположение следующего обновления списка отзыва сертификатов (CRL).

	const FRIENDLY_NAME = 11; // Понятное имя.

	const PVK_FILE = 12; // Файл, содержащий закрытый ключ.

	const DESCRIPTION = 13; // Понятное описание.

	const ACCESS_STATE = 14; // Состояние доступа.

	const SIGNATURE_HASH = 15; // Хэш подписи.

	const SMART_CARD_DATA = 16; // Данные смарт-карты.

	const EFS = 17; // Шифрующая файловая система (EFS).

	const FORTEZZA_DATA = 18; // Данные, созданные с помощью криптографических протоколов и алгоритмов, принадлежащих Национальному институту стандартов и технологий (NIST).

	const ARCHIVED = 19; // Сведения о том, архивируется ли объект.

	const KEY_IDENTIFIER = 20; // Идентификатор ключа.

	const AUTO_ENROLL = 21; // Сведения об автоматической регистрации сертификата.

	const PUBKEY_ALG_PARA = 22; // Параметры для алгоритма открытого ключа.

	const CROSS_CERT_DIST_POINTS = 23; // Сведения, используемые для обновления динамических перекрестных сертификатов.

	const ISSUER_PUBLIC_KEY_MD5_HASH = 24; // Хэш MD5 открытого ключа издателя.

	const SUBJECT_PUBLIC_KEY_MD5_HASH = 25; // Хэш MD5 открытого ключа субъекта.

	const ENROLLMENT = 26; // Сведения о регистрации сертификата.

	const DATE_STAMP = 27; // Метка даты.

	const ISSUER_SERIAL_NUMBER_MD5_HASH = 28; // Хэш MD5 серийного номера издателя.

	const SUBJECT_NAME_MD5_HASH = 29; // Хэш MD5 имени субъекта.

	const EXTENDED_ERROR_INFO = 30; // Дополнительные сведения об ошибке.

	const RENEWAL = 64; // Сведения о продлении центра сертификации.

	const ARCHIVED_KEY_HASH = 65; // Архивный хэш ключа.

	const FIRST_RESERVED = 66; // Сведения о первом резервировании.

	const LAST_RESERVED = 0x00007FFF; // Сведения о последнем резервировании.

	const FIRST_USER = 0x00008000; // Сведения о первом пользователе.

	const LAST_USER = 0x0000FFFF; // Сведения о последнем пользователе.
}