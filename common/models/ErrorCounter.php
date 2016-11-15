<?php

namespace common\models;

/**
 * Created by PhpStorm.
 * User: kate
 * Date: 23.02.16
 * Time: 17:05
 */
use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property string $ip
 * @property integer $allowance
 * @property integer $lastErrorTime
 */
class ErrorCounter extends \yii\redis\ActiveRecord
{
    const DEFAULT_ALLOWANCE = 10;
    const DEFAULT_TIME_STEP = 60;

    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        return ['ip', 'allowance', 'lastErrorTime'];
    }

    public static function primaryKey()
    {
        return ['ip'];
    }

    /**
     * @return void
     */
    public function outflow()
    {
        $time = time();
        $allowance = Yii::$app->keyStorage->get('common.allowance') ? : self::DEFAULT_ALLOWANCE;
        $interval = Yii::$app->keyStorage->get('common.interval') ? : self::DEFAULT_TIME_STEP;
        $this->allowance += (int) (( $time - $this->lastErrorTime)*$allowance/$interval);
        if ($this->allowance > $allowance) {
            $this->allowance = $allowance;
        } elseif ($this->allowance > 0) {
            $this->allowance -= 1;
        } else {
            $this->allowance = 0;
        }
        $this->lastErrorTime = $time;
    }

    public function allow()
    {
        $timeout = Yii::$app->keyStorage->get('common.blocking-timeout') ? : self::DEFAULT_TIME_STEP;
        $checkTime = (time() - $this->lastErrorTime) > $timeout;
        $checkAllowence = $this->allowance > 0;
        return $checkAllowence || $checkTime;
    }
}
