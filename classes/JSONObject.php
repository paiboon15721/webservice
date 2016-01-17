<?php

class JSONObject
{

    private $items = array();

    public function getJSON()
    {
        return JSONObject::encode($this->items);
    }

    public static function encode($array) {
        $encoded = json_encode($array);
        $unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
            return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
        }, $encoded);
        return $unescaped;
    }

    public function getArray()
    {
        return $this->items;
    }

    public function add($object)
    {
        array_push($this->items, $object);
    }
}