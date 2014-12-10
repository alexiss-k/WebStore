<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
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
                
	                <?php
	                if  ($category!=null)
	                { ?>
	            	<div class="col-md-9">
	                	<ol class="breadcrumb">
	            	<?php
	            		echo "<li><a href='".Url::to(['/product/catalog'])."'>Catalog</a></li>";
	            		if  (count($parent_categories)>0)
		                foreach($parent_categories as $parent_category)
		                {
		                	echo "<li><a href='".Url::to(['/product/catalog', 'category' => $parent_category->id])."'>{$parent_category->name}</a></li>";
		                }
		                echo "<li><a href='".Url::to(['/product/catalog', 'category' => $category->id])."'>{$category->name}</a></li>";
		                echo "<li class='active'>{$model->name}</li>";
		            ?>
		            	</ol>
					</div>
		            <?php
	            	}
	                ?>
			</div>

            <div class="col-md-3">
                <ul class="nav">
                <?php 
                foreach($categories as $category_temp) {
                	$active = '';
                	if ($category!=null && $category->id == $category_temp->id)
                		$active .= ' active';
                	if ($category!=null && count($parent_categories)>0 && $parent_categories[0]->id == $category_temp->id)
                		$active .=' list-group-item-info';
                	echo '<li><a href="'.Url::to(['/product/catalog', 'category' => $category_temp->id]).'" class="list-group-item '.$active.'">'.$category_temp->name.'</a>';
                	if ($category!=null && $category->id == $category_temp->id)
                	{
                		echo '<ul class="nav">';
                		foreach($child_categories as $child_category)
                		{
                			echo '<li><a href="'.Url::to(['/product/catalog', 'category' => $child_category->id]).'" class="list-group-item">'.$child_category->name.'</a></li>';
                		}
                		echo '</ul>';
                	}
                	if ($category!=null && count($parent_categories)>0 && $parent_categories[0]->id == $category_temp->id)
                	{
                		$level = "";
                		echo "<ul class='nav'>";
                		for ($i = 1; $i < count($parent_categories); $i++)
                		{
                			if ($i>1)
                				echo '<ul class="nav">';
                			echo '<li><a href="'.Url::to(['/product/catalog', 'category' => $parent_categories[$i]->id]).'" class="list-group-item list-group-item-info">'.$parent_categories[$i]->name.'</a><ul class="nav">';
                			$level.='</ul></li>';
                			if ($i>1)
                				$level .= '</ul>';
                		}
                		foreach($current_level_categories as $temp_category)
                		{
                			$active = '';
                			if ($temp_category->id == $category->id)
                				$active = 'active';
                			echo '<li><a href="'.Url::to(['/product/catalog', 'category' => $temp_category->id]).'" class="list-group-item '.$active.'">'.$temp_category->name.'</a>';
                			if ($temp_category->id == $category->id)
                			{
                				echo '<ul class="nav">';
	                			foreach($child_categories as $child_category)
		                		{
		                			echo '<li><a href="'.Url::to(['/product/catalog', 'category' => $child_category->id]).'" class="list-group-item">'.$child_category->name.'</a></li>';
		                		}
		                		echo '</ul>';
		                	}
		                	echo '</li>';
                		}
                		echo "</ul>";
                		echo $level;
                	}
                	echo '</li>';
                }
                ?>	
                </ul>
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

