<?php

namespace frontend\controllers;
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 23.02.16
 * Time: 15:06
 */
use common\models\ErrorCounter;
use Yii;
use yii\web\ErrorAction;

class CountErrorAction extends ErrorAction
{
    public function run()
    {
        $ip = Yii::$app->request->getUserIP();
        /**
         * @var ErrorCounter $bucket
         */
        $bucket = ErrorCounter::findOne($ip);
        if( $bucket !== NULL){
            if($bucket->allow()) {
                $bucket->outFlow();
                $bucket->save();
            }
        } else {
            $bucket = new ErrorCounter();
            $bucket->ip = $ip;
            $bucket->outflow();
            $bucket->save();
        }
        return parent::run();
    }
}
