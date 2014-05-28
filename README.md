
Node tree Yii2 extension
===================
Attaches events to all application models.

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