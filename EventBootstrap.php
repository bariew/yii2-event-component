<?php
/**
 * MyClass class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace myname\mywidget;

use yii\base\BootstrapInterface;
use yii\base\Application;

/**
 * MyClass description
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class EventBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
             print_r($app->components['events']);
        });
    }
    
    private function getManagerName()
    {
    }
}