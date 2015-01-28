<?php

class FlexiChoice extends Varchar
{

    public function scaffoldFormField($title = null)
    {
        $field = new FlexiChoiceField($this->name, $title);
        return $field;
    }

    public function __construct($name = null, $size = 255, $options = array()) {
        parent::__construct($name, $size, $options);
    }

}
