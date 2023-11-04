<?php

namespace Amon\Core;

use Amon\Helper\Other;

class Config
{
	static private $_instance;
	static private $config = [];

	public function __construct(array $config = [])
	{
		return $config;
	}

	public static function getInstance(string $config_file_path)
	{
		if ( !(self::$_instance instanceof self) )
		{
			if (!is_file($config_file_path)) {
				self::$config = self::getDefault();
				if (self::writeFile($config_file_path)) {
					self::$config = include $config_file_path;
				}
			}else{
				self::$config = include $config_file_path;
			}
			self::$_instance = new self(self::$config);
		}
		return  Other::toObject(self::$config);
	}

	protected static function getDefault(): array
	{
		return [
			"application" => [
				"environment" => "dev",
				"timezone" => "Europe/Warsaw",
				"language" => "pl",
				"title" => "am0n PHP application",
				"default_route" => "home",
			],
		];
	}

	protected static function writeFile(string $config_file_path)
	{
		$code = "<?php\n\nreturn [\n\t\"application\" => [\n\t\t\"environment\" => \"" . self::$config['application']['environment'] . "\",\n\t\t\"timezone\" => \"" . self::$config['application']['timezone'] . "\",\n\t\t\"language\" => \"" . self::$config['application']['language'] . "\",\n\t\t\"title\" => \"" . self::$config['application']['title'] . "\",\n\t\t\"default_route\" => \"" . self::$config['application']['default_route'] . "\",\n\t],\n];";

		return file_put_contents($config_file_path, $code);
	}

}
