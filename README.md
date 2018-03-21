[![SensioLabsInsight](https://insight.sensiolabs.com/projects/310e0794-a30c-4ab1-8721-fb9b39443fb1/mini.png)](https://insight.sensiolabs.com/projects/310e0794-a30c-4ab1-8721-fb9b39443fb1)
[![Build Status](https://travis-ci.org/matthieuleorat/documentManager.svg?branch=master)](https://travis-ci.org/matthieuleorat/documentManager)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matthieuleorat/documentManager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matthieuleorat/documentManager/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/matthieuleorat/documentManager/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matthieuleorat/documentManager/?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Maintainability](https://api.codeclimate.com/v1/badges/7afc33ea65c38c72f1d7/maintainability)](https://codeclimate.com/github/matthieuleorat/documentManager/maintainability)

# Document Manager
This project intend to be a personnal document manager. 

It use Symmfony 4 and EasyAdmin bundle.

- It use imagick to generate Pdf Thumbnail

## UserableInterface

Automatically link an entity to the current user.

This is an interface for entities.
Entities implementing the `UserableInterface` have to use the `Userable` Trait to set up tue user's attributes.

`src/Listener/EasyAdminSubscriber.php` listen on the prePersist doctrine event, and set the current user as the owner of the edited entity, if this entity implement the UserableInterface.

## Filter user related data in a form
Ex: On Document edition, display only the tags belonging to the current user.  
This restriction is done in the Entity Controller, `create<Entity>EntityFormBuilder` method