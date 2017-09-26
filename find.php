<?php

function Parametri($text, $sid) {
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

function setParametri() {
    $_SESSION['total_elements'] = array();
    if (!isset($_SESSION["marca"])) {
        array_push($_SESSION['total_elements'], "Vuoi inserire la Marca?");
        array_push($_SESSION['total_elements'], "Che marca vuoi cercare?");
    }

    if (!isset($_SESSION["modello"])) {
        array_push($_SESSION['total_elements'], "Vuoi inserire il Modello?");
        array_push($_SESSION['total_elements'], "Che modello vuoi cercare?");

    }

    if (!isset($_SESSION["regione"])) {
        array_push($_SESSION['total_elements'], "Vuoi inserire la Regione?");
        array_push($_SESSION['total_elements'], "In che regione vuoi cercare?");
    }

    if (!isset($_SESSION["provincia"])) {
        array_push($_SESSION['total_elements'], "Vuoi inserire la Provincia?");
        array_push($_SESSION['total_elements'], "In che provincia vuoi cercare?");
    }

    if (!isset($_SESSION["alimentazione"])) {
        array_push($_SESSION['total_elements'], "Vuoi inserire l'Alimentazione?");
        array_push($_SESSION['total_elements'], "Con quale alimentazione vuoi cercare?")
    }

    if (!isset($_SESSION["prezzo"])) {
        array_push($_SESSION['total_elements'], "Vuoi inserire il prezzo?");
        array_push($_SESSION['total_elements'], "Da quale prezzo vuoi partire?")
    }
    return $_SESSION['total_elements'];
}

echo($_SESSION["marca"]);
echo($_SESSION["modello"]);
echo($_SESSION["regione"]);
echo($_SESSION["provincia"]);
echo($_SESSION["alimentazione"]);
?>
