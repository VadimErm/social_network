<?php


namespace api\modules\v1\models;

use common\helpers\Base64ToImageHelper;
use common\helpers\TimeZoneHelper;
use common\models\JournalEntry;


use Yii;

class JournalEntryRest extends JournalEntry
{
    public $images_base64 = [];

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['images_base64', 'safe'];
        return $rules;


    }

    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }


        $this->created_at = time();
        $image = new UploadImageRest($this->images_base64);
        $savedFiles = $image->uploadMultiple();
        $imagesGQL = '';
        $imageNodes = '';

        if(is_array($savedFiles) && !empty($savedFiles)){

            $imagesGQL = ', ';


            $length = count($savedFiles);

            for ($i = 0; $i < $length; $i++) {
                $imagesGQL .= "(n)-[:has_image]->(i$i:Image{src: '{$savedFiles[$i]}'})";
                $imageNodes .= "i$i";
                if ($i < $length - 1) {
                    $imagesGQL .= ', ';
                    $imageNodes .= ', ';
                }
            }
        }

        $images = empty($imageNodes) ? '': ", [$imageNodes] as images";



        if ($attributes == null) {
            $attributes = $this->attributes();
        }
        unset($attributes['images_base64']);



        $attributesStr = $this->getAttributesStr($attributes);
        $labelName = static::labelName();
        $attributesStr = $attributesStr.", views: 0";


        return JournalEntry::find()->match("(j:Journal) WHERE ID(j) = $this->journal_id")
            ->create("(n: {$labelName} " . "{" .$attributesStr. "}), (j)-[:has_journal_entry]->(n)$imagesGQL")
            ->get("n, ID(n) as id$images")
            ->one();

    }

    public function update($runValidation  = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }

        if ($attributeNames == null) {
            $attributeNames = $this->attributes();
        }


        $imagesGQL = '';
        $imageNodes = '';

        if(!empty($this->images_base64)){

            $length = count($this->images_base64);

            for($i=0; $i < $length; $i++){
                if(base64_decode($this->images_base64[$i], true) !== false){
                    $uploadImageRest = new UploadImageRest($this->images_base64[$i]);
                    if($src = $uploadImageRest->upload()){
                        $imagesGQL .= " MERGE (i$i:Image{src:'$src'})<-[:has_image]-(n)";

                    }
                } else {
                    $imagesGQL .= " MERGE (i$i:Image{src:'".$this->images_base64[$i]."'})<-[:has_image]-(n)";

                }
                $imageNodes .="i$i";
                if ($i < $length - 1) {
                    $imageNodes .= ', ';
                }

            }
        }

        $images = (empty($imageNodes)) ? '' : ", [$imageNodes] as images";

        $attributesStr = $this->getAttributesForUpdate($attributeNames);

       return  JournalEntry::find()->match("(n:JournalEntry) WHERE ID(n) = $this->id OPTIONAL MATCH (n)-[r:has_image | :has_tag]->(i) DELETE r $imagesGQL")
            ->set($attributesStr)
            ->get("n, ID(n) as id$images")
            ->one();


    }

    public function save($runValidation = true, $attributeNames = null)
    {
        return parent::save($runValidation, $attributeNames);
    }

    public static function labelName()
    {
        return 'JournalEntry';
    }

}