<?php

namespace Webmasterskaya\CryptoPro;

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
	 * @return void
	 */
	public static function getCertificate()
	{
	}

	/**
	 * создает совмещенную (присоединенную) подпись сообщения
	 *
	 * @return void
	 */
	public static function createAttachedSignature()
	{
	}

	/**
	 * создает отсоединенную (открепленную) подпись сообщения
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

		$cadesCertificates      = null;
		$cadesCertificatesCount = 0;

		try
		{
			$cadesCertificates = $cadesStore->get_Certificates();

			if ($cadesCertificates)
			{
				if ($validOnly === true)
				{
					$cadesCertificates = $cadesCertificates->Find(CERTIFICATE_FIND_TIME_VALID);
				}

				/**
				 * Не рассматриваются сертификаты, в которых отсутствует закрытый ключ
				 * или не действительны на данный момент
				 */
				if ($withPrivateKey === true)
				{
					$cadesCertificates = $cadesCertificates->Find(CERTIFICATE_FIND_EXTENDED_PROPERTY, CAPICOM_PROPID_KEY_PROV_INFO);
				}

				$cadesCertificatesCount = $cadesCertificates->Count();
			}
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