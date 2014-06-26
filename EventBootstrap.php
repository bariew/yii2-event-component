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
     * @var EventManager EventManager memory storage for getEventManager method
     */
    protected static $_eventManager;
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        self::getEventManager($app);
    }
    /**
     * finds and creates app event manager from its settings
     * @param Application $app yii app
     * @return EventManager app event manager component
     * @throws Exception Define event manager
     */
    public static function getEventManager($app)
    {
        if (self::$_eventManager) {
            return self::$_eventManager;
        }
        foreach ($app->components as $name => $config) {
            $class = is_string($config) ? $config : @$config['class'];
            if($class == str_replace('Bootstrap', 'Manager', get_called_class())){
                return self::$_eventManager = $app->$name;
            }
        }
        $eventFile = \Yii::getAlias('@app/config/_events.php');
        $app->setComponents([
            'eventManager' => [
                'class'  => 'bariew\eventManager\EventManager',
                'events' => file_exists($eventFile) && is_file($eventFile)
                    ? include $eventFile 
                    : []
            ],
        ]);
        return self::$_eventManager = $app->eventManager;
    }
}