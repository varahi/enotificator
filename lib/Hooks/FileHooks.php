<?php

namespace OCA\Enotificator\Hook;

//use OCA\Enotificator\Service\LogService;
use OCP\Files\Node;

class FileHooks
{
    private $root;
    /** @var LogService */
    private $logService;
    private $config;

    public const HOOKS = [
        'postWrite',
        'postCreate',
        'postDelete',
        'postTouch',
        'postCopy',
        'postRename'
    ];

    public const STATES = [
        'active',
        'inactive'
    ];

    public function __construct($root, $logService, $config, $appName)
    {
        $this->root = $root;
        $this->logService = $logService;
        $this->config = $config;
        $this->appName = $appName;
    }

    public function register()
    {
        $reference = $this;

        $postWrite = function (Node $node) use ($reference) {
            $reference->postWrite($node);
        };
        $postCreate = function (Node $node) use ($reference) {
            $reference->postCreate($node);
        };
        $postDelete = function (Node $node) use ($reference) {
            $reference->postDelete($node);
        };
        $postTouch = function (Node $node) use ($reference) {
            $reference->postTouch($node);
        };
        $postCopy = function (Node $source, Node $target) use ($reference) {
            $reference->postCopy($source, $target);
        };
        $postRename = function (Node $source, Node $target) use ($reference) {
            $reference->postRename($source, $target);
        };

        // register listeners for file system events
        foreach (self::HOOKS as $hook) {
            $active = 'active' === $this->config->getAppValue($this->appName, $hook);
            if (true === $active) {
                $this->root->listen('\OC\Files', $hook, ${$hook});
            }
        }
    }

    /**
     * @param Node $node
     */
    public function postWrite(Node $node)
    {
        $this->logService->log('File written', ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postCreate(Node $node)
    {
        $this->logService->log('File created', ['path' => $node->getPath()]);
        file_put_contents('/var/www/owncloud/test.txt', $node);
    }

    /**
     * @param Node $node
     */
    public function postDelete(Node $node)
    {
        $this->logService->log('File deleted', ['path' => $node->getPath()]);
        file_put_contents('/var/www/owncloud/test.txt', $node);
    }

    /**
     * @param Node $node
     */
    public function postTouch(Node $node)
    {
        $this->logService->log('File viewed', ['path' => $node->getPath()]);
    }

    /**
     * @param Node $source
     */
    public function postCopy(Node $source, Node $target)
    {
        $this->logService->log(
            'File ' . $source->getName() . ' to ' . $target->getName() . ' copied',
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]
        );
    }

    /**
     * @param Node $source
     */
    public function postRename(Node $source, Node $target)
    {
        $this->logService->log(
            'File ' . $source->getName() . ' to ' . $target->getName() . ' renamed',
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]
        );
    }
}
