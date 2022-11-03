<?php

namespace Webmasterskaya\CryptoPro;

use Webmasterskaya\CryptoPro\Constants\CAPICOM_CERTIFICATE_FIND_TYPE;
use Webmasterskaya\CryptoPro\Constants\CAPICOM_PROPID;
use Webmasterskaya\CryptoPro\Helpers\CertificateHelper;
use Webmasterskaya\CryptoPro\Helpers\ErrorMessageHelper;

const CONTAINER_STORE = 100;

class CryptoPro
{
	protected const CP_MY_STORE = 'My';

	/**
	 * Возвращает список сертификатов, доступных пользователю в системе
	 *
	 * @param   bool  $resetCache  Сбросить кэш. true - повторно получить список сертификатов из хранилища
	 *
	 * @throws \Exception
	 * @return void
	 */
	public static function getUserCertificates(bool $resetCache = false)
	{
		static $certificates;
		if ($resetCache === true || !isset($certificates))
		{
			$certificates = self::getCertificatesFromStore(CURRENT_USER_STORE);
		}

		return $certificates;
	}

	/**
	 * Возвращает список сертификатов, доступных пользователю в системе, в том числе просроченные и без закрытого ключа
	 *
	 * @param   bool  $resetCache  Сбросить кэш. true - повторно получить список сертификатов из хранилища
	 *
	 * @throws \Exception
	 * @return void
	 */
	public static function getAllUserCertificates(bool $resetCache = false)
	{
		static $certificates;
		if ($resetCache === true || !isset($certificates))
		{
			$certificates = self::getCertificatesFromStore(CURRENT_USER_STORE, self::CP_MY_STORE, false);
		}

		return $certificates;
	}

	/**
	 * Возвращает список сертификатов, из закрытых ключей и/или сертификаты не установленные всистеме*
	 *
	 * @param   bool  $resetCache  Сбросить кэш. true - повторно получить список сертификатов из хранилища
	 *
	 * @throws \Exception
	 * @return void
	 */
	public static function getContainerCertificates(bool $resetCache = false)
	{
		static $certificates;
		if ($resetCache === true || !isset($certificates))
		{
			$certificates = self::getCertificatesFromStore(CONTAINER_STORE);
		}

		return $certificates;
	}

	/**
	 * Возвращает список сертификатов, из закрытых ключей и/или сертификаты не установленные всистеме*, в том числе просроченные и без закрытого ключа
	 *
	 * @param   bool  $resetCache  Сбросить кэш. true - повторно получить список сертификатов из хранилища
	 *
	 * @throws \Exception
	 * @return void
	 */
	public static function getAllContainerCertificates(bool $resetCache = false)
	{
		static $certificates;
		if ($resetCache === true || !isset($certificates))
		{
			$certificates = self::getCertificatesFromStore(CONTAINER_STORE, self::CP_MY_STORE, false);
		}

		return $certificates;
	}

	/**
	 * Возвращает список сертификатов, доступных пользователю из пользовательского хранилища и закрытых ключей, не установленных в системе
	 *
	 * @param   bool  $resetCache  Сбросить кэш. true - повторно получить список сертификатов из хранилища
	 *
	 * @return array
	 */
	public static function getCertificates(bool $resetCache = false)
	{
		static $certificates;
		if ($resetCache === true || !isset($certificates))
		{
			$availableCertificates = [];
			try
			{
				$availableCertificates = self::getUserCertificates($resetCache);
			}
			catch (\Throwable $e)
			{
				// do nothing
			}

			$containerCertificates = [];
			try
			{
				$containerCertificates = self::getContainerCertificates($resetCache);
			}
			catch (\Throwable $e)
			{
				// do nothing
			}

			self::mergeToAvailableCertificates($availableCertificates, $containerCertificates);

			$certificates = $availableCertificates;
		}

		return $certificates;
	}

	/**
	 * Возвращает список сертификатов, доступных пользователю из пользовательского хранилища и закрытых ключей,
	 * не установленных в системе, без фильтрации по дате и наличию приватного ключа
	 *
	 * @param   bool  $resetCache  Сбросить кэш. true - повторно получить список сертификатов из хранилища
	 *
	 * @return array
	 */
	public static function getAllCertificates(bool $resetCache = false)
	{
		static $certificates;
		if ($resetCache === true || !isset($certificates))
		{
			$availableCertificates = [];
			try
			{
				$availableCertificates = self::getAllUserCertificates($resetCache);
			}
			catch (\Throwable $e)
			{
				// do nothing
			}

			$containerCertificates = [];
			try
			{
				$containerCertificates = self::getAllContainerCertificates($resetCache);
			}
			catch (\Throwable $e)
			{
				// do nothing
			}

			self::mergeToAvailableCertificates($availableCertificates, $containerCertificates);

			$certificates = $availableCertificates;
		}

		return $certificates;
	}

