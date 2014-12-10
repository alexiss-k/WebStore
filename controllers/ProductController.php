<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\CategoryModel;

class ProductController extends \yii\web\Controller
{
    public function actionCatalog($category=null)
    {
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
        return $this->render('catalog', 
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
        return $this->render('view', ['model' => $model,
        	'comments' => $comments,
        	'categories' => $categories, 
        	'child_categories' => $child_categories, 
        	'parent_categories' => array_reverse($parent_categories),
        	'current_level_categories' => $current_level_categories, 
        	'category' => $category]);
    }

}
