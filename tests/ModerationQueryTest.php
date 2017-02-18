<?php

namespace yii2mod\moderation\tests;

use yii2mod\moderation\ModerationBehavior;
use yii2mod\moderation\tests\data\Post;

/**
 * Class ModerationQueryTest
 *
 * @package yii2mod\moderation\tests
 */
class ModerationQueryTest extends TestCase
{
    public function testFetchPostsByStatus()
    {
        // test approved posts:

        /* @var $post1 Post|ModerationBehavior */
        $post1 = new Post(['title' => 'First Post']);
        $post1->save();
        $post1->markApproved();

        /* @var $post2 Post|ModerationBehavior */
        $post2 = new Post(['title' => 'Second Post']);
        $post2->save();
        $post2->markApproved();

        $this->assertEquals(2, Post::find()->approved()->count());
        $this->assertEquals(0, Post::find()->pending()->count());
        $this->assertEquals(0, Post::find()->rejected()->count());
        $this->assertEquals(0, Post::find()->postponed()->count());

        // test rejected posts:

        $post1->markRejected();
        $post2->markRejected();

        $this->assertEquals(2, Post::find()->rejected()->count());
        $this->assertEquals(0, Post::find()->pending()->count());
        $this->assertEquals(0, Post::find()->approved()->count());
        $this->assertEquals(0, Post::find()->postponed()->count());

        // test pending posts:

        $post1->markPending();
        $post2->markPending();

        $this->assertEquals(2, Post::find()->pending()->count());
        $this->assertEquals(0, Post::find()->rejected()->count());
        $this->assertEquals(0, Post::find()->approved()->count());
        $this->assertEquals(0, Post::find()->postponed()->count());

        // test postponed posts:

        $post1->markPostponed();
        $post2->markPostponed();

        $this->assertEquals(2, Post::find()->postponed()->count());
        $this->assertEquals(0, Post::find()->rejected()->count());
        $this->assertEquals(0, Post::find()->approved()->count());
        $this->assertEquals(0, Post::find()->pending()->count());

        // test approvedWithPending posts:

        $post1->markApproved();
        $post2->markPending();

        $this->assertEquals(2, Post::find()->approvedWithPending()->count());
    }
}
