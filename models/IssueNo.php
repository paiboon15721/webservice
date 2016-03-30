<?php

class IssueNo
{
   public $issueNo;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3102',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}