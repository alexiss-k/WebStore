<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

	$this->title = $model->name.' | WebStore';
?>

<style>
.nav > li > ul.nav > li 
{
	padding-left: 1em;
}

.product-buttons > a 
{
	margin-right: 1em;
	margin-bottom: 0.5em;
}
</style>

<div class="row">

			<div class="col-md-12">
                <div class="lead col-md-3">Web Store NURE</div>
                <?php echo $this->render('catalog_breadcrumbs',['category'=>$category, 'parent_categories'=>$parent_categories, 'model'=>$model]);?>
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

                <div class="thumbnail">  <!-- Product info start-->
                    <img class="img-responsive" src="<?= '/'.$model->photo ?>" alt="">
                    <div class="caption-full">
                        <h3 class="pull-right" style="position:relative; top:-22px;"><?=$model->price?> UAH</h3>
                        <h3><a href="#"><?=$model->name?></a></h3>
                        <p><?=$model->description?></p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right"><?=count($comments)?> reviews</p>
                        <p>
                            <?php 
                        	$i = 0;
                        	for (; $i<$model->rating; $i++)
                        		echo '<span class="glyphicon glyphicon-star"></span>';
                        	for (; $i<5; $i++)
                        		echo '<span class="glyphicon glyphicon-star-empty"></span>';
                        	?>
                            <?=$model->rating?> stars
                        </p>
                    </div>
                    <div class="text-right product-buttons">
                    <?php 
                    if (!\Yii::$app->user->isGuest && !$commented) {?>
                    	<a class="btn btn-info" id="add-review">Leave a Review</a>
                    <?php } ?>
                    	<?=Html::a('Add to cart',['/cart/add-item', 'id' => $model->id],['data-method'=>'post', 'class' => 'btn btn-success add-to-cart'])?>
                    </div>
                </div> <!-- Product info end-->           
                <div class="well"> <!-- Reviews part start-->

                <?php 
                if (!\Yii::$app->user->isGuest)
                {?>
            	<div id="review-form" style="visibility:hidden; height:0em;" class="col-md-12"> <!-- Form start-->
	            	<form action="<?=Url::to(['review/add'])?>" method="post">
	            	<?php $form = ActiveForm::begin(); ?>
	            	<div class="col-md-2" style="padding-top:0.5em;">Your review:</div>
	            	<div class="col-md-5"><textarea required name="CommentModel[text]" class="form-control" style="width:120%; height:5em; resize: none;" placeholder="Expressions about the product"></textarea></div>
	            	<div class="col-md-3 center-block">
	            		<div class="rating">
					    <span><input type="radio" name="CommentModel[mark]" id="str5" value="5"><label for="str5" class="glyphicon-star"></label></span>
					    <span><input type="radio" name="CommentModel[mark]" id="str4" value="4"><label for="str4" class="glyphicon-star"></label></span>
					    <span><input type="radio" name="CommentModel[mark]" id="str3" value="3"><label for="str3" class="glyphicon-star"></label></span>
					    <span><input type="radio" name="CommentModel[mark]" id="str2" value="2"><label for="str2" class="glyphicon-star"></label></span>
					    <span><input type="radio" name="CommentModel[mark]" id="str1" value="1"><label for="str1" class="glyphicon-star"></label></span>
					    </div>
					</div>
					<input type="hidden" name="CommentModel[idProduct]" value="<?=$model->id?>"/>
					<input type="hidden" name="CommentModel[idUser]" value="<?=\Yii::$app->user->id?>"/>
					<div class="col-md-2"><input type="submit" class="btn btn-info" value="Submit review" /></div>
					<?php ActiveForm::end(); ?>
					</form>
				</div> <!-- Form end-->
                <?php } ?>

                    <?php 
                    if ($comments!=null) {
                    ?>
                    
	                    <?php 
	                    if (\Yii::$app->user->isGuest) {?>
	                    <div class="text-right">
	                    	You have to be <a href="<?=Url::to(['site/login'])?>">logged in</a> to leave a review.
	                    </div>
	                    <?php } ?>

	                    
	                    <div class="row"> <!-- Reviews start-->
	                    <?php
		                    foreach($comments as $comment)
		                    {
		                    ?>
		                    
		                        <div class="col-md-12"> <!-- Review start-->
		                        
		                        <hr>
		                        	<?php 
		                        	$i = 0;
		                        	for (; $i<$comment->mark; $i++)
		                        		echo '<span class="glyphicon glyphicon-star"></span>';
		                        	for (; $i<5; $i++)
		                        		echo '<span class="glyphicon glyphicon-star-empty"></span>';
		                        	?>
		                            <?=$comment->getIdUser0()->one()->name?>
		                            <span class="pull-right">
		                            <?php
		                            $datetime1 = date_create('now');
									$datetime2 = date_create($comment->date);
									$interval = date_diff($datetime1, $datetime2);
									$days = $interval->format('%a days ago');
									if ($days[0]!='0')
									{
										echo "Added ".$days;
									}
									else
										echo "Added today";
		                            ?></span>
		                            <p><?=$comment->text?></p>
		                            
		                        </div> <!-- Review end-->
		                    <?php
		                    }
		                    ?>
		                </div> <!-- Reviews end-->

	                <?php
                	}
                	elseif (\Yii::$app->user->isGuest)
                	{
                    ?>
                    <div class="text-right">
                    	You have to be <a href="<?=Url::to(['site/login'])?>">logged in</a> to leave a review.
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                    </div>  <!-- Reviews part end-->
            	</div>

        </div>