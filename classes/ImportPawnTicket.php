<?php

class ImportPawnTicket
{
    public $status;
    public $message;

    public static function get(array $parameters)
    {
        $items = json_decode(array_pop($parameters));
        $totalItems = count($items);
        $loopPerRound = 100;
        $loopNeed = ceil($totalItems / $loopPerRound);
        $result = '';
        for ($i = 0; $i < $loopNeed; $i++) {
            $loopRound = $loopPerRound;
            if (($i + 1) == $loopNeed) {
                $loopRound = $totalItems % $loopPerRound;
                if ($loopRound == 0) {
                    return true;
                }
            }
            $seq = ($i * 100);
            $prepareArray = array(
                $seq,
                $loopRound
            );
            for ($j = 0; $j < $loopRound; $j++) {
                $objIndex = ($i * $loopPerRound) + $j;
                array_push($prepareArray, ConvertDateTime::dateForService($items[$objIndex]->B));
                array_push($prepareArray, $items[$objIndex]->C);
                array_push($prepareArray, $items[$objIndex]->D);
                array_push($prepareArray, $items[$objIndex]->E);
                array_push($prepareArray, $items[$objIndex]->F);
                array_push($prepareArray, $items[$objIndex]->G);
                array_push($prepareArray, $items[$objIndex]->H);
                array_push($prepareArray, $items[$objIndex]->I);
                array_push($prepareArray, $items[$objIndex]->J);
            }
            $result = WebService::getObject(
                array(
                    'serviceName' => 'pawn',
                    'serviceNumber' => '3000',
                    'returnDataStartAt' => '0',
                    'parameters' => array_merge($parameters, $prepareArray),
                    'class' => __CLASS__,
                )
            );

            $resultItems = $result->getArray();
            if ($resultItems[0]->status != 1) {
                return $result;
            }
        }
        return $result;
    }
}