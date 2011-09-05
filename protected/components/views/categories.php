<div class="categories_list">

        <? foreach( $categories as $cat ):  ?>
        
            <a class="category_link" href=<?=bu("cat/" . e(urlencode($cat['name'])) . ".htm")?>>
            <?=e($cat['name']);?>
            </a>

	<? endforeach; ?>

</div>
