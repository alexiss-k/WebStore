<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\CategoryModel;

class ProductController extends \yii\web\Controller
{

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        \Yii::$app->user->setReturnUrl(array_merge([$this->getRoute()], $action->controller->actionParams));
        return $result;
    }

    public function actionCatalog($category=null,$view=null)
    {
        if ($view!=null)
        {
            \Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'catalog_view', 'value' => 'catalog_'.$view]));
            return $this->redirect(\Yii::$app->user->getReturnUrl());
        }
        $view = \Yii::$app->request->cookies->getValue('catalog_view');
        if ($view == null)
            $view = 'catalog_grid';
    	$categories = CategoryModel::find()->where(['parentId'=>null])->all();
    	$products = array();
    	$parent_categories = array();
    	$child_categories = array();
    	$current_level_categories = array();
    	if ($category!=null) {
    		$category = CategoryModel::find()->where(['id'=>$category])->one();
    		$products = ProductModel::find()->where(['idCategory'=>$category->id])->all();
    		$no_children = false;
    		$search_categories[] = $category;
    		$result_categories[] = $category->id;
    		while(!$no_children)
    		{
    			$count = 0;
    			foreach ($search_categories as $category_temp)
    			{
    				$temp_categories = CategoryModel::find()->where(['parentId'=>$category_temp->id])->all();
    				$count += count($temp_categories);
    				foreach ($temp_categories as $temp_category)
    					$result_categories[] = $temp_category->id;
    			}
    			if ($count==0)
    				$no_children = true;
    			$search_categories = array();
    			foreach($temp_categories as $search_category)
    				$search_categories[] = $search_category;
    		}
 			$products = ProductModel::find()->where(['idCategory'=>$result_categories])->all();
 			if ($category->parentId != null) {
				$parent_category = CategoryModel::find()->where(['id'=>$category->parentId])->one();
				while ($parent_category!=null)
				{
					$parent_categories[] = $parent_category;
					$parent_category = CategoryModel::find()->where(['id'=>$parent_category->parentId])->one();
				}
 			}
 			$current_level_categories = CategoryModel::find()->where(['parentId'=>$category->parentId])->all();
 			$child_categories = CategoryModel::find()->where(['parentId'=>$category->id])->all();
    	}
    	else
    		$products = ProductModel::find()->all();
        return $this->render($view, 
        	['products' => $products, 
        	'categories' => $categories, 
        	'child_categories' => $child_categories, 
        	'parent_categories' => array_reverse($parent_categories),
        	'current_level_categories' => $current_level_categories, 
        	'category' => $category]);
    }

    public function actionView($id)
    {
    	$model = ProductModel::find()->where(['id' => $id])->one();
    	$comments = $model->getComments()->all();
    	$parent_categories = array();
    	$categories = CategoryModel::find()->where(['parentId'=>null])->all();
    	$category = CategoryModel::find()->where(['id'=>$model->idCategory])->one();
		$products = ProductModel::find()->where(['idCategory'=>$category->id])->all();
		$no_children = false;
		$search_categories[] = $category;
		$result_categories[] = $category->id;
		while(!$no_children)
		{
			$count = 0;
			foreach ($search_categories as $category_temp)
			{
				$temp_categories = CategoryModel::find()->where(['parentId'=>$category_temp->id])->all();
				$count += count($temp_categories);
				foreach ($temp_categories as $temp_category)
					$result_categories[] = $temp_category->id;
			}
			if ($count==0)
				$no_children = true;
			$search_categories = array();
			foreach($temp_categories as $search_category)
				$search_categories[] = $search_category;
		}
			$products = ProductModel::find()->where(['idCategory'=>$result_categories])->all();
			if ($category->parentId != null) {
			$parent_category = CategoryModel::find()->where(['id'=>$category->parentId])->one();
			while ($parent_category!=null)
			{
				$parent_categories[] = $parent_category;
				$parent_category = CategoryModel::find()->where(['id'=>$parent_category->parentId])->one();
			}
			}
			$current_level_categories = CategoryModel::find()->where(['parentId'=>$category->parentId])->all();
			$child_categories = CategoryModel::find()->where(['parentId'=>$category->id])->all();

    	if ($model == null)
    		throw new NotFoundHttpException('The requested product does not exist.');
    	$this_comment = $model->getComments()->where(['idUser'=>\Yii::$app->user->id])->one();
        return $this->render('view', ['model' => $model,
        	'comments' => $comments,
        	'commented' => ($this_comment != null),
        	'categories' => $categories, 
        	'child_categories' => $child_categories, 
        	'parent_categories' => array_reverse($parent_categories),
        	'current_level_categories' => $current_level_categories, 
        	'category' => $category]);
    }

}
