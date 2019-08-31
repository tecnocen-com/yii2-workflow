Yii2 Workflow
==============
Library to dynamically handle workflows in a database with ROA support.

[![Latest Stable Version](https://poser.pugx.org/tecnocen/yii2-workflow/v/stable)](https://packagist.org/packages/tecnocen/yii2-workflow)
[![Total Downloads](https://poser.pugx.org/tecnocen/yii2-workflow/downloads)](https://packagist.org/packages/tecnocen/yii2-workflow)


Travis [![Build Status Travis](https://travis-ci.org/tecnocen-com/yii2-workflow.svg?branch=master&style=flat?style=for-the-badge)](https://travis-ci.org/tecnocen-com/yii2-workflow)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

- Install PHP 7.1 or higher
- [Composer Installed](https://getcomposer.org/doc/00-intro.md)

The rest of the requirements are checked by composer when installing the
repository on the next step.

### Installation
----------------

You can use composer to install the library `tecnocen/yii2-workflow` by running
the command;

`composer require tecnocen/yii2-workflow`

or edit the `composer.json` file

```json
require: {
    "tecnocen/yii2-workflow": "*",
}
```

### Deployment

Then run the required migrations

`php yii migrate/up -p=@tecnocen/workflow/migrations`

Which will install the following table structure

![Database Diagram](diagram.png)


#### ROA Backend Usage
-----------------

The ROA support is very simple and can be done by just adding a module version
to the api container which will be used to hold the resources.

```php
class Api extends \tecnocen\roa\modules\ApiContainer
{
    public $versions = [
       // other versions
       'w1' => ['class' => 'tecnocen\workflow\roa\modules\Version'],
   ];
}
```

You can then access the module to check the available resources.

- workflow
- workflow/<workflow_id:\d+>/stage
- workflow/<workflow_id:\d+>/stage/<stage_id:\d+>/transition
- workflow/<workflow_id:\d+>/stage/<stage_id:\d+>/transition/<target_id:\d+>/permission

Which will implement CRUD functionalities for a workflow.

#### Process and Worklog
------------------------

A `process` is an entity which changes from stage depending on a workflow. Each
stage change is registered on a `worklog` for each `process` record.

To create a `process` its required to create a migrations for the process and
the worklog then the models to handle them, its adviced to use the provided
migration templates.

```php
class m170101_010101_credit extends EntityTable
{
    public function getTableName()
    {
        return 'credit';
    }

    public function columns()
    {
         return [
             'id' => $this->primaryKey(),
             'workflow_id' => $this->normalKey(),
             // other columns
         ];
    }

    public function foreignKeys()
    {
        return [
            'workflow_id' => ['table' => 'tecnocen_workflow'];
        ];
    }
}
```

```php
class m170101_010102_credit_worklog extends \tecnocen\workflow\migrations\WorkLog
{
    public function getProcessTableName()
    {
        return 'credit';
    }
}
```

After running the migrations its necessary to create Active Record models.

```php
class Credit extends \tecnocen\workflow\models\Process
{
    protected function workflowClass()
    {
        return CreditWorklog::class;
    }

    public function getWorkflowId()
    {
        return $this->workflow_id;
    }

    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            // other rules here
        ]);
    }
}
```

```php
class CreditWorkLog extends \tecnocen\workflow\models\WorkLog
{
    public static function processClass()
    {
        return Credit::class;
    }
}
```

#### Worklog Resource
----------------

Each process gets a worklog about the flow of stages it goes through.

On ROA you can declare each worklog as a child resource for the process resource

```php
public $resources = [
   'credit',
   'credit/<credit_id:\d+>/worklog' => [
       'class' => WorklogResource::class,
       'modelClass' => CreditWorklog::class,
   ]
];
```

## Running the tests

This library contains tools to set up a testing environment using composer scripts, for more information see [Testing Environment](https://github.com/tecnocen-com/yii2-workflow/blob/master/CONTRIBUTING.md) section.

### Break down into end to end tests

Once testing environment is setup, run the following commands.

```
composer deploy-tests
```

Run tests.

```
composer run-tests
```

Run tests with coverage.

```
composer run-coverage
```

## Live Demo

You can run a live demo on a freshly installed project to help you run testing
or understand the responses returned by the server. The live demo is initialized
with the command.

```
php -S localhost:8000 -t tests/_app
```

Where `:8000` is the port number which can be changed. This allows you call ROA
services on a browser or REST client.

## Use Cases

TO DO

## Built With

* Yii 2: The Fast, Secure and Professional PHP Framework [http://www.yiiframework.com](http://www.yiiframework.com)

## Code of Conduct

Please read [CODE_OF_CONDUCT.md](https://github.com/tecnocen-com/yii2-workflow/blob/master/CODE_OF_CONDUCT.md) for details on our code of conduct.

## Contributing

Please read [CONTRIBUTING.md](https://github.com/tecnocen-com/yii2-workflow/blob/master/CONTRIBUTING.md) for details on the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/tecnocen-com/yii2-workflow/tags).

_Considering [SemVer](http://semver.org/) for versioning rules 9, 10 and 11 talk about pre-releases, they will not be used within the Tecnocen-com._

## Authors

* [**Angel Guevara**](https://github.com/Faryshta) - *Initial work* - [Tecnocen.com](https://github.com/Tecnocen-com)
* [**Carlos Llamosas**](https://github.com/neverabe) - *Initial work* - [Tecnocen.com](https://github.com/Tecnocen-com)

See also the list of [contributors](https://github.com/tecnocen-com/yii2-workflow/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* TO DO - Hat tip to anyone who's code was used
* TO DO - Inspiration
* TO DO - etc

[![yii2-workflow](https://img.shields.io/badge/Powered__by-Tecnocen.com-orange.svg?style=for-the-badge)](https://www.tecnocen.com/)
