<?php

namespace Amon\Core;

use Closure;
use Amon\Core\Framework\AbstractFramework;
use Amon\Helper\Other;

class Framework extends AbstractFramework
{
	protected string $environment;
	protected $config;
	protected $dirs;
    protected $router;
	public $base_uri;

	public function run() {
		$this->config = $this->di->getConfig();
		$this->dirs = $this->di->getLoader()->getDirs(true);
        $this->environment = $this->config->application->environment;
		$this->router = $this->di->getRouter();
		$this->boot();
		$this->getContent();
	}

    private function boot(): void
    {
        \error_reporting(0);
        if ($this->environment === 'dev') {
            \error_reporting(E_ALL);
            \ini_set('display_errors', '1');
        }

        date_default_timezone_set($this->config->application->timezone);

		$default_route = $this->router->getRoute($this->config->application->default_route);
		if (!$default_route) {
			throw new \Exception("A default route named <b>" . $this->config->application->default_route . "</b> does not exist");
		}
		$this->base_uri = $this->router->getBasePath() . '/' ?: '/';
    }

	private function getContent() {
		$this->router->Route();
	}
}