<ul class="categories_list">

        <?php foreach( $categories as $cat ):  ?>

            <li>
            <a class="category_link" href=<?=bu("cat/" . e(urlencode($cat['name'])) . ".htm")?>>
            <?=e($cat['name']);?>
            </a>
            </li>

	<?php endforeach; ?>

</ul>
