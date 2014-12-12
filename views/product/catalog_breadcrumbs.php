<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
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
    if ($model != null)
    {
	    echo "<li><a href='".Url::to(['/product/catalog', 'category' => $category->id])."'>{$category->name}</a></li>";
	    echo "<li class='active'>{$model->name}</li>";
	}
	else
		echo "<li class='active'>{$category->name}</li>";
?>
	</ol>
</div>
<?php
}
?>