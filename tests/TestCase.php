<?php

namespace yii2mod\moderation\tests;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->mockApplication();

        $this->setupTestDbData();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'request' => [
                    'hostInfo' => 'http://domain.com',
                    'scriptUrl' => 'index.php'
                ],
                'user' => [
                    'identityClass' => 'yii2mod\moderation\tests\data\User',
                ],
            ]
        ], $config));
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }

    /**
     * Setup tables for test ActiveRecord
     */
    protected function setupTestDbData()
    {
        $db = Yii::$app->getDb();

        // Structure :

        $db->createCommand()->createTable('post', [
            'id' => 'pk',
            'title' => 'string',
            'description' => 'string',
            'status' => 'integer',
            'moderated_by' => 'integer',
            'moderated_at' => 'integer'
        ])->execute();

        $db->createCommand()->createTable('user', [
            'id' => 'pk',
            'username' => 'string',
            'email' => 'string'
        ])->execute();

        // Data :

        $db->createCommand()->insert('post', [
            'title' => 'Post Title'
        ])->execute();

        $db->createCommand()->insert('user', [
            'username' => 'John Doe',
            'email' => 'johndoe@domain.com'
        ])->execute();
    }
}
