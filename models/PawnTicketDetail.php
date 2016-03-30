<?php

class PawnTicketDetail
{
   public $pawnDate;
   public $pawnNo;
   public $pawnName;
   public $pawnAddress;
   public $pawnDetail;
   public $pawnNumber;
   public $pawnBaht;
   public $pawnSatang;
   public $pawnMark;
   public $datePost;
   public $dateExpire;

   public static function get(array $parameters)
   {
       return WebService::getObject(
           array(
             'serviceName' => 'pawn',
             'serviceNumber' => '3105',
             'returnDataStartAt' => '1',
             'parameters' => $parameters,
             'class' => __CLASS__,
            )
         );
     }
}