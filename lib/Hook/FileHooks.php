<?php

namespace OCA\Enotificator\Hook;

//use OCA\Enotificator\Service\LogService;
use OCP\Files\Node;

class FileHooks
{
    private $root;

    public const HOOKS = [
        // 'postWrite',
        'postCreate',
        // 'postDelete',
        // 'postTouch',
        // 'postCopy',
        // 'postRename'

    ];

    // public const STATES = [
    //     'active',
    //     'inactive'
    // ];

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function register()
    {
        $reference = $this;

        // $postWrite = function (Node $node) use ($reference) {
        //     $reference->postWrite($node);
        // };
        $postCreate = function (Node $node) use ($reference) {
            $reference->postCreate($node);
        };
        // $postDelete = function (Node $node) use ($reference) {
        //     $reference->postDelete($node);
        // };
        // $postTouch = function (Node $node) use ($reference) {
        //     $reference->postTouch($node);
        // };
        // $postCopy = function (Node $source, Node $target) use ($reference) {
        //     $reference->postCopy($source, $target);
        // };
        // $postRename = function (Node $source, Node $target) use ($reference) {
        //     $reference->postRename($source, $target);
        // };

        // register listeners for file system events
        foreach (self::HOOKS as $hook) {

            $this->root->listen('\OC\Files', $hook, ${$hook});
        }
    }

    /**
     * @param Node $node
     */
    public function postCreate(Node $node)
    {
        $data = array(
            'name' => $node->getName(),
            'size' => $node->getSize(),
            'path' => $node->getPath(),
            'internalPath' => $node->getInternalPath(),
            'id' => $node->getId(),
            'owner' => $node->getOwner()->getUserName(),
            'datetime' => $node->getMTime()
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($data),
                'header' => "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
            )
        );

        $context = stream_context_create($options);
        $url = "https://webhook.site/69c719c2-e3c9-4f6b-a54c-16d88ae2be9c";
        $result = file_get_contents($url, false, $context);
        // $response = json_decode($result);

    }

// /**
//  * @param Node $node
//  */
// public function postCreate(Node $node)
// {

// }

// /**
//  * @param Node $node
//  */
// public function postDelete(Node $node)
// {
//     $this->logService->log('File deleted', ['path' => $node->getPath()]);
//     file_put_contents('/var/www/owncloud/test.txt', $node);
// }

// /**
//  * @param Node $node
//  */
// public function postTouch(Node $node)
// {
//     $this->logService->log('File viewed', ['path' => $node->getPath()]);
// }

// /**
//  * @param Node $source
//  */
// public function postCopy(Node $source, Node $target)
// {
//     $this->logService->log(
//         'File ' . $source->getName() . ' to ' . $target->getName() . ' copied',
//         [
//             'path_old' => $source->getPath(),
//             'path_new' => $target->getPath()
//         ]
//     );
// }

// /**
//  * @param Node $source
//  */
// public function postRename(Node $source, Node $target)
// {
//     $this->logService->log(
//         'File ' . $source->getName() . ' to ' . $target->getName() . ' renamed',
//         [
//             'path_old' => $source->getPath(),
//             'path_new' => $target->getPath()
//         ]
//     );
// }



}