	/**
	 * Возвращает сертификат по отпечатку
	 *
	 * @param   string  $thumbprint  отпечаток сертификата
	 * @param   bool    $validOnly   проверять сертификат по дате и наличию приватного ключа
	 *
	 * @throws \Exception
	 * @return Certificate
	 */
	public static function getCertificate(string $thumbprint, bool $validOnly = true)
	{
		$thumbprint = trim($thumbprint);

		if (!$thumbprint)
		{
			throw new \Exception('Отпечаток не указан');
		}

		if ($validOnly === true)
		{
			$certificates = self::getCertificates();
		}
		else
		{
			$certificates = self::getAllCertificates();
		}

		$found = false;

		foreach ($certificates as $certificate)
		{
			if ($certificate->thumbprint === $thumbprint)
			{
				$found = $certificate;
				break;
			}
		}

		if ($found === false)
		{
			throw new \Exception('Сертификат с отпечатком: "' . $thumbprint . '" не найден');
		}

		return $found;
	}

	/**
	 * Создает совмещенную (присоединенную) подпись сообщения
	 *
	 * @param   string       $thumbprint          отпечаток сертификата
	 * @param   string       $unencryptedMessage  подписываемое сообщение
	 * @param   string|null  $pin                 пин-код доступа к закрытому ключу
	 *
	 * @throws \Exception
	 * @return string подпись в формате PKCS#7
	 */
	public static function createAttachedSignature(string $thumbprint, string $unencryptedMessage, string $pin = null)
	{
		$cadesCertificate = self::getCadesCertificate($thumbprint);

		try
		{
			$cadesAttrs      = new \CPAttribute();
			$cadesSignedData = new \CPSignedData();
			$cadesSigner     = new \CPSigner();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при инициализации подписи'));
		}

		// Дату и время устанавливаем в формате generalizedTime https://docs.cryptopro.ru/pki/cplib/class/cdatetime?id=cdatetime-1
		$currentDateTime = (new \DateTime())->format('YmdHis.u') . 'Z';

		try
		{
			$cadesAttrs->set_Name(AUTHENTICATED_ATTRIBUTE_SIGNING_TIME);
			$cadesAttrs->set_Value($currentDateTime);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке времени подписи'));
		}

		$messageBase64 = base64_encode($unencryptedMessage);

		try
		{
			if (!empty($pin))
			{
				$cadesSigner->set_KeyPin($pin);
			}

			$cadesSigner->set_Certificate($cadesCertificate);

			/** @var \CPAttributes $cadesAuthAttrs */
			$cadesAuthAttrs = $cadesSigner->get_AuthenticatedAttributes();
			$cadesAuthAttrs->Add($cadesAttrs);

			$cadesSignedData->set_ContentEncoding(BASE64_TO_BINARY);
			$cadesSignedData->set_Content($messageBase64);

			$cadesSigner->set_Options(CERTIFICATE_INCLUDE_WHOLE_CHAIN);

		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при указании данных для подписи'));
		}

		try
		{
			/** @var string $signature */
			$signature = $cadesSignedData->SignCades(
				$cadesSigner,
				PKCS7_TYPE,
				false,
				ENCODE_BASE64
			);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при подписании данных'));
		}

		return $signature;
	}

