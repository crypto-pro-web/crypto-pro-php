<?php

namespace Webmasterskaya\CryptoPro;

use CPAttribute;
use Webmasterskaya\CryptoPro\Helpers\CertificateHelper;
use Webmasterskaya\CryptoPro\Helpers\ErrorMessageHelper;

class CryptoPro
{
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
			$certificates = self::getCertificatesFromStore(CURRENT_USER_STORE, MY_STORE, false, false);
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
			$certificates = self::getCertificatesFromStore(CONTAINER_STORE, MY_STORE, false, false);
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
	 * @param   string  $thumbprint          отпечаток сертификата
	 * @param   string  $unencryptedMessage  подписываемое сообщение
	 *
	 * @throws \Exception
	 * @return string подпись в формате PKCS#7
	 */
	public static function createAttachedSignature(string $thumbprint, string $unencryptedMessage)
	{
		try
		{
			$cadesCertificate = self::getCadesCertificateFromStore($thumbprint, CURRENT_USER_STORE);
		}
		catch (\Throwable $e)
		{
			$cadesCertificate = self::getCadesCertificateFromStore($thumbprint, CONTAINER_STORE);
		}

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

		$currentDateTime = (new \DateTime())->format('d.m.Y H:i:s');

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
			$signature = $cadesSignedData->SignCades($cadesSigner, PKCS7_TYPE);
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
	 * @return void
	 */
	public static function createDetachedSignature()
	{
	}

	/**
	 * добавляет совмещенную (присоединенную) подпись к раннее подписанному документу (реализует метод coSign)
	 *
	 * @return void
	 */
	public static function addAttachedSignature()
	{
	}

	/**
	 * добавляет отсоединенную (открепленную) подпись к раннее подписанному документу (реализует метод coSign)
	 *
	 * @return void
	 */
	public static function addDetachedSignature()
	{
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
	 * создает хеш сообщения по ГОСТ Р 34.11-2012 256 бит
	 *
	 * @return void
	 */
	public static function createHash()
	{
	}

	/**
	 * возвращает информацию о CSP и плагине
	 *
	 * @return void
	 */
	public static function getSystemInfo()
	{
	}

	protected static function getCertificatesFromStore(
		int $storeLocation, string $storeName = 'My', bool $validOnly = true, bool $withPrivateKey = true
	)
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

			/**
			 * Не рассматриваются сертификаты не действительны на данный момент
			 */
			if ($validOnly === true)
			{
				$cadesCertificates = $cadesCertificates->Find(CERTIFICATE_FIND_TIME_VALID);
			}

			/**
			 * Не рассматриваются сертификаты, в которых отсутствует закрытый ключ
			 */
			if ($withPrivateKey === true)
			{
				$cadesCertificates = $cadesCertificates->Find(CERTIFICATE_FIND_EXTENDED_PROPERTY, CAPICOM_PROPID_KEY_PROV_INFO);
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
					CertificateHelper::extractCommonName($cadesCertificate->SubjectName),
					$cadesCertificate->IssuerName,
					$cadesCertificate->SubjectName,
					$cadesCertificate->Thumbprint,
					$cadesCertificate->ValidFromDate,
					$cadesCertificate->ValidToDate
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
			$cadesCertificates = $cadesCertificates->Find(CERTIFICATE_FIND_SHA1_HASH, $thumbprint);

			$cadesCertificatesCount = $cadesCertificates->Count();

			if (!$cadesCertificatesCount)
			{
				throw new \Exception('Сертификат с отпечатком: "' . $thumbprint . '" не найден в хранилище');
			}

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
}