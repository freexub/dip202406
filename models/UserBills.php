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
    public $amount;
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
            'title' => 'Название счёта',
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

    public function getDataChart($fdate,$ldate){
//        $categories = UserBillsCategoryTransactions::find()->select('category_id')->where(['user_id'=>$this->user_id, 'user_bills_id'=>$this->id])->groupBy('category_id')->all();
        $categories = Category::find()->where(['active'=>0])->all();

        $data2 = [];

        foreach ($categories as $category){
            $categoryAmount = $this->amountByCategory($category->id, $fdate, $ldate);

            $data2[]= [
                'name' => $category->name,
                'y' =>(int)$categoryAmount ,
            ];
        }

        return $data2;
    }

    function amountByCategory($category_id, $fdate, $ldate){
        return UserBillsCategoryTransactions::find()
            ->select('amount')
            ->where(['user_id'=>$this->user_id,'category_id' => $category_id, 'user_bills_id'=>$this->id])
            ->andWhere(['<','active',100])
            ->andWhere([
                'between',
                'date_create',
                Yii::$app->formatter->asDate($fdate,'yyyy-MM-dd'),
                Yii::$app->formatter->asDate($ldate,'yyyy-MM-dd')
            ])
            ->asArray()
            ->sum('amount');
    }

    public function getBalans(){
        $category = Category::find()->where(['active'=>1])->one();
        $sum = UserBillsCategoryTransactions::find()
            ->select('amount')
            ->andWhere(['<','active',100])
            ->where(['user_id'=>$this->user_id,'category_id' => $category->id, 'user_bills_id'=>$this->id])
            ->asArray()
            ->sum('amount');
        if (!$sum)
            $sum = 0;

        $expense = UserBillsCategoryTransactions::find()
            ->select('amount')
            ->where(['user_id'=>$this->user_id, 'user_bills_id'=>$this->id])
            ->andWhere(['!=','category_id', $category->id])
            ->asArray()
            ->sum('amount');

        return $sum-$expense;
    }

}
