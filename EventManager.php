<?php
/**
 * EventManager class file.
 * @copyright (c) 2013, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
namespace bariew\eventManager;
//namespace app\modules\main\components;
use yii\base\Component;
use yii\base\Event;
/**
 * Attaches events to all app models
 * 
 * Usage: 
 * define app component in main config components section: 
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
 * ]
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
        foreach ($this->events as $className => $events) {
            foreach ($events as $eventName => $triggers) {
                foreach ($triggers as $trigger) {
                    Event::on($className, $eventName, $trigger);
                }
            }
        }
    }
}