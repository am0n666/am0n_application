<?php

namespace Amon\Core\Framework;

use Amon\Di\DiInterface;
use Amon\Di\Injectable;

abstract class AbstractFramework extends Injectable
{
	protected $container;

	public  function __construct ($container = null)  {
		if (is_object($container)) {
			$this->container = $container;
		}
	}
}
?>
