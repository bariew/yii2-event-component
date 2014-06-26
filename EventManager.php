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
     * System widde models events settings - 
     * an array with structure: [
     *      $eventSenderClassName => [ 
     *          $eventName => [
     *              [$triggeredClassName, $triggeredMethodName]
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
            foreach ($events as $eventName => $triggers) {
                foreach ($triggers as $trigger) {
                    $this->attachNestedEvents($trigger);
                    Event::on($className, $eventName, $trigger);
                }
            }
        }
    }

    /**
     * Attaches nested events from common event settings trigger.
     * Trigger should have structure ['className', 'methodName', 'events' => [...]
     * $eventName => [
          [$triggeredClassName, $triggeredMethodName]
      ], ...
     * @param array $trigger event settings
     */
    protected function attachNestedEvents(&$trigger)
    {
        if (!is_array($trigger) || !isset($trigger['events'])) {
            return;
        }
        $this->attachEvents([
            $trigger[0] => $trigger['events']
        ]);
        unset($trigger['events']);
    }
}