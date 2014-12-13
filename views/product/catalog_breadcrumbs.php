<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>

<style>
.breadcrumb > li{
	position:relative;
	top:-2em;
}	
</style>

<div class="col-md-9">
	<ol class="breadcrumb" style="height:3em;">
	<div class="text-right" style="font-size:1.5em;visibility:<?php echo (isset($view) && $view)?'visible':'hidden';?>">
        <a href="<?=Url::to(['','view'=>'grid'])?>" title="Grid view"><span class="glyphicon glyphicon-th"></span></a>
        <a href="<?=Url::to(['','view'=>'list'])?>" title="List view"><span class="glyphicon glyphicon-th-list"></span></a>
    </div>
<?php
	echo "<li><a href='".Url::to(['/product/catalog'])."'>Catalog</a></li>";
	if  (count($parent_categories)>0)
    foreach($parent_categories as $parent_category)
    {
    	echo "<li><a href='".Url::to(['/product/catalog', 'category' => $parent_category->id])."'>{$parent_category->name}</a></li>";
    }
    if ($model != null)
    {
	    echo "<li><a href='".Url::to(['/product/catalog', 'category' => $category->id])."'>{$category->name}</a></li>";
	    echo "<li class='active'>{$model->name}</li>";
	}
	elseif ($category!=null)
		echo "<li class='active'>{$category->name}</li>";
?>
	
	</ol>
</div>
