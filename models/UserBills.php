<?php

namespace app\models;

use Yii;
use yii\web\JsExpression;
use miloschuman\highcharts\Highcharts;

/**
 * This is the model class for table "user_bills".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string $date_create
 * @property int $active
 *
 * @property User $user
 * @property UserBillsCategory[] $userBillsCategories
 */
class UserBills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_bills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['user_id'], 'required'],
            [['user_id', 'active'], 'integer'],
            [['date_create'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->user_id = Yii::$app->user->id;
        // ...custom code here...
        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'date_create' => 'Date Create',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[UserBillsCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBillsCategories()
    {
        return $this->hasMany(UserBillsCategory::class, ['user_bills_id' => 'id']);
    }

    public function getListAccountTransactions(){
        return UserBillsCategoryTransactions::find()->where(['user_id'=>$this->user_id, 'user_bills_id'=>$this->id])->orderBy('date_create DESC')->all();
    }

    public function getDataChart(){
        $categories = UserBillsCategoryTransactions::find()->select('category_id')->where(['user_id'=>$this->user_id, 'user_bills_id'=>$this->id])->groupBy('category_id')->all();

        $data2 = [];

        foreach ($categories as $category){
            $categoryAmount = $this->amountByCategory($category->category_id);
            if ($categoryAmount<0) $categoryAmount = ($categoryAmount*-1);

            $data2[]= [
                'name' => $category->categories->name,
                'y' =>$categoryAmount ,
            ];
        }

        return $data2;
    }

    function amountByCategory($category_id){
        return UserBillsCategoryTransactions::find()
            ->select('amount')
            ->where(['user_id'=>$this->user_id,'category_id' => $category_id, 'user_bills_id'=>$this->id])
            ->asArray()
            ->sum('amount');
    }

}
