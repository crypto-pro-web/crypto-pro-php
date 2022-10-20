<?php

namespace Webmasterskaya\CryptoPro\Helpers;

use Webmasterskaya\CryptoPro\Tags\TagsCodes;
use Webmasterskaya\CryptoPro\Tags\TagsOIDs;
use Webmasterskaya\CryptoPro\Tags\TagsTranslationsInterface;

class CertificateHelper
{
	public static function parseCertInfo(TagsTranslationsInterface $tagsTranslations, string $rawInfo)
	{
		$extractedEntities = [];

		preg_match_all('/([а-яА-Яa-zA-Z0-9\s.]+)=(?:("[^"]+?")|(.+?))(?:,|$)/', $rawInfo, $extractedEntities, PREG_SET_ORDER, 0);

		if (!empty($extractedEntities))
		{
			return array_map(function ($extractedEntity) use ($tagsTranslations) {

				$title = trim($extractedEntity[1]);

				// Проверяем наличие OID в заголовке
				$oidIdentifierMatch = [];
				$oidIdentifier      = null;
				if (preg_match('/^OID\.(.*)/', $title, $oidIdentifierMatch) === 1)
				{
					$oidIdentifier = trim($oidIdentifierMatch[1]);
				}

				// Если нашли OID в заголовке, пытаемся его расшифровать
				if (!empty($oidIdentifier))
				{
					$titleCode = TagsOIDs::codeByOid($oidIdentifier);

					if (empty($titleCode))
					{
						$titleCode = 'OID.' . $oidIdentifier;
					}
				}
				else
				{
					$titleCode = TagsCodes::codeByName($title);

					if (empty($titleCode))
					{
						$titleCode = $title;
					}
				}

				// Получаем человекочитаемый заголовок
				$title = $tagsTranslations::translationByCode($titleCode);

				// Вырезаем лишние кавычки
				$description = preg_replace(
					'/"{2}/g', '"',
					preg_replace(
						'/^"(.*)"/', "$1",
						trim($extractedEntity[2] ?? $extractedEntity[3])
					)
				);

				return ['title' => $title, 'description' => $description, 'code' => $titleCode];

			}, $extractedEntities);
		}

		return [];
	}
}