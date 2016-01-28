<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Article;
use creocoder\taggable\TaggableQueryBehavior;
use yii\db\ActiveQuery;
use Yii;

class ArticleQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);
        $this->andWhere(['or',
            ['private' => Article::PRIVATE_ON, 'author_id' => Yii::$app->user->id],
            ['private' => Article::PRIVATE_OFF]]);
        return $this;
    }

    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}
