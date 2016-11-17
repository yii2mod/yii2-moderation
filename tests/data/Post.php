<?php

namespace yii2mod\moderation\tests\data;

use yii\db\ActiveRecord;

/**
 * Class Post
 * @package yii2mod\moderation\tests\data
 */
class Post extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['status', 'moderated_by'], 'integer']
        ];
    }
}
