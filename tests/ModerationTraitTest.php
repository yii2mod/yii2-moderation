<?php

namespace yii2mod\moderation\tests;

use yii2mod\moderation\ModerationBehavior;
use yii2mod\moderation\tests\data\Post;

/**
 * Class ModerationTraitTest
 * @package yii2mod\moderation\tests
 */
class ModerationTraitTest extends TestCase
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

        $this->assertEquals(2, Post::approved()->count());
        $this->assertEquals(0, Post::pending()->count());
        $this->assertEquals(0, Post::rejected()->count());
        $this->assertEquals(0, Post::postponed()->count());

        // test rejected posts:

        $post1->markRejected();
        $post2->markRejected();

        $this->assertEquals(2, Post::rejected()->count());
        $this->assertEquals(0, Post::pending()->count());
        $this->assertEquals(0, Post::approved()->count());
        $this->assertEquals(0, Post::postponed()->count());

        // test pending posts:

        $post1->markPending();
        $post2->markPending();

        $this->assertEquals(2, Post::pending()->count());
        $this->assertEquals(0, Post::rejected()->count());
        $this->assertEquals(0, Post::approved()->count());
        $this->assertEquals(0, Post::postponed()->count());

        // test postponed posts:

        $post1->markPostponed();
        $post2->markPostponed();

        $this->assertEquals(2, Post::postponed()->count());
        $this->assertEquals(0, Post::rejected()->count());
        $this->assertEquals(0, Post::approved()->count());
        $this->assertEquals(0, Post::pending()->count());
    }
}
