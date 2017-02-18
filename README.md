Yii2 Moderation 
===============

A simple Content Moderation System for Yii2 that allows you to Approve or Reject resources like posts, comments, etc.


[![Latest Stable Version](https://poser.pugx.org/yii2mod/yii2-moderation/v/stable)](https://packagist.org/packages/yii2mod/yii2-moderation)
[![Total Downloads](https://poser.pugx.org/yii2mod/yii2-moderation/downloads)](https://packagist.org/packages/yii2mod/yii2-moderation)
[![License](https://poser.pugx.org/yii2mod/yii2-moderation/license)](https://packagist.org/packages/yii2mod/yii2-moderation)
[![Build Status](https://travis-ci.org/yii2mod/yii2-moderation.svg?branch=1.0)](https://travis-ci.org/yii2mod/yii2-moderation)
Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2mod/yii2-moderation "*"
```

or add

```json
"yii2mod/yii2-moderation": "*"
```

to the require section of your composer.json.


Configuration
-------------

To enable moderation for a model, use the `yii2mod\moderation\ModerationBehavior` behavior and add the `status` and `moderated_by` columns to your model's table.

Create a migration to add the new columns. Example Migration:

```php
<?php

use yii\db\Migration;

/**
 * Handles adding meration columns to table `post`.
 */
class m161117_092603_add_meration_columns_to_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('post', 'status', $this->smallInteger());
        $this->addColumn('post', 'moderated_by', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('post', 'status');
        $this->dropColumn('post', 'moderated_by');
    }
}

```

To use ModerationBehavior, insert the following code to your ActiveRecord class:

```php
use yii2mod\moderation\ModerationBehavior;

class Post extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ModerationBehavior::class,
        ];
    }
}
```

By default, ModerationBehavior will automatically set the `moderated_by` attribute.

If your attribute names are different, you may configure the [[statusAttribute]] and [[moderatedByAttribute]]
properties like the following:

```php
use yii2mod\moderation\ModerationBehavior;

class Post extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          [
              'class' => ModerationBehavior::class,
              'statusAttribute' => 'status_id',
              'moderatedByAttribute' => 'moderator_id',
          ],
      ];
    }
}
```

Usage
--------

> In next examples I will use Post model to demonstrate how the behavior and query class works. You can moderate any ActiveRecord Model.

#### Moderate Models

ModerationBehavior provides the following methods for model moderation:

```php
$post->markApproved(); // Change post status to Approved

$post->markRejected(); // Change post status to Rejected

$post->markPostponed(); // Change post status to Postponed

$post->markPending(); // Change post status to Pending
```

#### Model Status

ModerationBehavior also provides the following methods for checking the moderation status:

```php
$post->isPending(); // Check if a post is pending

$post->isApproved(); // Check if a post is approved

$post->isRejected(); // Check if a post is rejected

$post->isPostponed(); // Check if a post is postponed
```

#### Events

By default [[yii2mod\moderation\ModerationBehavior]] triggers [[yii2mod\moderation\ModerationBehavior::EVENT_BEFORE_MODERATION]]

You may attach the event handlers for this event to your ActiveRecord object:

```php
$post = Post::findOne($id);
$post->on(ModerationBehavior::EVENT_BEFORE_MODERATION, function ($event) {
    $event->isValid = false; // prevent moderation for the model
});
```

You may also handle these events inside your ActiveRecord class by declaring the corresponding method:

```php
use yii2mod\moderation\ModerationBehavior;

class Post extends ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ModerationBehavior::class,
        ];
    }
    
    public function beforeModeration()
    {
        $this->moderated_at = time(); // log the moderation date

        return true;
    }
}
```

#### Query Models

`ModerationQuery` adds the ability of getting only approved, rejected, postponed or pending models. Usage example:

```php
use yii2mod\moderation\ModerationQuery;

class Post extends ActiveRecord 
{
    public static function find()
    {
        return new ModerationQuery(get_called_class());
    }
}
```

Now you can use the following methods:

```php
Post::find()->approved()->all(); // It will return all Approved Posts

Post::find()->pending()->all(); // It will return all Pending Posts

Post::find()->rejected()->all(); // It will return all Rejected Posts

Post::find()->postponed()->all(); // It will return all Postponed Posts

Post::find()->approvedWithPending()->all() // It will return all Approved and Pending Posts
```
