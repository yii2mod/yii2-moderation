<?php

namespace yii2mod\moderation;

use yii\db\ActiveQuery;
use yii2mod\moderation\enums\Status;

/**
 * ModerationQueryTrait adds the ability of getting only approved, rejected, postponed or pending models.
 *
 * This trait can be added to any descendant of [[\yii\db\ActiveRecord]].
 *
 * ModerationQueryTrait provides the following methods:
 *
 * ```php
 * Post::approved()->all() // It will return all Approved Posts
 *
 * Post::rejected()->all() // It will return all Rejected Posts
 *
 * Post::postponed()->all() // It will return all Postponed Posts
 *
 * Post::pending()->all() // It will return all Pending Posts
 * ```
 *
 * @author Igor Chepurnoy <igorzfort@gmail.com>
 *
 * @since 1.0
 */
trait ModerationQueryTrait
{
    /**
     * Get a new active query object that includes approved resources.
     *
     * @return ActiveQuery
     */
    public static function approved()
    {
        $model = new static();

        return static::find()->where([$model->statusAttribute => Status::APPROVED]);
    }

    /**
     * Get a new active query object that includes rejected resources.
     *
     * @return ActiveQuery
     */
    public static function rejected()
    {
        $model = new static();

        return static::find()->where([$model->statusAttribute => Status::REJECTED]);
    }

    /**
     * Get a new active query object that includes postponed resources.
     *
     * @return ActiveQuery
     */
    public static function postponed()
    {
        $model = new static();

        return static::find()->where([$model->statusAttribute => Status::POSTPONED]);
    }

    /**
     * Get a new active query object that includes pending resources.
     *
     * @return ActiveQuery
     */
    public static function pending()
    {
        $model = new static();

        return static::find()->where([$model->statusAttribute => Status::PENDING]);
    }
}
