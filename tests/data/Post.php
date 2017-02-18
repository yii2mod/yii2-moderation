<?php

namespace yii2mod\moderation\tests\data;

use yii\db\ActiveRecord;
use yii2mod\moderation\ModerationBehavior;
use yii2mod\moderation\ModerationQuery;

/**
 * Class Post
 *
 * @property string $title
 * @property int $status
 * @property int $moderated_by
 * @property int $moderated_at
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
            [['title'], 'required'],
            [['status', 'moderated_by', 'moderated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ModerationBehavior::class,
        ];
    }

    /**
     * @return ModerationQuery
     */
    public static function find()
    {
        return new ModerationQuery(get_called_class());
    }

    public function beforeModeration()
    {
        $this->moderated_at = time(); // log the moderation date

        return true;
    }
}
