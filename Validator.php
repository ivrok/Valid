<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.10.2017
 * Time: 21:29
 */

namespace Valid;


class Validator
{
    private $fieldRules = array();
    private $errorFields = array();
    public function __construct(){}
    public function addFieldRules($name)
    {
        $this->fieldRules[$name] = $obj = new \Valid\FieldRules();
        return $obj;
    }
    public function validArray($notValidFields)
    {
        $ERRORS = array();
        $validPost = array();
        foreach ($this->fieldRules as $key => $objRules) {
            $rules = $objRules->getParams();
            if (!isset($notValidFields[$key]) || !$notValidFields[$key]) {
                if (isset($rules['required'])) {
                    $ERRORS[$key] = $rules['errMessage'];
                }
                continue;
            }
            $val = $notValidFields[$key];
            switch ($rules['type']) {
                case 'int' :
                    $val = (int)$val;
                    break;
                case 'float' :
                    $val = (float)$val;
                    break;
                case 'string' :
                    $val = mb_ereg_replace('^[^\d\w\ \,\.]*$', '', $val);
                    break;
                case 'date' :
                    $val = mb_ereg_replace('^[^\d\-\.\ ]*$', '', $val);
            }
            if (!$val && isset($rules['required'])) {
                $ERRORS[$key] = $rules['errMessage'] ? $rules['errMessage'] : 'Incorrect field!';
            }
            $validPost[$key] = $val;
        }
        $this->errorFields = $ERRORS;
        return $validPost;
    }
    public function getErrors()
    {
        return $this->errorFields;
    }
}
