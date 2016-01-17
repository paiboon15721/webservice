<?php

final class RequestInput
{
    public $inbuf;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new RequestInput();
        }
        return $inst;
    }

    private function __construct()
    {
    }
}

final class WebService
{

    private function __construct()
    {
    }

    public static function send($serviceName, $serviceNumber, $sendMessage)
    {
        $requestInput = RequestInput::Instance();
        $requestInput->inbuf = '1|'
            . 'sdpa_' . $serviceName . '|'
            . $serviceNumber . '|'
            . str_replace("||", "| |", str_replace("||", "| |", $sendMessage));
        $soapClient = new SoapClient(Config::get('web_service/url'),
            array(
                'encoding' => Config::get('web_service/encoding'),
                'trace' => true,
                'exceptions' => false
            )
        );
        $bServiceName = Config::get('web_service/b_service_name');
        $responseOutput = $soapClient->__soapCall($bServiceName,
            array($bServiceName => $requestInput)
        );
        return $responseOutput->outbuf;
    }

    public static function getObject(array $configurations)
    {
        $parameters = $configurations['parameters'];
        $sendMessage = '';
        foreach ($parameters as $parameter) {
            $sendMessage .= $parameter . '|';
        }
        $responseString = WebService::send(
            $configurations['serviceName'],
            $configurations['serviceNumber'],
            $sendMessage
        );
        $responseArray = explode('|', $responseString);
        $vars = array_keys(get_class_vars($configurations['class']));
        $recordAmount = (count($responseArray) - ($configurations['startAt'] + 1)) / count($vars);
        $JSONObject = new JSONObject();
        $i = $configurations['startAt'];
        for ($j = 1; $j <= $recordAmount; $j++) {
            $object = new $configurations['class']();
            foreach ($vars as $var) {
                $object->$var = $responseArray[$i++];
            }
            $JSONObject->add($object);
        }
        return $JSONObject;
    }
}