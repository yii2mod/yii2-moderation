<?php

namespace yii2mod\moderation\tests\data;

use yii\db\ActiveRecord;
use yii2mod\moderation\ModerationBehavior;
use yii2mod\moderation\ModerationQueryTrait;

/**
 * Class Post
 *
 * @property string $title
 * @property integer $status
 * @property integer $moderated_by
 * @property integer $moderated_at
 */
class Post extends ActiveRecord
{
    use ModerationQueryTrait;

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
            [['title'], 'required'],
            [['status', 'moderated_by', 'moderated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ModerationBehavior::class
        ];
    }

    public function beforeModeration()
    {
        $this->moderated_at = time(); // log the moderation date

        return true;
    }
}
