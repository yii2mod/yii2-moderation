<?php

namespace yii2mod\moderation\enums;

use yii2mod\enum\helpers\BaseEnum;

/**
 * Class Status
 *
 * @package yii2mod\moderation\enums
 */
class Status extends BaseEnum
{
    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    const POSTPONED = 3;

    /**
     * @var array
     */
    public static $list = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::REJECTED => 'Rejected',
        self::POSTPONED => 'Postponed',
    ];
}
