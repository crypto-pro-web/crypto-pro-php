<?php

namespace Webmasterskaya\CryptoPro\Tags;

class TagsOIDs extends AbstractTagsOIDs
{
	protected const MAP
		= [
			'1.2.840.113549.1.9.2' => 'UN',
			'2.5.4.3'              => 'CN',
			'2.5.4.4'              => 'SN',
			'2.5.4.42'             => 'G',
			'2.5.4.6'              => 'C',
			'2.5.4.8'              => 'S',
			'2.5.4.9'              => 'STREET',
			'2.5.4.10'             => 'O',
			'2.5.4.11'             => 'OU',
			'2.5.4.12'             => 'T',
			'1.2.643.100.1'        => 'OGRN',
			'1.2.643.100.5'        => 'OGRNIP',
			'1.2.643.100.3'        => 'SNILS',
			'1.2.643.3.131.1.1'    => 'INN',
			'1.2.643.100.4'        => 'INNLE',
			'1.2.840.113549.1.9.1' => 'E',
			'2.5.4.7'              => 'L',
		];
}