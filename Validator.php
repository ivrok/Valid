<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.10.2017
 * Time: 21:29
 */

namespace Valid;

use Valid;

class Validator
{
    private $fieldRules = array();
    private $errorFields = array();
    private $nullDataTextError = null;

    public function __construct(){}
    public function addFieldRules($name)
    {
        $this->fieldRules[$name] = $obj = new FieldRules();
        return $obj;
    }
    public function validArray($notValidFields)
    {
        $ERRORS = array();
        $validPost = array();
        foreach ($this->fieldRules as $key => $objParams) {
            $params = $objParams->getParams();
            if (!isset($notValidFields[$key]) || !$notValidFields[$key]) {
                if (isset($params['required'])) {
                    $ERRORS[$key] = $this->nullDataTextError ? $this->nullDataTextError : 'This field is required.';
                }
                continue;
            }
            $val = $notValidFields[$key];
            $error = false;
            if (isset($params['custom_function'])) {
                if (!call_user_func($params['custom_function'], $val))
                    $error = true;
            } else {
                switch ($params['type']) {
                    case 'int' :
                        $val = (int)$val;
                        break;
                    case 'float' :
                        $val = (float)$val;
                        break;
                    case 'string' :
                        $val = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $val);
                        $val = strip_tags($val);
                        if ($params['length']) mb_substr($val, 0, $params['length']);
                        break;
                    case 'date' :
                        $val = mb_ereg_replace('^[^\d\-\.\ \/]*$', '', $val);
                        if (!FieldChecker::datetime($val))
                            $error = true;
                        break;
                    case 'mail' :
                        if (!FieldChecker::mail($val))
                            $error = true;
                        break;
                    case 'phone' :
                        $val = mb_ereg_replace('[^\d]+', '', $val);
                        if (strlen($val) < 5)
                            $error = true;
                        break;
                    case 'oneOfMany' :
                        if (!in_array($val, $params['values']))
                            $error = true;
                        break;
                    case 'shouldBe' :
                        if ($val != $params['value'])
                            $error = true;
                        break;
                    default:
                        continue;
                }
            }
            if ($error) {
                $ERRORS[$key] = isset($params['errMessage']) ? $params['errMessage'] : 'Incorect field.';
                continue;
            }
            $validPost[$key] = $val;
        }
        $this->errorFields = $ERRORS;
        return $validPost;
    }
    public function nullDataErr($text)
    {
        $this->nullDataTextError = $text;
    }
    public function getErrors()
    {
        return $this->errorFields;
    }
}
