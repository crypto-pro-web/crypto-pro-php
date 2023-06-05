<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

class IssuerTagsDictionary extends AdditionalTagsDictionary
{
	protected const MAP
		= [
			[
				'RDN'            => 'CN',
				'OID'            => '2.5.4.3',
				'title'          => 'Удостоверяющий центр',
				'title_variants' => ['commonName'],
			],
		];
}