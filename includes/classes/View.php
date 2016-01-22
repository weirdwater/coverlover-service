<?php

/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 19/01/16
 * Time: 13:01
 */
class View
{
    private $responseObject;

    /**
     * View constructor.
     */
    public function __construct($response)
    {
        $this->responseObject = $response;
    }

    public function objectToXML($object, $name)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><'.$name.'></'.$name.'>');

        foreach ($object as $key => $value) {
            if (gettype($value) === 'object' || gettype($value) === 'array') {
                $newChild = $xml->addChild($key);
                $this->objectToXmlChild($newChild, $value);
            }
            elseif (gettype($value) === 'array') {
                $newChild = $xml->addChild($key);
                $this->arrayToXmlChild($newChild, $value, $key);
            }
        }

        return $xml->asXML();
    }

    public function objectToXMLChild(&$xmlChild, $object)
    {
        foreach ($object as $key => $value) {
            if (gettype($value) === 'object' || gettype($value) === 'array') {
                $newChild = $xmlChild->addChild($key);
                $this->objectToXmlChild($newChild, $value);
            }
            elseif (gettype($value) === 'array') {
                $newChild = $xmlChild->addChild($key);
                $this->arrayToXmlChild($newChild, $value, $key);
            }
            else {
                $xmlChild->addChild($key, $value);
            }
        }
    }

    public function arrayToXMLChild(&$xmlChild, $array, $parentKey)
    {
        $type = $this->pluralToSimple($parentKey);
        foreach ($array as $key => $value) {
            if (gettype($value) === 'object') {
                $newChild = $xmlChild->addChild($type);
                $this->objectToXmlChild($newChild, $value);
            }
            elseif (gettype($value) === 'array') {
                $newChild = $xmlChild->addChild($type);
                $this->arrayToXmlChild($newChild, $value, $type);
            }
            else {
                $xmlChild->addChild($type, $value);
            }
        }
    }

    public function printJSON()
    {
        http_response_code($this->responseObject->getStatusCode());
        header('Content-Type : application/json');
        echo json_encode($this->responseObject);
    }

    public function printXML()
    {
        header('Content-Type : application/xml');

//        var_dump(get_object_vars($this->responseObject));
//        exit;
        $xml = new SimpleXMLElement('<?xml version="1.0"?><songs></songs>');
        $this->array_to_xml($this->objectToArray($this->responseObject), $xml);
        echo $xml -> asXML();
    }

    public function array_to_xml($array, &$xml, $parentKey = '') {
        foreach($array as $key => $value) {
            if(is_object($value)) {
                $key = $this->pluralToSimple($parentKey);
                $value = get_object_vars($value);
            }
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml->addChild("$key");
                    $this->array_to_xml($value, $subnode, $key);
                } else {
                    $this->array_to_xml($value, $xml, $key);
                }
            } else {
                $xml->addChild("$key","$value");
            }
        }
    }

    public function objectToArray($object)
    {
        $array = get_object_vars($object);
        foreach ($array as $key => $value) {
            if (is_object($value)) {
                $array[$key] = get_object_vars($value);
            }
        }
        return $array;
    }

    public function generateView()
    {
        http_response_code($this->responseObject->getStatusCode());
        switch ($_SERVER['HTTP_ACCEPT']) {
            case 'application/xml':
                $this->printXML();
                break;
            case 'application/json':
                $this->printJSON();
                break;
        }
    }

    function pluralToSimple($str)
    {
        $newStr = $str;

        $irregulars = [
            'women'     => 'woman',
            'men'       => 'man',
            'teeth'     => 'tooth',
            'children'  => 'child',
            'feet'      => 'foot',
            'people'    => 'person',
            'leaves'    => 'leaf',
            'mice'      => 'mouse',
            'geese'     => 'goose',
            'halves'    => 'half',
            'knives'    => 'knife',
            'wives'     => 'wife',
            'lives'     => 'life',
            'elves'     => 'elf',
            'loaves'    => 'loaf',
            'potatoes'  => 'potato',
            'tomatoes'  => 'tomato',
            'cacti'     => 'cactus',
            'foci'      => 'focus',
            'fungi'     => 'fungus',
            'nuclei'    => 'nucleus',
            'syllabi'   => 'syllabus',
            'analyses'  => 'analysis',
            'diagnoses' => 'diagnosis',
            'oases'     => 'oasis',
            'theses'    => 'thesis',
            'crises'    => 'crisis',
            'phenomena' => 'phenomenon',
            'criteria'  => 'criterion',
            'data'      => 'datum',
            'sheep'     => 'sheep',
            'fish'      => 'fish',
            'deer'      => 'deer',
            'species'   => 'species',
            'aircraft'  => 'aircraft'
        ];

        if (isset($irregulars[strtolower($str)])) {
            $newStr = $irregulars[strtolower($str)];
            if (substr($newStr, 0, 1) !== substr($str, 0, 1)) {
                $newStr = ucfirst($newStr);
            }
        }
        elseif (substr($str, strlen($str) - 3, strlen($str)) === 'ies') {
            $newStr = substr($str, 0, strlen($str) - 3);
            $newStr .= 'y';
        }
        elseif (substr($str, strlen($str) - 2, strlen($str)) === 'es') {
            $newStr = substr($str, 0, strlen($str) - 2);
        }
        else {
            $newStr = substr($str, 0, strlen($str) - 1);
        }

        return $newStr;
    }
}