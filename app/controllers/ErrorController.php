<?php

class ErrorController extends ControllerBase
{
    public function NotfoundAction($params)
	{
		$back_to_home_button = '<br><a href="' . ($this->di->getFramework())->base_uri . '">Home</a>';
		echo 'Page not found.' . $back_to_home_button;
	}

    public function HandlerAction($params)
	{
		dump($params);
	}
}

