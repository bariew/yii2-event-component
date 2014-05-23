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
 * Attaches events to all ActiveRecord and Controller instances
 * 
 * Usage: 
 * 1. define app component in main config components section: 
 * 'components' => [
 * ...
 *       'events'=> [
 *           'class'     => 'bariew\eventManager\EventManager',
 *           'events'    => [
 *               'app\models\User' => [
 *                   'afterInsert' => [
 *                       ['app\models\Email', 'userRegistration']
 *                   ],  
 *               ]
 *           ]
 *       ],
 * ].
 * 2. mention it in config bootstrap section:
 * 'bootstrap' => ['events', 'log']
 * 
 * You can also define $baseEvents variable to attach events not only for AR and Controllers
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
     * Base classes with init events that will attach events to their instances
     * an array with structure: [
     *      $basClassName   => $baseEventName
     * ]
     * @var array base events settings
     */
    public $baseEvents = [
        '\yii\db\ActiveRecord'  => 'EVENT_INIT',
        '\yii\base\Controller'  => 'EVENT_BEFORE_ACTION'
    ];
    /**
     * @inheritdoc
     */
    public function init() 
    {
        parent::init();
        $this->initBaseEvents();
    }
    /**
     * initiates base events 
     * eg for ActiveRecord::EVENT_INIT or Controller::EVENT_BEFORE_ACTION
     */
    private function initBaseEvents()
    {
        foreach($this->baseEvents as $className => $eventName){
            Event::on($className::className(), constant("{$className}::{$eventName}"), function ($event) {
                $this->attachModelEvents($event);
            });
        }
    }
    /**
     * attaches events to current model
     * @param object $model model
     * @param string $currentEvent current event name - 'init'
     */
    public function attachModelEvents($initEvent)
    {
        $model = $initEvent->sender;
        foreach ($this->events as $className => $events) {
            if (!is_a($model, $className)) {
                continue;
            }

            foreach ($events as $eventName => $triggers) {
                foreach ($triggers as $trigger) {
                    if ($eventName == $initEvent->name) {
                        call_user_func($trigger, $initEvent);
                    } else {
                        $model->on($eventName, $trigger);
                    }
                }
            }
        }
    }
}