<?php

namespace OCA\Enotificator\AppInfo;

use OC\Files\Filesystem;
use OC\Files\View;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCP\IContainer;
use OCP\Util;
use Symfony\Component\EventDispatcher\GenericEvent;
use OCA\Enotificator\Hook\FileHooks;


class Application extends App
{
    public function __construct(array $urlParams = [])
    {
        parent::__construct('enotificator', $urlParams);

        $container = $this->getContainer();

        /**
         * Services
         */


        $container->registerService('FileHooks', function ($c) {
            return new FileHooks(
                $c->query('ServerContainer')->getRootFolder(),
            );
        });

        $this->registerHooks();
    }

    public function registerHooks()
    {
        $this->getContainer()->query('FileHooks')->register();
    }

}