<?php

namespace yii2mod\moderation\tests;

use Yii;
use yii2mod\moderation\ModerationBehavior;
use yii2mod\moderation\tests\data\Post;
use yii2mod\moderation\tests\data\User;

/**
 * Class ModerationBehaviorTest
 *
 * @package yii2mod\moderation\tests
 */
class ModerationBehaviorTest extends TestCase
{
    public function testMarkApproved()
    {
        /* @var $post Post|ModerationBehavior */
        Yii::$app->user->login(User::find()->one());
        $post = Post::findOne(1);

        $this->assertTrue($post->markApproved());
        $this->assertEquals($post->moderated_by, Yii::$app->user->getId());
        $this->assertTrue($post->isApproved());
        $this->assertFalse($post->isRejected());
        $this->assertFalse($post->isPostponed());
        $this->assertFalse($post->isPending());
    }

    public function testMarkRejected()
    {
        /* @var $post Post|ModerationBehavior */
        Yii::$app->user->login(User::find()->one());
        $post = Post::findOne(1);

        $this->assertTrue($post->markRejected());
        $this->assertEquals($post->moderated_by, Yii::$app->user->getId());
        $this->assertTrue($post->isRejected());
        $this->assertFalse($post->isApproved());
        $this->assertFalse($post->isPostponed());
        $this->assertFalse($post->isPending());
    }

    public function testMarkPostponed()
    {
        /* @var $post Post|ModerationBehavior */
        Yii::$app->user->login(User::find()->one());
        $post = Post::findOne(1);

        $this->assertTrue($post->markPostponed());
        $this->assertEquals($post->moderated_by, Yii::$app->user->getId());
        $this->assertTrue($post->isPostponed());
        $this->assertFalse($post->isApproved());
        $this->assertFalse($post->isRejected());
        $this->assertFalse($post->isPending());
    }

    public function testMarkPending()
    {
        /* @var $post Post|ModerationBehavior */
        Yii::$app->user->login(User::find()->one());
        $post = Post::findOne(1);

        $this->assertTrue($post->markPending());
        $this->assertEquals($post->moderated_by, Yii::$app->user->getId());
        $this->assertTrue($post->isPending());
        $this->assertFalse($post->isApproved());
        $this->assertFalse($post->isRejected());
        $this->assertFalse($post->isPostponed());
    }

    public function testPreventBeforeModerationEvent()
    {
        /* @var $post Post|ModerationBehavior */
        Yii::$app->user->login(User::find()->one());
        $post = Post::findOne(1);
        $post->on(ModerationBehavior::EVENT_BEFORE_MODERATION, function ($event) {
            $event->isValid = false; // prevent moderation for the model
        });
        $this->assertFalse($post->markApproved());
        $this->assertFalse($post->markPending());
        $this->assertFalse($post->markPostponed());
        $this->assertFalse($post->markRejected());
    }

    public function testFillModeratedAtDateAttributeInBeforeModerationEvent()
    {
        /* @var $post Post|ModerationBehavior */
        Yii::$app->user->login(User::find()->one());
        $post = Post::findOne(1);
        $this->assertTrue($post->markApproved());
        $this->assertNotNull($post->moderated_at);
    }
}
