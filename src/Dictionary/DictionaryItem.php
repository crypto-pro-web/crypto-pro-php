<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

abstract class DictionaryItem
{
	protected $options;

	protected function __construct(array $options)
	{
		$this->options = $options;
	}

	public function __get($name)
	{
		if (!isset($this->options[$name]))
		{
			user_error("Can't set property: " . __CLASS__ . "->" . $name);
		}

		return $this->options[$name];
	}

	public function __set($name, $value)
	{
		user_error("Can't set property: " . __CLASS__ . "->" . $name);
	}

	public static function getItem(array $options)
	{
		return new class($options) extends DictionaryItem {
		};
	}
}