	/**
	 * Создает отсоединенную (открепленную) подпись сообщения
	 *
	 * @param   string       $thumbprint   отпечаток сертификата
	 * @param   string       $messageHash  хеш подписываемого сообщения, сгенерированный по ГОСТ Р 34.11-2012 256 бит
	 * @param   string|null  $pin          пин-код доступа к закрытому ключу
	 *
	 * @throws \Exception
	 * @return string подпись в формате PKCS#7
	 */
	public static function createDetachedSignature(string $thumbprint, string $messageHash, string $pin = null)
	{
		$cadesCertificate = self::getCadesCertificate($thumbprint);

		try
		{
			$cadesAttrs      = new \CPAttribute();
			$cadesSignedData = new \CPSignedData();
			$cadesHashedData = new \CPHashedData();
			$cadesSigner     = new \CPSigner();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при инициализации подписи'));
		}

		// Дату и время устанавливаем в формате generalizedTime https://docs.cryptopro.ru/pki/cplib/class/cdatetime?id=cdatetime-1
		$currentDateTime = (new \DateTime())->format('YmdHis.u') . 'Z';

		try
		{
			$cadesAttrs->set_Name(AUTHENTICATED_ATTRIBUTE_SIGNING_TIME);
			$cadesAttrs->set_Value($currentDateTime);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке времени подписи'));
		}

		try
		{
			if (!empty($pin))
			{
				$cadesSigner->set_KeyPin($pin);
			}

			$cadesSigner->set_Certificate($cadesCertificate);

			$cadesAuthAttrs = $cadesSigner->get_AuthenticatedAttributes();
			$cadesAuthAttrs->Add($cadesAttrs);

			$cadesSigner->set_Options(CERTIFICATE_INCLUDE_WHOLE_CHAIN);

		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке сертификата'));
		}

		try
		{
			$cadesHashedData->set_Algorithm(CADESCOM_HASH_ALGORITHM_CP_GOST_3411_2012_256);
			$cadesHashedData->SetHashValue($messageHash);

			// Для получения объекта отсоединенной (открепленной) подписи, необходимо задать любой контент.
			// Этот баг описан на форуме.
			// https://www.cryptopro.ru/forum2/default.aspx?g=posts&m=78553#post78553
			$cadesSignedData->set_Content(123);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке хеша'));
		}

		try
		{
			$signature = $cadesSignedData->SignHash($cadesHashedData, $cadesSigner, PKCS7_TYPE);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при подписании данных'));
		}

		return $signature;
	}

	/**
	 * добавляет совмещенную (присоединенную) подпись к раннее подписанному документу (реализует метод coSign)
	 *
	 * @param   string       $thumbprint  отпечаток сертификата
	 * @param   string       $signedMessage
	 * @param   string|null  $pin         пин-код доступа к закрытому ключу
	 *
	 * @throws \Exception
	 * @return string
	 */
	public static function addAttachedSignature(string $thumbprint, string $signedMessage, string $pin = null)
	{
		$cadesCertificate = self::getCadesCertificate($thumbprint);

		try
		{
			$cadesAttrs      = new \CPAttribute();
			$cadesSignedData = new \CPSignedData();
			$cadesSigner     = new \CPSigner();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при инициализации подписи'));
		}

		// Дату и время устанавливаем в формате generalizedTime https://docs.cryptopro.ru/pki/cplib/class/cdatetime?id=cdatetime-1
		$currentDateTime = (new \DateTime())->format('YmdHis.u') . 'Z';

		try
		{
			$cadesAttrs->set_Name(AUTHENTICATED_ATTRIBUTE_SIGNING_TIME);
			$cadesAttrs->set_Value($currentDateTime);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке времени подписи'));
		}

		$messageBase64 = base64_encode($signedMessage);

		try
		{
			if (!empty($pin))
			{
				$cadesSigner->set_KeyPin($pin);
			}

			$cadesSigner->set_Certificate($cadesCertificate);

			$cadesAuthAttrs = $cadesSigner->get_AuthenticatedAttributes();
			$cadesAuthAttrs->Add($cadesAttrs);

			$cadesSignedData->set_ContentEncoding(BASE64_TO_BINARY);
			$cadesSignedData->set_Content($messageBase64);

			$cadesSigner->set_Options(CERTIFICATE_INCLUDE_WHOLE_CHAIN);

		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при указании данных для подписи'));
		}

		try
		{
			$cadesSignedData->VerifyCades($signedMessage, PKCS7_TYPE);
			$signature = $cadesSignedData->CoSignCades($cadesSigner, PKCS7_TYPE);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при подписании данных'));
		}

		return $signature;
	}

