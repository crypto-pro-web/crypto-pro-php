<?php

namespace Webmasterskaya\CryptoPro\Helpers;

use Webmasterskaya\CryptoPro\Dictionary\DictionaryInterface;

class CertificateHelper
{
	public static function parseCertInfo($dictionary, string $rawInfo)
	{
		$implements = class_implements($dictionary);

		if (!isset($implements[DictionaryInterface::class]))
		{
			throw new \TypeError(
				sprintf(
					'Argument 1 passed to %s::parseCertInfo() must implement %s',
					get_called_class(), DictionaryInterface::class
				)
			);
		}

		$extractedEntities = [];

		preg_match_all(
			'/([\w0-9\s.]+)=(?:("[^"]+?")|(.+?))(?:,|$)/',
			$rawInfo,
			$extractedEntities,
			PREG_SET_ORDER,
			0
		);

		if (!empty($extractedEntities))
		{
			return array_map(function ($extractedEntity) use ($dictionary) {

				$title = trim($extractedEntity[1]);

				// Проверяем наличие OID в заголовке
				$oidIdentifierMatch = [];
				$oidIdentifier      = null;
				if (preg_match('/^OID\.(.*)/', $title, $oidIdentifierMatch) === 1)
				{
					$oidIdentifier = trim($oidIdentifierMatch[1]);
				}

				// Если нашли OID то декодируем по нему
				if (!empty($oidIdentifier))
				{
					$dictionaryItem = $dictionary::getByOID($oidIdentifier);
				}
				else
				{
					$dictionaryItem = $dictionary::getByTitle($title);
				}

				$result = [];

				// Получаем человекочитаемый заголовок
				if ($dictionaryItem !== null)
				{
					$title = $dictionaryItem->title ?? $title;
					$rdn   = $dictionaryItem->RDN ?? null;
					$oid   = $dictionaryItem->OID ?? null;
				}

				// Вырезаем лишние кавычки
				$description = preg_replace(
					'/"{2}/', '"',
					preg_replace(
						'/^"(.*)"/', "$1",
						trim($extractedEntity[2] ?: $extractedEntity[3])
					)
				);

				return [
					'title'       => $title,
					'description' => $description,
					'RDN'         => $rdn ?? null,
					'OID'         => $oid ?? null
				];
			}, $extractedEntities);
		}

		return [];
	}

	public static function extractCommonName($subjectName)
	{
		$subjectMatch = [];
		$commonName   = null;
		if (preg_match('/CN="?(.+?)"?(?:,|$)/', $subjectName, $subjectMatch))
		{
			$commonName = preg_replace('/"{2}/', '"', $subjectMatch[1]);
		}

		return $commonName;
	}
}