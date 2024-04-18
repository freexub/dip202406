<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_bills_category".
 *
 * @property int $id
 * @property int $user_bills_id
 * @property int $category_id
 * @property string $date_create
 * @property int $active
 *
 * @property Category $category
 * @property UserBills $userBills
 */
class UserBillsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_bills_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_bills_id', 'category_id'], 'required'],
            [['user_bills_id', 'category_id', 'active'], 'integer'],
            [['date_create'], 'safe'],
            [['user_bills_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserBills::class, 'targetAttribute' => ['user_bills_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_bills_id' => 'User Bills ID',
            'category_id' => 'Category ID',
            'date_create' => 'Date Create',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[UserBills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBills()
    {
        return $this->hasOne(UserBills::class, ['id' => 'user_bills_id']);
    }
}
