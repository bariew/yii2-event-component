<?php
/**
 * EventManager class file.
 * @copyright (c) 2013, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\eventManager;
use yii\base\Component;
use yii\base\Event;

/**
 * Attaches events to all app models.
 * 
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class EventManager extends Component
{
    /**
     * System wide models events settings -
     * an array with structure: [
     *      $eventSenderClassName => [ 
     *          $eventName => [
     *              [$handlerClassName, $handlerMethodName]
     *          ]
     *      ]
     * ]
     *
     * @since 1.3.0 handler can also keep additional data and $append boolean as for Event::on() method eg:
     *  ... [$handlerClassName, $handlerMethodName, ['myData'], false]
     *
     * @var array events settings
     */
    public $events = [];
    /**
     * @inheritdoc
     */
    public function init() 
    {
        parent::init();
        $this->attachEvents($this->events);
    }
    /**
     * attaches all events to all classNames
     * @param array $eventConfig commonly $this->events config
     */
    public function attachEvents($eventConfig)
    {
        foreach ($eventConfig as $className => $events) {
            foreach ($events as $eventName => $handlers) {
                foreach ($handlers as $handler) {
                    $append = isset($handler[3]) ? array_pop($handler) : null;
                    $data = isset($handler[2]) ? array_pop($handler) : null;
                    Event::on($className, $eventName, $handler, $data, $append);
                }
            }
        }
    }
}