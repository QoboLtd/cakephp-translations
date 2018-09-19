# Translations plugin for CakePHP

[![Build Status](https://travis-ci.org/QoboLtd/cakephp-translations.svg?branch=master)](https://travis-ci.org/QoboLtd/cakephp-translations)
[![Latest Stable Version](https://poser.pugx.org/qobo/cakephp-translations/v/stable)](https://packagist.org/packages/qobo/cakephp-translations)
[![Total Downloads](https://poser.pugx.org/qobo/cakephp-translations/downloads)](https://packagist.org/packages/qobo/cakephp-translations)
[![Latest Unstable Version](https://poser.pugx.org/qobo/cakephp-translations/v/unstable)](https://packagist.org/packages/qobo/cakephp-translations)
[![License](https://poser.pugx.org/qobo/cakephp-translations/license)](https://packagist.org/packages/qobo/cakephp-translations)
[![codecov](https://codecov.io/gh/QoboLtd/cakephp-translations/branch/master/graph/badge.svg)](https://codecov.io/gh/QoboLtd/cakephp-translations)
[![BCH compliance](https://bettercodehub.com/edge/badge/QoboLtd/cakephp-translations?branch=master)](https://bettercodehub.com/)

## About

CakePHP 3+ plugin for managing content translations.

This plugin is developed by [Qobo](https://www.qobo.biz) for [Qobrix](https://qobrix.com).  It can be used as standalone CakePHP plugin, or as part of the [project-template-cakephp](https://github.com/QoboLtd/project-template-cakephp) installation.

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
