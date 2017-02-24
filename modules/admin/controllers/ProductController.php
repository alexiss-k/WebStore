<?php

namespace app\modules\admin\controllers;
use yii\filters\AccessControl;

use Yii;
use app\models\ProductModel;
use app\models\ProductSearch;
use app\modules\admin\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CategoryModel;
use app\models\CharacteristicModel;
use app\models\CharacteristicValueModel;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for ProductModel model.
 */
class ProductController extends DefaultController
{
    private $image_array = ['image/gif', 'image/jpeg', 'image/png', 'images/jpg'];

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete'],
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductModel();
        $model->rating = 0;
        $model->amountRated = 0;
        if (isset($_FILES['ProductModel']) && $_FILES['ProductModel']['name']['photo']!="") {
            if (!in_array($_FILES['ProductModel']['type']['photo'],$this->image_array))
                $model->addError('photo','Avaliable file types: jpg, gif, png.');
            else
            {
                $rnd = rand(0,9999);
                $uploadedFile = UploadedFile::getInstance($model,'photo');
                $fileName = 'files/'.$rnd.'_'.$uploadedFile->name;
                $model->photo = $fileName;
                $uploadedFile->saveAs($fileName);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (isset($_FILES['ProductModel']) && $_FILES['ProductModel']['name']['photo']!="") {
            if (!in_array($_FILES['ProductModel']['type']['photo'],$this->image_array))
                $model->addError('photo','Avaliable file types: jpg, gif, png.');
            else
            {
                if ($model->photo != "") {
                    unlink(Yii::getAlias('@app').Yii::getAlias('@web').'/'.$model->photo);
                }
                $rnd = rand(0,9999);
                $uploadedFile = UploadedFile::getInstance($model,'photo');
                $fileName = 'files/'.$rnd.'_'.$uploadedFile->name;
                $model->photo = $fileName;
                $uploadedFile->saveAs($fileName);
            }
        }

        if (isset($_POST['CharacteristicValueModel']))
        {
            $characteristics_values = $_POST['CharacteristicValueModel'];
            $success_values = true;
            foreach($characteristics_values as $characteristics_value)
            {
                $temp_value = CharacteristicValueModel::find()->where(['idProduct'=>$characteristics_value['idProduct'],'idCharacteristic'=>$characteristics_value['idCharacteristic']])->one();
                if ($temp_value == null)
                {
                    $temp_value = new CharacteristicValueModel();
                    $temp_value->idProduct = $characteristics_value['idProduct'];
                    $temp_value->idCharacteristic = $characteristics_value['idCharacteristic'];
                }
                $temp_value->value = $characteristics_value['value'];
                if (!$temp_value->save())
                {
                    print_r($temp_value->getErrors());
                    $success_values = false;
                }
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save() && $success_values) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
