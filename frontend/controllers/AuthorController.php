<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 17.11.16
 * Time: 16:32
 */

namespace frontend\controllers;

use common\models\Article;
use common\models\User;
use dosamigos\qrcode\formats\iCal;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class AuthorController extends Controller
{
    
    public function actionShow($username)
    {
        $modelUser = User::findByUsername($username);

        if (!$modelUser) {
            throw new NotFoundHttpException;
        }
        
        $modelUserProfile = $modelUser->userProfile;

        $articles = Article::find()->published()->andWhere(['created_by' => $modelUser->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $articles,
        ]);

        if ($articles->count() < 1) {
            throw new NotFoundHttpException;
        }

        if ($modelUser->oauth) {
            $oauth = [
                'provider' => $modelUser->oauth[0]['attributes']['provider'],
                'url' => json_decode($modelUser->oauth[0]['attributes']['properties'],true)['html_url']
            ];
        } else {
            $oauth = null;
        }

        return $this->render('index', [
            'author' => [
                'username' => $modelUser->username,
                'avatar_url' => $modelUserProfile->getAvatar(),
                'full_name' => $modelUserProfile->getFullName(),
                'about' => $modelUserProfile->about,
                'oauth' => $oauth
                ],
            'articles' => $dataProvider
        ]);
    }

}