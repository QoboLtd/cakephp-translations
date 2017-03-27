# Translations plugin for CakePHP


## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require qobo/cakephp-translations
```

Run plugin's migration task:

```
bin/cake migrations migrate -p Translations
```

## Setup
Load plugin
```
bin/cake plugin load --routes --bootstrap Translations
```


To load the Translations component in your application just add behavior Translate into your table initialization method:

```
public function initialize(array $config)
{
    $this->addBehavior('Translate');
}    

```
