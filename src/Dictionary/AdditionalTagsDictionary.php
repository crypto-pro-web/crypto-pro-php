<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

class AdditionalTagsDictionary extends StandardTagsDictionary
{
	protected const MAP
		= [
			[
				'RDN'            => 'OGRN',
				'OID'            => '1.2.643.100.1',
				'title'          => 'ОГРН',
				'title_variants' => ['ОГРН'],
			],
			[
				'RDN'            => 'SNILS',
				'OID'            => '1.2.643.100.3',
				'title'          => 'СНИЛС',
				'title_variants' => ['СНИЛС'],
			],
			[
				'RDN'            => 'INN',
				'OID'            => '1.2.643.3.131.1.1',
				'title'          => 'ИНН',
				'title_variants' => ['ИННФЛ', 'ИНН ФЛ'],
			],
			[
				'RDN'            => 'INNLE',
				'OID'            => '1.2.643.100.4',
				'title'          => 'ИНН организации',
				'title_variants' => ['ИННЮЛ', 'ИНН ЮЛ', 'INN LE'],
			],
			[
				'RDN'            => 'OGRNIP',
				'OID'            => '1.2.643.100.5',
				'title'          => 'ОГРНИП',
				'title_variants' => ['ОГРНИП'],
			],
		];
}