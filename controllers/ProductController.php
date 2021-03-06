<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\CategoryModel;
use app\models\CommentModel;

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
    	$categories = CategoryModel::getCategoriesByParentId(null);
    	$products = array();
    	$parent_categories = array();
    	$child_categories = array();
    	$current_level_categories = array();
    	if ($category!=null) {
    		$category = CategoryModel::getCategoryById($category);
    		$no_children = false;
    		$search_categories[] = $category;
    		$result_categories[] = $category->id;
    		while(!$no_children)
    		{
    			$count = 0;
    			foreach ($search_categories as $category_temp)
    			{
    				$temp_categories = CategoryModel::getCategoriesByParentId($category_temp->id);
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
 			$products = ProductModel::getProductsInCategories($result_categories);
 			if ($category->parentId != null) {
				$parent_category = CategoryModel::getCategoryById($category->parentId);
				while ($parent_category!=null)
				{
					$parent_categories[] = $parent_category;
					$parent_category = CategoryModel::getCategoryById($parent_category->parentId);
				}
 			}
 			$current_level_categories = CategoryModel::getCategoriesByParentId($category->parentId);
 			$child_categories = CategoryModel::getCategoriesByParentId($category->id);
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
    	$model = ProductModel::getProduct($id);
    	$comments = CommentModel::getCommentsToProduct($model->id);
    	$parent_categories = array();
    	$categories = CategoryModel::getCategoriesByParentId(null);
    	$category = CategoryModel::getCategoryById($model->idCategory);
		$no_children = false;
		$search_categories[] = $category;
		$result_categories[] = $category->id;
		while(!$no_children)
		{
			$count = 0;
			foreach ($search_categories as $category_temp)
			{
				$temp_categories = CategoryModel::getCategoriesByParentId($category_temp->id);
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
			if ($category->parentId != null) {
			$parent_category = CategoryModel::getCategoryById($category->parentId);
			while ($parent_category!=null)
			{
				$parent_categories[] = $parent_category;
				$parent_category = CategoryModel::getCategoryById($parent_category->parentId);
			}
			}
			$current_level_categories = CategoryModel::getCategoriesByParentId($category->parentId);
			$child_categories = CategoryModel::getCategoriesByParentId($category->id);

    	if ($model == null)
    		throw new NotFoundHttpException('The requested product does not exist.');
        $user_id = \Yii::$app->user->getId();
    	$this_comment = CommentModel::getUserCommentToProduct($model->id,$user_id);
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
