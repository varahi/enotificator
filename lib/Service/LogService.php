<?php

namespace OCA\Enotificator\Service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use OCP\Files\IRootFolder;
use OCP\IConfig;

class LogService
{
    private $log;
    /** @var  \OCP\IConfig */
    private $config;
    private $rootFolder;

    public function __construct(IConfig $config, IRootFolder $root, $appName)
    {
        $this->config = $config;
        $this->rootFolder = $root;
        $this->appName = $appName;

        $this->log = new Logger('Enotificator');
        $logFileName = $this->config->getAppValue($this->appName, 'logFileName');
        $this->log->pushHandler(new StreamHandler($logFileName, Logger::INFO));
    }

    public function log($message, $data = [])
    {
        $this->log->info($message, $data);
    }
}
