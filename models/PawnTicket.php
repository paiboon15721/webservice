<?php

class PawnTicket
{
   public $seq;
   public $pawnDate;
   public $pawnNo;
   public $pawnName;
   public $pawnAddr;
   public $pawnDetail;
   public $pawnNumber;
   public $baht;
   public $satang;
   public $mark;
   public $checkPawn;
   public $updEmp;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3101',
             'returnDataStartAt' => '2',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}