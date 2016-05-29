<?php

namespace common\models\query;
use common\models\WhiteIpList;

/**
 * This is the ActiveQuery class for [[WhiteIpList]].
 *
 * @see WhiteIpList
 */
class WhiteIpListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return WhiteIpList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WhiteIpList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}