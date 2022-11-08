<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

class StandardTagsDictionary extends AbstractTagsDictionary
{
	protected const MAP
		= [
			[
				'RDN'            => 'UN',
				'OID'            => '1.2.840.113549.1.9.2',
				'title'          => 'Неструктурированное имя',
				'title_variants' => ['unstructuredName'],
			],
			[
				'RDN'            => 'CN',
				'OID'            => '2.5.4.3',
				'title'          => 'Удостоверяющий центр',
				'title_variants' => ['commonName'],
			],
			[
				'RDN'            => 'SN',
				'OID'            => '2.5.4.4',
				'title'          => 'Фамилия',
				'title_variants' => ['surname'],
			],
			[
				'RDN'            => 'G',
				'OID'            => '2.5.4.42',
				'title'          => 'Имя Отчество',
				'title_variants' => ['givenName', 'gn'],
			],
			[
				'RDN'            => 'C',
				'OID'            => '2.5.4.6',
				'title'          => 'Страна',
				'title_variants' => ['countryName'],
			],
			[
				'RDN'            => 'S',
				'OID'            => '2.5.4.8',
				'title'          => 'Регион',
				'title_variants' => ['ST', 'stateOrProvinceName'],
			],
			[
				'RDN'            => 'L',
				'OID'            => '2.5.4.7',
				'title'          => 'Город',
				'title_variants' => ['localityName'],
			],
			[
				'RDN'            => 'STREET',
				'OID'            => '2.5.4.9',
				'title'          => 'Адрес',
				'title_variants' => ['streetAddress'],
			],
			[
				'RDN'            => 'O',
				'OID'            => '2.5.4.10',
				'title'          => 'Компания',
				'title_variants' => ['organizationName'],
			],
			[
				'RDN'            => 'OU',
				'OID'            => '2.5.4.11',
				'title'          => 'Отдел/подразделение',
				'title_variants' => ['organizationalUnitName'],
			],
			[
				'RDN'            => 'T',
				'OID'            => '2.5.4.12',
				'title'          => 'Должность',
				'title_variants' => ['TITLE'],
			],
			[
				'RDN'            => 'E',
				'OID'            => '1.2.840.113549.1.9.1',
				'title'          => 'Email',
				'title_variants' => ['email', 'emailAddress', 'pkcs9email'],
			],
		];
}