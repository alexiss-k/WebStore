<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

	$this->title = $model->name.' | WebStore';
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

                <div class="thumbnail">
                    <img class="img-responsive" src="<?= '/'.$model->photo ?>" alt="">
                    <div class="caption-full">
                        <h4 class="pull-right"><?=$model->price?> UAH</h4>
                        <h4><a href="#"><?=$model->name?></a>
                        </h4>
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
                </div>

                <div class="well">

                    <?php 
                    if (!\Yii::$app->user->isGuest) {?>
                    <div class="text-right">
                        <a class="btn btn-success">Leave a Review</a>
                    </div>
                    <?php }
                    else { ?>
                    <div class="text-right">
                    	You have to be <a href="<?=Url::to(['site/login'])?>">logged in</a> to leave a review.
                    </div>
                    <?php }?>

                    <hr>
                    <div class="row">
                    <?php 
                    if ($comments!=null)
                    foreach($comments as $comment)
                    {
                    ?>
                    
                        <div class="col-md-12">
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
							echo $interval->format('%a days ago');
                            ?></span>
                            <p><?=$comment->text?></p>
                            <hr>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>

            </div>

        </div>

