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

final class
WebService
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

        WebService::log($requestInput->inbuf);

        try {
            $soapClient = new SoapClient(Config::get('web_service/url'),
                array(
                    'encoding' => Config::get('web_service/encoding'),
                    'trace' => true,
                    'exceptions' => true,
                    'cache_wsdl' => WSDL_CACHE_BOTH
                    //'connection_timeout' => 500000,
                    //'keep_alive' => false
                )
            );
            $bServiceName = Config::get('web_service/b_service_name');
            $responseOutput = $soapClient->__soapCall($bServiceName,
                array($bServiceName => $requestInput)
            );
            $responseString = $responseOutput->outbuf;
            if (substr($responseString, -1) == '|') {
                $responseString = substr($responseString, 0, -1);
            }
            return $responseString;
        } catch (SoapFault $fault) {
            throw new Exception("SOAP Fault: " . $fault->getMessage());
        }
    }

    private static function log($request)
    {
        $log = "User: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, H:i:s") . ' - ' . time() . PHP_EOL .
            "Request: " . $request . PHP_EOL .
            "--------------------------------------------------------------------------------------" . PHP_EOL;
        file_put_contents('../logs/log_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
    }

    public static function produceSendMessage($parameters)
    {
        $sendMessage = '';
        $parameters = new RecursiveIteratorIterator(new RecursiveArrayIterator($parameters));
        foreach ($parameters as $parameter) {
            $sendMessage .= $parameter . '|';
        }
        return $sendMessage;
    }

    public static function getObject(array $configurations)
    {
        try {
            $responseString = WebService::send(
                $configurations['serviceName'],
                $configurations['serviceNumber'],
                WebService::produceSendMessage($configurations['parameters'])
            );
        } catch (Exception $e) {
            $JSONObject = new JSONObject();
            $JSONObject->add(array('errorMessage' => $e->getMessage()));
            return $JSONObject;
        }

        $responseArray = explode('|', $responseString);
        $vars = array_keys(get_class_vars($configurations['class']));
        $recordAmount = (count($responseArray) - ($configurations['returnDataStartAt'])) / count($vars);
        $JSONObject = new JSONObject();
        $i = $configurations['returnDataStartAt'];
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