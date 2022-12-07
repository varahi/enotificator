<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 20.11.17
 * Time: 20:04
 */

namespace OCA\Enotificator;


use OCP\Settings\ISettings;

class AdminPanel implements ISettings
{

    const PRIORITY = 10;

    /** @var AppInfo\Application */
    protected $app;

    public function __construct(\OCA\ENotificator\AppInfo\Application $app)
    {
        $this->app = $app;
    }

    public function getPanel()
    {
        return null;
    }

    public function getPriority()
    {
        return self::PRIORITY;
    }

    public function getSectionID()
    {
        return 'general';
    }
}
