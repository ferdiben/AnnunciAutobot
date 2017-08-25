<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require 'vendor/autoload.php';
$client = new Mongo ( 
    'mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
                       $a = $client->annunciauto;
					   $b = $a->Auto;
					   $c =$b->find();
foreach($c as $doc){
       echo($doc['marca']);    
}
    

use Telegram\Bot\Api;

$telegram = new Api('323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg');


?>
