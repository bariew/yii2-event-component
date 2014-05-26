<?php
/**
 * EventBootstrap class file
 * @copyright Copyright (c) 2014 Galament
 * @license http://www.yiiframework.com/license/
 */

namespace bariew\eventManager;

use yii\base\BootstrapInterface;
use yii\base\Application;

/**
 * Bootstrap class initiates event manager.
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class CmsBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if(!$eventManager = $this->getEventManager($app)){
            return true;
        }
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($eventManager) {
            $eventManager->init();
        });
        return true;
    }
    /**
     * finds and creates app event manager from its settings
     * @param Application $app yii app
     * @return EventManager app event manager component
     * @throws Exception Define event manager
     */
    public static function attachModules($app)
    {
        $modules = $app->modules;
        foreach ($app->extensions as $name => $config) {
            $extName = preg_replace('/.*\/(.*)$/', '$1', $name);
            if(!preg_match('/yii2-(.+)-cms-module/', $extName, $matches)){
                continue;
            }
            $alias = key($config['alias']);
            $modules[$matches[1]] = str_replace(['@', '/'], ['\\', '\\'], $alias) .'\Module';
        }
        \Yii::configure($app, compact('modules'));
    }
}