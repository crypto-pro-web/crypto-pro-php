<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

abstract class AbstractTagsDictionary extends AbstractDictionary implements RDNAwareInterface, TitleAwareInterface, OIDAwareInterface
{
	use RDNAwareTrait;
	use TitleAwareTrait;
	use OIDAwareTrait;
}