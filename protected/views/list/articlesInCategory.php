
<h1><?=e($category->name)?></h1>
<div class="category_bread_crumbs">
    <a href="">phpguide</a> 
    &raquo;
    <a href="index.php#guides_cats">כתבות ומדריכים</a>
    &raquo;
מדריכים בנושא 
    <?=e($category->name)?>
</div>

<? $this->renderPartial('//list/articlesList' , array('articles' => $category->articles)); ?>