
<?php
$client = new MongoClient ( 
    'mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
                       $a = $client->annunciauto;
					   $b = $a->Auto;
					   $c =$b->find();
       var_dump(iterator_to_array($c));  
echo("ciao mondo");	   
    
?>
