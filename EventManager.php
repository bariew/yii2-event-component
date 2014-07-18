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
                    Event::on($className, $eventName, $handler);
                }
            }
        }
    }
}