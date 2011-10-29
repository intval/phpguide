

<?php
foreach($wallPosts as $post)
{
    $this->renderPartial('//wall/wallPost', array('post' => &$post));
}
