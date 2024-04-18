<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_bills_category_transactions".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $user_bills_id
 * @property int $amount
 * @property string $date_create
 * @property int $active
 *
 * @property User $user
 * @property UserBillsCategory $userBillsCategory
 */
class UserBillsCategoryTransactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_bills_category_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount'], 'required'],
            [['user_id', 'category_id', 'user_bills_id', 'amount', 'active'], 'integer'],
            [['date_create'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['user_bills_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserBills::class, 'targetAttribute' => ['user_bills_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'user_bills_id' => 'User bills  ID',
            'amount' => 'Сумма',
            'date_create' => 'Date Create',
            'active' => 'Active',
        ];
    }

//    public function beforeSave($insert) {
//        if ($this->isNewRecord) {
//            $this->user_id = Yii::$app->user->id;
//        }
//
//        return true;
//    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCategory(){
        if ($this->category_id == 0)
            return 'Разное';
        else
            return $this->categories->name;
    }

    public function getCategories()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getAmountStatus(){
//        $data['color'] = 'warning';
//        if ($this->amount < 0)
//            $data['color'] = 'info';
//        else
//            $data['color'] ='success';
        $data = [
                'color'=>'info',
            ];
        return $data;
    }

}
