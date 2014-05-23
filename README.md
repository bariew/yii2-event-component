
Node tree Yii2 extension
===================
Attaches events to all app models

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
        'events'=> [
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
```