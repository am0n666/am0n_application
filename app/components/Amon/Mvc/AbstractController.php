<?php

namespace Amon\Mvc;

use Amon\Di\Injectable;

abstract class AbstractController extends Injectable implements ControllerInterface {
	 public  function __construct () {
		if (method_exists($this,"onConstruct")) {
			$this->onConstruct();
		}
	}
}
?>
