<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Tag extends ActiveRecord
{
    public $id;
    public $name;



    public function add($names, $entityId)
    {
        $tagsGQL = '';
        $relGQL = '';
        $tagsNodes = '';

        if(!empty($names)){


            $length = count($names);

            for($i = 0; $i < $length; $i++){

                $tagsGQL .= "MERGE (t$i:Tag{name:'".$names[$i]."'}) ";
                $relGQL .= "MERGE (n)-[:has_tag]->(t$i) ";
                $tagsNodes .="t$i";
                if ($i < $length - 1) {
                    $tagsNodes .= ', ';
                }
            }

        }




        return Tag::find()->match("(n) WHERE ID(n) = $entityId $tagsGQL$relGQL RETURN $tagsNodes")
            ->execute(true);

    }

    public function asArray()
    {
        $identity = $this;
        return ArrayHelper::toArray($identity, [
           'common\models\Tag' => [
               'id',
               'name'
           ]
       ]);
    }

}