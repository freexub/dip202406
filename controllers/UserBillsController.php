<?php

namespace app\controllers;

use app\models\Category;
use app\models\UserBills;
use app\models\UserBillsCategory;
use app\models\UserBillsCategoryTransactions;
use app\models\UserBillsCategoryTransactionsSearch;
use app\models\UserBillsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * UserBillsController implements the CRUD actions for UserBills model.
 */
class UserBillsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
//                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all UserBills models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userBillsModel = new UserBills();
        $searchModel = new UserBillsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['active'=>0]);

        return $this->render('index', [
            'userBillsModel' => $userBillsModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserBills model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $fdate='', $ldate='')
    {
        $searchModel = new UserBillsCategoryTransactionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['user_bills_id'=>$id,'active'=>0]);
        if (empty($fdate) || empty($ldate)){
            $date = date('m-Y');
            $fdate = '01-'.$date;
            $ldate = date('t',time()).'-'.$date;

//            var_dump(Yii::$app->formatter->asDate($fdate,'yyyy-MM-dd'));
//            var_dump($fdate);
//            die();
        }
//        var_dump(Yii::$app->formatter->asDate($fdate,'yyyy-MM-dd'));
//        die();
        $dataProvider->query->andWhere([
            'between',
            'date_create',
            Yii::$app->formatter->asDate($fdate,'yyyy-MM-dd'),
            Yii::$app->formatter->asDate($ldate,'yyyy-MM-dd')
        ]);

        $model = $this->findModel($id);
        $modelTransaction = new UserBillsCategoryTransactions();
        $categories = Category::find()->all();

        if ($this->request->isPost) {
            if ($modelTransaction->load($this->request->post()) && $modelTransaction->save()) {
                return $this->redirect(['view', 'id' => $id]);
            }else{
                var_dump($this->request->post());
                var_dump($modelTransaction->errors);
                die();
            }
        }

        return $this->render('view', [
            'model' => $model,
            'categories' => $categories,
            'modelTransaction' => $modelTransaction,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fdate' => $fdate,
            'ldate' => $ldate,
        ]);
    }

    /**
     * Creates a new UserBills model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserBills();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if (isset($_POST["UserBills"])){
                    $category = Category::find()->where(['active'=>1])->one();
                    if ($category){
                        $userBillsCategoryTransactions = new UserBillsCategoryTransactions();
                        $userBillsCategoryTransactions->user_id = $model->user_id;
                        $userBillsCategoryTransactions->user_bills_id = $model->id;
                        $userBillsCategoryTransactions->category_id = $category->id;
                        $userBillsCategoryTransactions->amount = (int)$_POST["UserBills"]["amount"];
                        $userBillsCategoryTransactions->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserBills model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
//            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserBills model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->active = 100;
        $model->save();

        return $this->redirect(['index']);
    }


    public function actionDeleteTransaction($id)
    {
        $model = $this->findModelTransaction($id);
        $model->active = 100;
        $model->save();

        return $this->redirect(['view','id'=>$model->user_bills_id]);

    }

    /**
     * Finds the UserBills model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserBills the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserBills::findOne(['id' => $id, 'user_id'=>Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelTransaction($id)
    {
        if (($model = UserBillsCategoryTransactions::findOne(['id' => $id, 'user_id'=>Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
