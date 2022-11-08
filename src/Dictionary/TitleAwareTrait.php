<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

trait TitleAwareTrait
{
	public static function getByTitle(string $title)
	{
		$title = mb_strtolower(trim($title));

		$map = static::getTitleMap();

		return isset($map[$title]) ? static::getResult($map[$title]) : null;
	}

	protected static function getTitleMap()
	{
		static $titleMap;

		if (!isset($titleMap))
		{
			foreach (static::getMap() as $row)
			{
				if (isset($row['title_variants']))
				{
					if (is_string($row['title_variants']))
					{
						$variant = mb_strtolower($row['title_variants']);
						if (!isset($titleMap[$variant]))
						{
							$titleMap[$variant] = $row;
						}
					}
					else
					{
						foreach ($row['title_variants'] as $variant)
						{
							$variant = mb_strtolower($variant);
							if (!isset($titleMap[$variant]))
							{
								$titleMap[$variant] = $row;
							}
						}
					}
				}

				if (isset($row['title']))
				{
					$variant = mb_strtolower($row['title']);
					if (!isset($titleMap[$variant]))
					{
						$titleMap[$variant] = $row;
					}
				}

				if (isset($row['RDN']))
				{
					$variant = mb_strtolower($row['RDN']);
					if (!isset($titleMap[$variant]))
					{
						$titleMap[$variant] = $row;
					}
				}
			}
		}

		return $titleMap;
	}
}