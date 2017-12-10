<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.10.2017
 * Time: 21:43
 */

namespace Valid;

class FieldRules {
    private $params = array();
    public function __construct(){}
    public function int()
    {
        $this->params['type'] = 'int';
        return $this;
    }
    public function string($length = null)
    {
        $this->params['type'] = 'string';
        $this->params['length'] = $length;
        return $this;
    }
    public function float()
    {
        $this->params['type'] = 'float';
        return $this;
    }
    public function date()
    {
        $this->params['type'] = 'date';
        return $this;
    }
    public function mail()
    {
        $this->params['type'] = 'mail';
        return $this;
    }
    public function phone()
    {
        $this->params['type'] = 'phone';
        return $this;
    }
    public function oneOfMany($values)
    {
        $this->params['type'] = 'oneOfMany';
        $this->params['values'] = $values;
        return $this;
    }
    public function shouldBe($value)
    {
        $this->params['type'] = 'shouldBe';
        $this->params['value'] = $value;
        return $this;
    }
    public function requred()
    {
        $this->params['required'] = true;
        return $this;
    }
    public function customCheck($func)
    {
        $this->params['custom_function'] = $func;
        return $this;
    }
    public function errMessage($msg)
    {
        $this->params['errMessage'] = $msg;
        return $this;
    }
    public function getParams()
    {
        return $this->params;
    }
}