<?php

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

try
{
	$certificates = \Webmasterskaya\CryptoPro\CryptoPro::getUserCertificates();
}
catch (\Exception $e)
{
	print $e->getMessage() . PHP_EOL;
	exit;
}

foreach ($certificates as $certificate)
{
	$owner = $certificate->getOwnerInfo();

	print PHP_EOL;
	print '==================================================' . PHP_EOL;
	print PHP_EOL;

	print $certificate->name . PHP_EOL;

	print 'Отпечаток:' . PHP_EOL;
	print "\t" . $certificate->thumbprint . PHP_EOL;

	print 'Подписант:' . PHP_EOL;
	foreach ($owner as $item)
	{
		if ($item['RDN'] == 'CN' || $item['RDN'] == 'UN')
		{
			continue;
		}

		print "\t" . $item['title'] . ': ' . $item['description'] . PHP_EOL;
	}

	print 'Область использования ключа:' . PHP_EOL;
	foreach ($certificate->getDecodedExtendedKeyUsage() as $oid => $title)
	{
		print "\t" . $title . ' (OID: ' . $oid . ')' . PHP_EOL;
	}

	$algorithm = $certificate->getAlgorithm();
	print 'Алгоритм сертификата:' . PHP_EOL;
	print "\t" . $algorithm['algorithm'] . ' (OID: ' . $algorithm['oid'] . ')' . PHP_EOL;

	print 'Срок действия сертификата:' . PHP_EOL;
	print "\t" . 'c: ' . $certificate->validFrom . PHP_EOL;
	print "\t" . 'до: ' . $certificate->validTo . PHP_EOL;

	print PHP_EOL;
	print '==================================================' . PHP_EOL;
	print PHP_EOL;
}