	/**
	 * Добавляет отсоединенную (открепленную) подпись к раннее подписанному документу (реализует метод coSign)
	 *
	 * @param   string       $thumbprint     отпечаток сертификата
	 * @param   string       $signedMessage  подписанное сообщение
	 * @param   string       $messageHash    хеш подписываемого сообщения, сгенерированный по ГОСТ Р 34.11-2012 256 бит
	 * @param   string|null  $pin            пин-код доступа к закрытому ключу
	 *
	 * @throws \Exception
	 * @return string подпись в формате PKCS#7
	 */
	public static function addDetachedSignature(string $thumbprint, string $signedMessage, string $messageHash, string $pin = null)
	{
		$cadesCertificate = self::getCadesCertificate($thumbprint);

		try
		{
			$cadesAttrs      = new \CPAttribute();
			$cadesSignedData = new \CPSignedData();
			$cadesHashedData = new \CPHashedData();
			$cadesSigner     = new \CPSigner();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при инициализации подписи'));
		}

		// Дату и время устанавливаем в формате generalizedTime https://docs.cryptopro.ru/pki/cplib/class/cdatetime?id=cdatetime-1
		$currentDateTime = (new \DateTime())->format('YmdHis.u') . 'Z';

		try
		{
			$cadesAttrs->set_Name(AUTHENTICATED_ATTRIBUTE_SIGNING_TIME);
			$cadesAttrs->set_Value($currentDateTime);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке времени подписи'));
		}

		try
		{
			if (!empty($pin))
			{
				$cadesSigner->set_KeyPin($pin);
			}

			$cadesSigner->set_Certificate($cadesCertificate);

			$cadesAuthAttrs = $cadesSigner->get_AuthenticatedAttributes();
			$cadesAuthAttrs->Add($cadesAttrs);

			$cadesSigner->set_Options(CERTIFICATE_INCLUDE_WHOLE_CHAIN);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке сертификата'));
		}

		try
		{
			$cadesHashedData->set_Algorithm(CADESCOM_HASH_ALGORITHM_CP_GOST_3411_2012_256);
			$cadesHashedData->SetHashValue($messageHash);

			// Для получения объекта отсоединенной (открепленной) подписи, необходимо задать любой контент.
			// Этот баг описан на форуме.
			// https://www.cryptopro.ru/forum2/default.aspx?g=posts&m=78553#post78553
			$cadesSignedData->set_Content(123);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке хеша'));
		}

		try
		{
			$cadesSignedData->VerifyHash($cadesHashedData, $signedMessage, PKCS7_TYPE);

			$signature = $cadesSignedData->CoSignHash($cadesHashedData, $cadesSigner, PKCS7_TYPE);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при подписании данных'));
		}

		return $signature;
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
	 * Создает хеш сообщения по ГОСТ Р 34.11-2012 256 бит
	 *
	 * @param   string  $unencryptedMessage  сообщение для хеширования
	 *
	 * @throws \Exception
	 * @return string
	 */
	public static function createHash(string $unencryptedMessage)
	{
		try
		{
			$cadesHashedData = new \CPHashedData();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при инициализации хэширования'));
		}

		$messageBase64 = base64_encode($unencryptedMessage);

		try
		{
			$cadesHashedData->set_Algorithm(CADESCOM_HASH_ALGORITHM_CP_GOST_3411_2012_256);
			$cadesHashedData->set_DataEncoding(BASE64_TO_BINARY);
			$cadesHashedData->Hash($messageBase64);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при установке хэширования'));
		}

		try
		{
			$hash = $cadesHashedData->get_Value();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при создании хэша'));
		}

		return $hash;
	}

	/**
	 * возвращает информацию о CSP и плагине
	 *
	 * @return void
	 */
	public static function getSystemInfo()
	{
	}

	/**
	 * @param   int     $storeLocation
	 * @param   string  $storeName
	 * @param   bool    $validOnly  Логическое значение , указывающее, возвращаются ли только действительные сертификаты.
	 *                              Если значение равно true, поиск не вернет следующие типы сертификатов:
	 *                              <ul>
	 *                              <li>
	 *                              Сертификаты, срок действия которых истек или еще не действителен.
	 *                              </li>
	 *                              <li>
	 *                              Сертификаты, в которых отсутствует закрытый ключ.
	 *                              </li>
	 *                              <li>
	 *                              Сертификаты не связаны должным образом.
	 *                              </li>
	 *                              <li>
	 *                              Сертификаты, у которых возникли проблемы с подписью.
	 *                              </li>
	 *                              <li>
	 *                              Отозванные сертификаты.
	 *                              </li>
	 *                              </ul>
	 *
	 * @throws \Exception
	 * @return array
	 */
	protected static function getCertificatesFromStore(int $storeLocation, string $storeName = 'My', bool $validOnly = true)
	{
		$certificates = [];

		try
		{
			$cadesStore = new \CPStore();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при попытке доступа к хранилищу'));
		}

		try
		{
			$cadesStore->Open($storeLocation, $storeName, STORE_OPEN_MAXIMUM_ALLOWED);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при открытии хранилища'));
		}

		try
		{
			$cadesCertificates = $cadesStore->get_Certificates();

			if ($validOnly === true)
			{
				$cadesCertificates = $cadesCertificates->Find(
					CAPICOM_CERTIFICATE_FIND_TYPE::TIME_VALID,
					'',
					true
				);

				$cadesCertificates = $cadesCertificates->Find(
					CAPICOM_CERTIFICATE_FIND_TYPE::EXTENDED_PROPERTY,
					CAPICOM_PROPID::KEY_PROV_INFO,
					true
				);
			}

			$cadesCertificatesCount = $cadesCertificates->Count();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка получения списка сертификатов'));
		}

		if (!$cadesCertificatesCount)
		{
			throw new \Exception('Нет доступных сертификатов');
		}

		try
		{
			while ($cadesCertificatesCount)
			{
				$cadesCertificate = $cadesCertificates->Item($cadesCertificatesCount);

				$certificates[] = new Certificate(
					$cadesCertificate,
					CertificateHelper::extractCommonName($cadesCertificate->get_SubjectName()),
					$cadesCertificate->get_IssuerName(),
					$cadesCertificate->get_SubjectName(),
					$cadesCertificate->get_Thumbprint(),
					$cadesCertificate->get_ValidFromDate(),
					$cadesCertificate->get_ValidToDate()
				);

				$cadesCertificatesCount--;
			}
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка обработки сертификатов'));
		}

		$cadesStore->Close();

		return $certificates;
	}

	protected static function getCadesCertificateFromStore(string $thumbprint, int $storeLocation, string $storeName = 'My')
	{
		try
		{
			$cadesStore = new \CPStore();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при попытке доступа к хранилищу'));
		}

		try
		{
			$cadesStore->Open($storeLocation, $storeName, STORE_OPEN_MAXIMUM_ALLOWED);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при открытии хранилища'));
		}

		try
		{
			$cadesCertificates      = $cadesStore->get_Certificates();
			$cadesCertificatesCount = $cadesCertificates->Count();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка получения списка сертификатов из хранилища'));
		}

		if (!$cadesCertificatesCount)
		{
			throw new \Exception('Нет доступных сертификатов в хранилище');
		}

		try
		{
			$cadesCertificates = $cadesCertificates->Find(
				CAPICOM_CERTIFICATE_FIND_TYPE::SHA1_HASH,
				$thumbprint,
				false
			);

			$cadesCertificatesCount = $cadesCertificates->Count();

			if (!$cadesCertificatesCount)
			{
				throw new \Exception('Сертификат с отпечатком: "' . $thumbprint . '" не найден в хранилище');
			}

			// Считаем, что первый сертификат, найденный по отпечатку - наш
			$cadesCertificate = $cadesCertificates->Item(1);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при получении сертификата из хранилища'));
		}

		return $cadesCertificate;
	}

	protected static function mergeToAvailableCertificates(array &$availableCertificates = [], array $mergedCertificates = [])
	{
		if (empty($availableCertificates))
		{
			$availableCertificates = $mergedCertificates;
		}
		else
		{
			if (!empty($mergedCertificates))
			{
				$mergedCertificatesCount = count($mergedCertificates) - 1;

				while ($mergedCertificatesCount)
				{
					$found = false;

					$currentCertificate = $mergedCertificates[$mergedCertificatesCount];

					foreach ($availableCertificates as $certificate)
					{
						if ($certificate->thumbprint === $currentCertificate->thumbprint)
						{
							$found = true;
							break;
						}
					}

					if ($found)
					{
						continue;
					}

					$availableCertificates[] = $currentCertificate;
				}
			}
		}
	}

	/**
	 * Возвращает сертификат в формате Cades по отпечатку.
	 * Сначала ищет в хранилище пользователя, потм - в хранилище закрытого ключа
	 *
	 * @param   string  $thumbprint
	 *
	 * @throws \Exception
	 * @return \CPCertificate
	 */
	protected static function getCadesCertificate(string $thumbprint)
	{
		try
		{
			$cadesCertificate = self::getCadesCertificateFromStore($thumbprint, CURRENT_USER_STORE);
		}
		catch (\Throwable $e)
		{
			$previousException = $e;

			try
			{
				$cadesCertificate = self::getCadesCertificateFromStore($thumbprint, CONTAINER_STORE);
			}
			catch (\Throwable $e)
			{
				throw new \Exception($e->getMessage(), $e->getCode(), $previousException);
			}
		}

		return $cadesCertificate;
	}
}