<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $img
 * @property int $active
 *
 * @property UserBillsCategory[] $userBillsCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name', 'img'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'img' => 'Img',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[UserBillsCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBillsCategories()
    {
        return $this->hasMany(UserBillsCategory::class, ['category_id' => 'id']);
    }
}
