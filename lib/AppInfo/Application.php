<?php

namespace OCA\Enotificator\AppInfo;

use OC\Files\Filesystem;
use OC\Files\View;
use OCA\Enotificator\Controller\Settings;
use OCA\Enotificator\Hook\SessionHooks;
use OCA\Enotificator\Service\LogService;
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
        $container->registerService('LogService', function ($c) {
            return new LogService(
                $c->query('ServerContainer')->getConfig(),
                $c->query('ServerContainer')->getRootFolder(),
                $c->getAppName()
            );
        });


        $container->registerService('FileHooks', function ($c) {
            return new \OCA\Enotificator\Hook\FileHooks(
                $c->query('ServerContainer')->getRootFolder(),
                $c->query('LogService'),
                $c->query('ServerContainer')->getConfig(),
                $c->getAppName()
            );
        });

        $container->registerService('SessionHooks', function ($c) {
            return new SessionHooks(
                $c->query('ServerContainer')->getUserSession(),
                $c->query('LogService')
            );
        });

        $container->registerService('SettingsController', function (IAppContainer $c) {
            /** @var \OC\Server $server */
            $server = $c->query('ServerContainer');

            return new Settings(
                $c->getAppName(),
                $server->getRequest(),
                $server->getConfig()
            );
        });

        $this->registerHooks();
    }

    public function registerHooks()
    {
        Util::connectHook('OC_Filesystem', FileSystem::signal_post_create, 'OCA\Enotificator\Hook\FileHooks', 'postCreate');
        Util::connectHook('OC_Filesystem', Filesystem::signal_post_update, 'OCA\Enotificator\Hook\FileHooks', 'postDelete');
        //$this->getContainer()->query('FileHooks')->register();
    }
}
