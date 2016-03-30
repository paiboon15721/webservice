<?php

class ReportIssueNoList
{
   public $issueNo;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3109',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}