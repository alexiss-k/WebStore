<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\ProductModel;

	$this->title = 'Catalog | WebStore';
?>
<style>
.nav > li > ul.nav > li 
{
	padding-left:1em;
}
</style>
<div class="row">

			<div class="col-md-12">
                <div class="lead col-md-3">Web Store NURE</div>
	                <?php echo $this->render('catalog_breadcrumbs',['category'=>$category, 'parent_categories'=>$parent_categories, 'model'=>$model, 'view'=>true]);?>
			</div>
            <div class="col-md-3">
            	<?php echo $this->render('catalog_categories_menu',
	            	['products' => $products, 
		        	'categories' => $categories, 
		        	'child_categories' => $child_categories, 
		        	'parent_categories' => $parent_categories,
		        	'current_level_categories' => $current_level_categories, 
		        	'category' => $category]);
		        ?>
            </div>

            <div class="col-md-9">
                <div class="row">
                <?php if (count($products)==0) echo "<div class='col-md-12 text-center'><img src='/files/nothing.png' /></div>";?>
                <?php foreach ($products as $product) {?>
                    <div class="col-sm-12 col-lg-12 col-md-12">
                        <div class="col-md-3 text-center">
                        <img class="thumbnail col-md-12" src="<?='/'.$product->photo?>" alt="">
                        </div>
                        <div class="col-md-5">
                        <a href="<?=Url::to(['/product/view','id'=>$product->id])?>" ><h4><?=$product->name?></h4></a>
                        <p><?=mb_substr($product->description,0,360).'...'?></p>
                        </div>
                        <div class="col-md-2" style="vertical-align:middle;">
                        <br><br><h3><?=$product->price?> UAH</h3>
                        </div>
                        <div class="col-md-2 text-right">
                        <br><br>
                        <a class="btn btn-info" style="margin-bottom:10px;" href="<?=Url::to(['/product/view','id'=>$product->id])?>">View details</a>
                        <?=Html::a('Add to cart',['/cart/add-item', 'id' => $product->id],['data-method'=>'post', 'class' => 'btn btn-success add-to-cart'])?>
                        </div>
                        <div class="col-md-12">
                        <hr>
                        </div>
                    </div>
                 <?php } ?>
                </div>

            </div>

        </div>
