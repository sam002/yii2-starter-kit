<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 16.11.16
 * Time: 16:24
 */

namespace frontend\controllers;

use common\models\Article;
use Yii;
use yii\data\ActiveDataProvider,
    yii\base\Controller;
use yii\helpers\StringHelper;
use yii\helpers\Url;


class FeedController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->with(),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        echo \Zelenin\yii\extensions\Rss\RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => function ($widget, \Zelenin\Feed $feed) {
                    $feed->addChannelTitle(Yii::$app->name);
                },
                'link' => Url::toRoute('/', true),
                'description' => Yii::t('frontend', 'Articles'),
                'language' => function ($widget, \Zelenin\Feed $feed) {
                    return Yii::$app->language;
                },
                'image'=> function ($widget, \Zelenin\Feed $feed) {
                    $feed->addChannelImage(
                        Url::to(['/favicon.ico'], true),
                        Yii::getAlias('frontendUrl'), 144, 144, 'Icon'
                    );
                },
            ],
            'items' => [
                'title' => function (Article $model, $widget, \Zelenin\Feed $feed) {
                    return $model->title;
                },
                'description' => function (Article $model, $widget, \Zelenin\Feed $feed) {
                    return StringHelper::truncateWords($model->body, 50);
                },
                'link' => function (Article $model, $widget, \Zelenin\Feed $feed) {
                    return Url::to(['article/view', 'slug'=>$model->slug], true);
                },
                'author' => function (Article $model, $widget, \Zelenin\Feed $feed) {
                    return $model->author->email . ' (' . $model->author->username . ')';
                },
                'guid' => function (Article $model, $widget, \Zelenin\Feed $feed) {
                    return Url::to(['article/view', 'slug'=>$model->slug], true) . '_' . $model->updated_at;
                },
                'pubDate' => function (Article $model, $widget, \Zelenin\Feed $feed) {
                    $date =  new \DateTime('@'.$model->updated_at);
                    return $date->format(DATE_RSS);
                }
            ]
        ]);
    }
}