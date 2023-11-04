<?php
declare(strict_types=1);

$di->setShared('loader', function () use ($loader) {
	return $loader;
});

$di->setShared('framework', function ($di) {
	return new \Amon\Core\Framework($di);
});

$di->setShared('config', function () {
	$dirs = ($this->getLoader())->getDirs(true);
	return \Amon\Core\Config::getInstance($dirs->configDir . "config.php");
});

$di->setShared('router', function () {
	$dirs = ($this->getLoader())->getDirs(true);
	(is_file($dirs->configDir . "routes.php")) ? $routes = include_once $dirs->configDir . "routes.php" : $routes = [];
    return \Amon\Routing\Router::getInstance($routes);
});

$di->setShared('event', function () {
	return \Amon\Core\Event::getInstance();
});