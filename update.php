<?php
include 'Telegram.php';
//include 'find.php';

error_reporting(E_ALL);  
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$callback_query = $telegram->Callback_Query();
$username = $result["message"]["chat"]["first_name"];

ob_start();
session_start();
var_dump($result);
$result1 = ob_get_clean();

$file = 'file.txt';
$current = file_get_contents($file);
$current .= $result1;
file_put_contents($file, $current);

$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

if($_SESSION["$h"] == 0){
    $_SESSION["$h"]++;
    $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
    $database = $connection->selectDB('annunciauto');
    $Marche_Modelli = $database->selectCollection('Marche_Modelli');
    $Regioni_Province = $database->selectCollection('Regioni_Province');
    $Alimentazione = $database->selectCollection('Alimentazione');
    $Auto = $database->selectCollection('Auto');
    $Utenti = $database->selectCollection('Utente');
    session_id($sid);
    session_start();
    preg_match_all('!\d+!', $text, $prezzo);
    for ($l = 0; $l <= count($prezzo); $l++) {
        for ($r = 0; $r <= $prezzo[$l][$r]; $r++) {
            if (intval($prezzo[$l][$r]) >= 1000) {
                $_SESSION["prezzo"] = strval($prezzo[$l][$r]);
            }
        }
    }
    $cursor_Marche = $Marche_Modelli->find();
    $i = 0;
    foreach ($cursor_Marche as $_marca) {
        $marche[$i] = $_marca['marca'];
        $cursor_Modelli = $Marche_Modelli->findOne(array("marca" => $marche[$i]));
        $_mod = $cursor_Modelli["modello"];
        if (strpos($text, $marche[$i]) !== false) {
            $_SESSION["marca"] = $marche[$i];
            $_SESSION["modello"] = NULL;
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
            $_SESSION["provincia"] = NULL;
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
    if (!isset($_SESSION["regione"]) || isset($_SESSION["provincia"]) || isset($_SESSION["regione"])) {
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
    if (!isset($_SESSION["marca"]) || isset($_SESSION["modello"]) || isset($_SESSION["marca"])) {
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
    
    $rangeQuery = array("marca" => ucfirst($_SESSION["marca"]),
    "modello" => ucfirst($_SESSION["modello"]),
    "regione" => ucfirst($_SESSION["regione"]),
    "provincia" => ucfirst($_SESSION["provincia"]),
    "alimentazione" => array_filter(array('$in' => unserialize(ucfirst($_SESSION["alimentazione"])))),
    "prezzo" => array_filter(array('$gt' => intval($_SESSION["prezzo"]), '$lt' => 100000)));
    $filter = array_filter($rangeQuery);
    $q = $Auto->find($filter);
    $_SESSION["count"] =  count(iterator_to_array($q));
}

$questions = setParametri();

if($callback_query["data"] === "new" || $text === "/nuova_ricerca"){
    session_destroy();
} elseif($callback_query["data"] === "skip"){
    $_SESSION["$i"]++;
} 

$option = array( 
    //First row
    array($telegram->buildInlineKeyBoardButton("Visualizza Auto", $url="https://annunciautobot.herokuapp.com/cerca.php?marca=".$_SESSION["marca"]."&modello=".$_SESSION["modello"]."&regione=".$_SESSION["regione"]."&provincia=".$_SESSION["provincia"]."&alimentazione".$_SESSION["alimentazione"]."=&prezzo=".$_SESSION["prezzo"], $callback_data="eseguiricerca", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url="", $callback_data1="skip", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Nuova Ricerca", $url="", $callback_data2="new", $switch_inline_query=true, $switch_inline_query_current_chat=null)));
$keyb = $telegram->buildInlineKeyBoard($option);

if ($text === "/start" || $text === "/nuova_ricerca" || $callback_query["data"] === "new" || (!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]) && !isset($_SESSION["prezzo"]))){
        $_SESSION["$i"]=0;
    $_SESSION["$h"]=0;
    $content = array('chat_id' => $chat_id, 'text' => "Ciao ".$username."! Inserisci l'auto da cercare");
} else {
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Parametri Ricerca:"."\nMarca:  ".ucfirst($_SESSION["marca"])."\nModello:  ".ucfirst($_SESSION["modello"])."\nRegione:  ".ucfirst($_SESSION["regione"])."\nProvincia:  ".ucfirst($_SESSION["provincia"])."\nAlimentazione:  ".ucfirst($_SESSION["alimentazione"])."\nPrezzo:  ".$_SESSION["prezzo"]."\n"."_._._._._._._._._._._"."\nLa tua ricerca ha prodotto ".$_SESSION['count']."  risultati"."\n"."_._._._._._._._._._._\n".$_SESSION['total_elements'][$_SESSION["$i"]].$_SESSION["$h"]);
}

$telegram->sendMessage($content);
?>
