<?php

class getWS
{
    public $inbuf;
}

class getWSResponse
{
    public $outbuf;
}

function connDPAWS($sName, $strInput, $outputType = '0')
{
    try {
        $send = "1|" . $sName . "|" . $strInput;
        $requestInput = new getWS();
        $resposeOutput = new getWSResponse();
        $requestInput->inbuf = $send;
        //$client = new SoapClient("http://172.16.224.205:8080/wsdl", array('encoding' => 'UTF-8', 'trace' => true, 'exceptions' => true, 'cache_wsdl' => WSDL_CACHE_BOTH));
        $client = new SoapClient("http://172.16.224.205:8080/wsdl",
            array(
                'encoding' => 'UTF-8',
                'trace' => true,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_BOTH
            )
        );
    } catch (Exception $e) {
        if ((int)$outputType == 0) {
            $errorException = "999|Caught exception [new SoapClient]: " . $e->getMessage();
            return $errorException;
        } else {
            $errorException[0] = "999";
            $errorException[1] = "Caught exception [new SoapClient]: " . $e->getMessage();

            return $errorException;
        }
    }

    try {
        $resposeOutput = $client->__soapCall("bdpa_wsreqlicWS", array($sName => $requestInput));
    } catch (Exception $e) {
        if ((int)$outputType == 0) {
            $errorException = "999|Caught exception [soapCall]: " . $e->getMessage();
            return $errorException;
        } else {
            $errorException[0] = "999";
            $errorException[1] = "Caught exception [soapCall]: " . $e->getMessage();

            return $errorException;
        }
    }

    try {
        //$outputData = iconv('UTF-8','TIS-620',$resposeOutput->outbuf);
        $outputData = $resposeOutput->outbuf;
    } catch (Exception $e) {
        if ((int)$outputType == 0) {
            $errorException = "999|Caught exception [resposeOutput]: " . $e->getMessage();
            return $errorException;
        } else {
            $errorException[0] = "999";
            $errorException[1] = "Caught exception [resposeOutput]: " . $e->getMessage();

            return $errorException;
        }
    }

    try {
        if ((int)$outputType == 0) {
            return $outputData;
        } else {
            $expOutput = explode("|", $outputData);
            return $expOutput;
        }

    } catch (Exception $e) {
        if ((int)$outputType == 0) {
            $errorException = "999|Caught exception: " . $e->getMessage();
            return $errorException;
        } else {
            $errorException[0] = "999";
            $errorException[1] = "Caught exception: " . $e->getMessage();

            return $errorException;
        }
    }
}

?>
