<?php

//include 'Telegram.php';

$connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
$database = $connection->selectDB('annunciauto');
$Marche_Modelli = $database->selectCollection('Marche_Modelli');
$Regioni_Province = $database->selectCollection('Regioni_Province');
$Alimentazione = $database->selectCollection('Alimentazione');
$Auto = $database->selectCollection('Auto');
$Utenti = $database->selectCollection('Utente');



// Set the bot TOKEN
//$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
//$telegram = new Telegram($bot_token);
//$chat_id = $telegram->ChatID();
//$result = $telegram->getData();
//$text = $result["message"]["text"];
//$text = trim($text);
//$text = strtolower($text);
$text = "fiorinoffffcampaniaiserniadiesel";

$cursor_Marche = $Marche_Modelli->find();

$i = 0;
foreach ($cursor_Marche as $_marca) {
    $marche[$i] = $_marca['marca'];
    $cursor_Modelli = $Marche_Modelli->findOne(array("marca" => $marche[$i]));
    $_mod = $cursor_Modelli["modello"];

    if (strpos($text, $marche[$i]) !== false) {
        $_SESSION["marca"] = $marche[$i];

        foreach ($_mod as $_modelli) {
            if (strpos($text, $_modelli) !== false) {
                $_SESSION["modello"] = $_modelli;
            }
        }
    }
    $i++;
}
$cursor_Regione = $Regioni_Province->find();

$j = 0;
foreach ($cursor_Regione as $_regione) {
    $regioni[$j] = $_regione['regione'];
    $cursor_Provincia = $Regioni_Province->findOne(array("regione" => $regioni[$j]));
    $_prov = $cursor_Provincia["provincia"];

    if (strpos($text, $regioni[$j]) !== false) {
        $_SESSION["regione"] = $regioni[$j];

        foreach ($_prov as $_provincia) {
            if (strpos($text, $_provincia) !== false) {
                $_SESSION["provincia"] = $_provincia;
            }
        }
    }
    $i++;
}

$cursor_Alimentazione = $Alimentazione->findOne();

$_ali = $cursor_Alimentazione["tipo"];


foreach ($_ali as $_alimentazione) {
    if (strpos($text, $_alimentazione) !== false) {
        $_SESSION["alimentazione"] = $_alimentazione;
    }
}

$z = 0;
if (!isset($_SESSION["regione"])) {
    foreach ($cursor_Regione as $regione) {
        $regioni[$z] = $regione['regione'];
        $cursor_Provincia = $Regioni_Province->findOne(array("regione" => $regioni[$z]));
        $prov = $cursor_Provincia["provincia"];
        foreach ($prov as $provincia) {
            if (strpos($text, $provincia) !== false) {
                $_SESSION["provincia"] = $provincia;
                $_SESSION["regione"] = $cursor_Provincia["regione"];

            }
        }
    }
}

$s = 0;
if (!isset($_SESSION["marca"])) {
    foreach ($cursor_Marche as $marca) {
        $marche[$s] = $marca['marca'];
        $cursor_Modelli = $Marche_Modelli->findOne(array("marca" => $marche[$s]));
        $mod = $cursor_Modelli["modello"];
        foreach ($mod as $_modello) {
            if (strpos($text, $_modello) !== false) {
                $_SESSION["modello"] = $_modello;
                $_SESSION["marca"] = $cursor_Modelli["marca"];

            }
        }
    }
}


echo($_SESSION["marca"]);
echo($_SESSION["modello"]);
echo($_SESSION["regione"]);
echo($_SESSION["provincia"]);
echo($_SESSION["alimentazione"]);

//if(!isset($_SESSION["marca"]) && isset(($_SESSION["modello"]))){
//}
//switch ($parametri) {
//    case "marca":
//        $_SESSION["marca"] = $marca;
//        break;
//    case "modello":
//        $_SESSION["modello"] = $modello;
//        break;
//    case "regione":
//        $_SESSION["regione"] = $regione;
//        break;
//    case "provincia":
//        $_SESSION["provincia"] = $provincia;
//        break;
//    case "alimentazione":
//        $_SESSION["alimentazione"] = $alimentazione;
//        break;
//}
?>
