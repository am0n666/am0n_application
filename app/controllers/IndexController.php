<?php

class IndexController extends ControllerBase
{
    public function IndexAction($params)
    {
		echo 'Page load time: ' . timeSinceStartOfRequest() . ' ms.<br>IndexController->IndexAction()';
	}
}

