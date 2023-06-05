<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

class SubjectTagsDictionary extends AdditionalTagsDictionary
{
	protected const MAP
		= [
			[
				'RDN'            => 'CN',
				'OID'            => '2.5.4.3',
				'title'          => 'Владелец',
				'title_variants' => ['commonName'],
			],
		];
}