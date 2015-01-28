<?php

class FlexiChoiceField extends FormField
{

    protected $composite_fields = array();

    public function __construct($name, $title = null, $value = null, $form = null)
    {
        $choices = $this->stat('choices');
        $field = new DropdownField("{$name}[Select]", '', array_combine($choices, $choices));
        $field->setEmptyString(_t('FlexiChoiceField.USE_OPTIONAL', "None - use provided text"));
        $this->composite_fields['Select'] = $field;

        $field = new TextField("{$name}[Text]", '');
        $field->setDescription(
            _t('FlexiChoiceField.TEXT_DESCRIPTION', 'Use this text in place of a selection.'));
        $this->composite_fields['Text'] = $field;

        $this->setForm($form);

        parent::__construct($name, $title, $value, $form);
    }

    public function setForm($form)
    {
        foreach ($this->composite_fields as $type => $field) {
            $field->setForm($form);
        }
        return parent::setForm($form);
    }

    public function setName($name)
    {
        foreach ($this->composite_fields as $type => $field) {
            $field->setName("{$name}[{$type}]");
        }

        return parent::setName($name);
    }

    /**
     * @return string
     */
    public function Field($properties = array())
    {
        $module_dir = basename(dirname(dirname(__DIR__)));

        Requirements::javascript($module_dir . '/js/FlexiChoiceField.js');
        Requirements::css($module_dir . '/css/FlexiChoiceField.css');

        $str = '<div class="fieldgroup FlexiChoiceField">';

        foreach ($this->composite_fields as $type => $field) {
            $str .= '<div class="fieldgroupField FlexiChoiceField' . $type . '">';
            $str .= $field->FieldHolder();
            $str .= '</div>';
        }

        $str .= '</div>';

        return $str;
    }


    public function setValue($value)
    {
        if (is_array($value)) {
            foreach(array_intersect_key($value, $this->composite_fields) as $key => $val) {
                $this->composite_fields[$key]->setValue($val);
            }
        } else {

            $val = ($value instanceof  FlexiChoice) ? $value->getValue() : $value;

            if (in_array($val, $this->composite_fields['Select']->getSource())) {
                $this->composite_fields['Select']->setValue($val);
            } else {
                $this->composite_fields['Text']->setValue($val);
            }

        }

        $this->value = ($this->composite_fields['Select']->Value()) ?  : $this->composite_fields['Text']->Value();
        return $this;
    }


    public function performReadonlyTransformation()
    {
        return new ReadonlyField($this->Name, $this->Title, $this->Value);
    }

    public function setReadonly($bool)
    {
        parent::setReadonly($bool);

        if ($bool) {
            foreach ($this->composite_fields as $field) {
                $field->performReadonlyTransformation();
            }
        }
    }
}

