<?php

namespace Webmasterskaya\CryptoPro\Constants;

/**
 * Тип перечисления CAPICOM_CERTIFICATE_FIND_TYPE определяет тип условий поиска, используемых для поиска определенных сертификатов.
 *
 * @remarks Тип перечисления CAPICOM_CERTIFICATE_FIND_TYPE используется в качестве аргумента $FindType метода \CPCertificates::Find()
 * @see     \CPCertificates::Find()
 * @link    https://learn.microsoft.com/windows/win32/seccrypto/capicom-certificate-find-type
 */
class CAPICOM_CERTIFICATE_FIND_TYPE
{
	const SHA1_HASH = 0; // Возвращает сертификаты, соответствующие указанному хэшу SHA1.

	const SUBJECT_NAME = 1; // Возвращает сертификаты, имя субъекта которых точно или частично соответствует указанному имени субъекта.

	const ISSUER_NAME = 2; // Возвращает сертификаты, имя издателя которых точно или частично совпадает с указанным именем издателя.

	const ROOT_NAME = 3; // Возвращает сертификаты, имя корневой субъекта которых точно или частично соответствует указанному имени корневой темы.

	const TEMPLATE_NAME = 4; // Возвращает сертификаты, имя шаблона которых соответствует указанному имени шаблона.

	const EXTENSION = 5; // Возвращает сертификаты, имеющие расширение, соответствующее указанному расширению.

	const EXTENDED_PROPERTY = 6; // Возвращает сертификаты с расширенным свойством, идентификатор свойства которого соответствует указанному идентификатору свойства.

	const APPLICATION_POLICY = 7; // Возвращает сертификаты в хранилище с расширенным расширением использования ключа или свойством в сочетании с идентификатором использования.

	const CERTIFICATE_POLICY = 8; // Возвращает сертификаты, содержащие указанный идентификатор политики.

	const TIME_VALID = 9; // Возвращает сертификаты, время которых является допустимым.

	const TIME_NOT_YET_VALID = 10; // Возвращает сертификаты, время которых еще не является допустимым.

	const TIME_EXPIRED = 11; // Возвращает сертификаты, срок действия которых истек.

	const KEY_USAGE = 12; // Возвращает сертификаты, содержащие ключ, который может использоваться указанным образом.

}