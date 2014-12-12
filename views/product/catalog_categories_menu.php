<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>

<ul class="nav">
<?php 
foreach($categories as $category_temp) {
	$active = '';
	if ($category!=null && $category->id == $category_temp->id)
		$active .= ' active';
	if ($category!=null && count($parent_categories)>0 && $parent_categories[0]->id == $category_temp->id)
		$active .=' list-group-item-info';
	echo '<li><b><a href="'.Url::to(['/product/catalog', 'category' => $category_temp->id]).'" class="list-group-item '.$active.'">'.$category_temp->name.'</a></b>';
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