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
class EventBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            $this->getEventManager($app)->init();
        });
        return true;
    }
    /**
     * finds and creates app event manager from its settings
     * @param Application $app yii app
     * @return EventManager app event manager component
     * @throws Exception Define event manager
     */
    private function getEventManager($app)
    {
        
        foreach ($app->components as $name => $config) {
            $class = is_string($config) ? $config : @$config['class'];
            if($class == str_replace('Bootstrap', 'Manager', get_class($this))){
                return $app->$name;
            }
        }
        throw new Exception("Please define event manager component in your config file.");
    }
}