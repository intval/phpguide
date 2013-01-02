<?php

class clientScript extends CClientScript
{
    public function renderHead(&$output)
    {
        parent::renderHead($output);
        $this->replaceCoffeeType($output);
    }

    public function renderBodyBegin(&$output)
    {
        parent::renderBodyBegin($output);
        $this->replaceCoffeeType($output);
    }

    public function renderBodyEnd(&$output)
    {
        parent::renderBodyEnd($output);
        $this->replaceCoffeeType($output);
    }

    private function replaceCoffeeType(&$html)
    {
        $replaceTag = function($matches)
        {
            return str_replace(
                'text/javascript',
                'text/coffeescript',
                $matches[0]
            );
        };

        $pattern = '#<script type="text/javascript" src="[^"]*\.coffee"></script>#ius';
        $html = preg_replace_callback($pattern, $replaceTag, $html);
    }
}
