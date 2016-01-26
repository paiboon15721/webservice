<?php

class IssueNo
{
   public $issueNo;
   public $seq;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3102',
             'startAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}