    foreach(Article::model()->findAll() as $article)
    {
        /*** @var Article $article */

        $table = '#\<table\>.*\<\/table\>#iums';
        $article->html_content = preg_replace($table, '', $article->html_content, 2);



        $article->html_content =


        '<table>
            <tbody>
                <tr>
                    <td>
                        <img src="//ncdn.phpguide.co.il/pixel.gif" width="75" height="75" title="'.e($article->image).'" alt="'.e($article->title).'" />
                    </td>
                    <td valign="top">
                        <div style="text-align: right;">'.$article->html_desc_paragraph.'</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- <cut> -->

        '
        . $article->html_content;

        $article->save();
    }