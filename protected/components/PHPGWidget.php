<?php

class PHPGWidget extends CWidget{

    public function renderPartial($view, array $data = null, $return = false)
    {
        return $this->render($view, $data, $return);
    }

} 