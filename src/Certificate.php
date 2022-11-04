<?php

namespace Webmasterskaya\CryptoPro;

use Webmasterskaya\CryptoPro\Constants\OIDsDictionary;
use Webmasterskaya\CryptoPro\Dictionary\IssuerTagsDictionary;
use Webmasterskaya\CryptoPro\Dictionary\SubjectTagsDictionary;
use Webmasterskaya\CryptoPro\Helpers\ArrayHelper;
use Webmasterskaya\CryptoPro\Helpers\CertificateHelper;
use Webmasterskaya\CryptoPro\Helpers\ErrorMessageHelper;
use Webmasterskaya\CryptoPro\Tags\IssuerTagsTranslations;
use Webmasterskaya\CryptoPro\Tags\SubjectTagsTranslations;
use Webmasterskaya\CryptoPro\Tags\TagsTranslationsInterface;

class Certificate
{

	public $_cadesCertificate;
	public $name;
	public $issuerName;
	public $subjectName;
	public $thumbprint;
	public $validFrom;
	public $validTo;

	public function __construct(
		\CPCertificate $cadesCertificate,
		string $name,
		string $issuerName,
		string $subjectName,
		string $thumbprint,
		string $validFrom,
		string $validTo
	)
	{
		$this->_cadesCertificate = $cadesCertificate;
		$this->name              = $name;
		$this->issuerName        = $issuerName;
		$this->subjectName       = $subjectName;
		$this->thumbprint        = $thumbprint;
		$this->validFrom         = $validFrom;
		$this->validTo           = $validTo;
	}

	/**
	 * возвращает флаг действительности сертификата
	 *
	 * @throws \Exception
	 * @return bool
	 */
	public function isValid()
	{
		try
		{
			$isValid = $this->_cadesCertificate->IsValid();
			$isValid = (bool) $isValid->get_Result();
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при проверке сертификата'));
		}

		return $isValid;
	}

	/**
	 * возвращает указанное внутренее свойство у сертификата в формате Cades
	 *
	 * @param   string  $propName  наименование свойства
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	public function getCadesProp(string $propName)
	{
		try
		{
			if (method_exists($this->_cadesCertificate, 'get_' . $propName))
			{
				$propertyValue = call_user_func([$this->_cadesCertificate, 'get_' . $propName]);
			}
			else
			{
				throw new \Exception();
			}
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при обращении к свойству сертификата'));
		}

		return $propertyValue;
	}

	/**
	 * возвращает сертификат в формате base64
	 *
	 * @return void
	 */
	public function exportBase64()
	{
	}

	/**
	 * возвращает информацию об алгоритме сертификата
	 *
	 * @throws \Exception
	 * @return AlgorithmInfoInterface
	 */
	public function getAlgorithm()
	{
		try
		{
			$cadesPublicKey          = $this->_cadesCertificate->PublicKey();
			$cadesPublicKeyAlgorithm = $cadesPublicKey->get_Algorithm();
			$algorithmInfo           = new class(
				$cadesPublicKeyAlgorithm->get_FriendlyName(),
				$cadesPublicKeyAlgorithm->get_Value()) extends AbstractAlgorithmInfo {
			};
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при получении алгоритма'));
		}

		return $algorithmInfo;
	}

	/**
	 * возвращает расшифрованную информацию о владельце сертификата
	 *
	 * @throws \Exception
	 * @return array|array[]
	 */
	public function getOwnerInfo()
	{
		return $this->getInfo(SubjectTagsDictionary::class, 'SubjectName');
	}

	/**
	 * @param   string  $dictionary
	 * @param   string  $entitiesPath
	 *
	 * @throws \Exception
	 * @return array|array[]
	 */
	protected function getInfo(string $dictionary, string $entitiesPath)
	{
		try
		{
			$entities = $this->getCadesProp($entitiesPath);
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, 'Ошибка при извлечении информации из сертификата'));
		}

		return CertificateHelper::parseCertInfo($dictionary, $entities);
	}

	/**
	 * возвращает расшифрованную информацию об издателе сертификата
	 *
	 * @throws \Exception
	 * @return array|array[]
	 */
	public function getIssuerInfo()
	{
		return $this->getInfo(IssuerTagsDictionary::class, 'IssuerName');
	}

	/**
	 * возвращает ОИД'ы сертификата
	 *
	 * @throws \Exception
	 * @return array
	 */
	public function getExtendedKeyUsage()
	{
		$OIDs = [];

		try
		{
			$cadesExtendedKeysUsage      = $this->_cadesCertificate->ExtendedKeyUsage();
			$cadesExtendedKeysUsage      = $cadesExtendedKeysUsage->get_EKUs();
			$cadesExtendedKeysUsageCount = $cadesExtendedKeysUsage->get_Count();

			if ($cadesExtendedKeysUsageCount > 0)
			{
				while ($cadesExtendedKeysUsageCount)
				{
					$cadesExtendedKeyUsage = $cadesExtendedKeysUsage->get_Item($cadesExtendedKeysUsageCount);
					$OIDs[]                = $cadesExtendedKeyUsage->get_OID();

					$cadesExtendedKeysUsageCount--;
				}
			}
		}
		catch (\Throwable $e)
		{
			throw new \Exception(ErrorMessageHelper::getErrorMessage($e, "Ошибка при получении ОИД'ов"));
		}

		return $OIDs;
	}

	/**
	 * возвращает расшифрованные ОИД'ы
	 *
	 * @throws \Exception
	 * @return array
	 */
	public function getDecodedExtendedKeyUsage()
	{
		$certOIDs = $this->getExtendedKeyUsage();

		$decodedOIDs = [];

		foreach ($certOIDs as $OID)
		{
			$decodedOIDs[$OID] = OIDsDictionary::MAP[$OID] ?? null;
		}

		return $decodedOIDs;
	}

	/**
	 * проверяет наличие ОИД'а (ОИД'ов) у сертификата
	 *
	 * @param   string|array  $OIDs
	 *
	 * @throws \Exception
	 * @return bool
	 */
	public function hasExtendedKeyUsage($OIDs)
	{
		$certOIDs = $this->getExtendedKeyUsage();

		if (is_string($OIDs))
		{
			$OIDs = [$OIDs];
		}

		if (!is_array($OIDs))
		{
			$OIDs = (array) $OIDs;
		}

		return ArrayHelper::every($OIDs, function ($oidToCheck) use ($certOIDs) {
			return in_array($oidToCheck, $certOIDs);
		});
	}
}