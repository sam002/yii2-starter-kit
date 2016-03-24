<?php

namespace common\models;

/**
 * Created by PhpStorm.
 * User: kate
 * Date: 23.02.16
 * Time: 17:05
 */
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article_category".
 *
 * @property string $ip
 * @property integer $allowance
 * @property integer $lastErrorTime
 */
class ErrorCounter extends \yii\redis\ActiveRecord
{
    //public $ip;
    //public $allowance;
    //public $lastErrorTime;

    const ALLOWANCE = 10;
    const TIME_STEP = 60;

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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => 'lastErrorTime',
            ]
        ];
    }

    /**
     * @return void
     */
    public function outflow()
    {
        $time = time();
        $this->allowance += (int) (( $time - $this->lastErrorTime)*self::ALLOWANCE/self::TIME_STEP);
        if ($this->allowance > self::ALLOWANCE) {
            $this->allowance = self::ALLOWANCE;
        } elseif ($this->allowance > 0) {
            $this->allowance -= 1;
        } else {
            $this->allowance = 0;
        }
        if (empty($this->lastErrorTime)) {
            $this->lastErrorTime = $time;
        }
    }

    public function allow()
    {
        $checkTime = (time() - $this->lastErrorTime) > self::TIME_STEP;
        $checkAllowence = $this->allowance > 0;
        return $checkAllowence || $checkTime;
    }
}