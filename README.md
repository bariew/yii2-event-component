
Yii2 event manager component
===================
Attaches events to all application models in a very simple way.
You just list your event handlers in config/_events.php this way:
[
    'event\sender\ClassName' => [
        'eventName' => [
            'event\handler\ClassName'   => 'methodName'
        ]
    ]
];

See example below.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist bariew/yii2-event-component "*"
```

or add

```
"bariew/yii2-event-component": "*"
```

to the require section of your `composer.json` file.


Usage
-----

```
    Define app component in main config components section like in this example: 
    'components' => [
    ...
          'eventManager'=> [
              'class'     => 'bariew\eventManager\EventManager',
              'events'    => [
                  'app\models\User' => [
                      'afterInsert' => [
                          ['app\models\Email', 'userRegistration']
                      ],  
                  ]
              ]
          ],
    ]

    Explanation: in the example we defined that after creating new User model ('afterInsert')
    Email::userRegistration($event) method will be called.
```

```
    Since 1.1.0 you may also not define event manager, but just put _events.php
    into your config folder returning the same 'events' array as in example:

    <?php
    return [
        'app\models\User' => [
            'afterInsert' => [
                ['app\models\Email', 'userRegistration']
            ],
        ]
    ];
```

```
    Since 1.2.0 you may also set nested events:

    <?php
    return [
        'app\models\User' => [
            'afterInsert' => [
                ['app\models\Email', 'userRegistration', ['events' => [
                    'emailError' => ['app\models\Admin', 'errorNotification']
                ]]
            ],
        ]
    ];

    In the example above we believe that Email::userRegistration triggers 'emailError' event,
    which will trigger app\models\Admin::errorNotification.
    It is not workflow - all emailError events will trigger this method. It's only for clarity.

```