<?php

namespace Webmasterskaya\CryptoPro\Tags;

class TagsCodes extends AbstractTagsCodes
{
	protected const MAP
		= [
			'UN'     => ['UN', 'unstructuredName'],
			'CN'     => ['CN', 'commonName'],
			'SN'     => ['SN', 'surname'],
			'G'      => ['G', 'givenName', 'gn'],
			'C'      => ['C', 'countryName'],
			'S'      => ['S', 'ST', 'stateOrProvinceName'],
			'STREET' => ['STREET', 'streetAddress'],
			'O'      => ['O', 'organizationName'],
			'OU'     => ['OU', 'organizationalUnitName'],
			'T'      => ['T', 'TITLE'],
			'OGRN'   => ['OGRN', 'ОГРН'],
			'OGRNIP' => ['OGRNIP', 'ОГРНИП'],
			'SNILS'  => ['СНИЛС', 'SNILS'],
			'INN'    => ['ИНН', 'ИННФЛ', 'ИНН ФЛ', 'INN'],
			'INNLE'  => ['ИННЮЛ', 'ИНН ЮЛ', 'INNLE', 'INN LE', 'ИНН организации'],
			'E'      => ['E', 'email', 'emailAddress', 'pkcs9email'],
			'L'      => ['L', 'localityName'],
		];
}