<?php

namespace Amon\Di;

class FactoryDefault extends \Amon\Di\Di
{
    public function __construct()
    {
        parent::__construct();
		$this->services = [
			"errorhandler"			=>		(new \Amon\Error\Handler())->register(),
			"flash"					=>		(new Service("Amon\\Flash", true ))
		];
    }
};
