<?php

//$text1 = "fiorinoffffcampaniaiserniadiesel";

//Parametri($text1);
ini_set('session.save_handler','redis');
    ini_set('session.save_path',"tcp://ec2-34-252-182-25.eu-west-1.compute.amazonaws.com:13419?auth=p05ebe76c4296539328f91efde721822040f16c9e599be903602914d21c27a55e");
  session_start();

function Parametri($text) {
    $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
    $database = $connection->selectDB('annunciauto');
    $Marche_Modelli = $database->selectCollection('Marche_Modelli');
    $Regioni_Province = $database->selectCollection('Regioni_Province');
    $Alimentazione = $database->selectCollection('Alimentazione');
    $Auto = $database->selectCollection('Auto');
    $Utenti = $database->selectCollection('Utente');





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
}

function setParametri() {
    $options = array();
    if (!isset($_SESSION["marca"])) {
        array_push($options, "Marca");
    }

    if (!isset($_SESSION["modello"])) {
        array_push($options, "Modello");
    }

    if (!isset($_SESSION["regione"])) {
        array_push($options, "Regione");
    }

    if (!isset($_SESSION["provincia"])) {
        array_push($options, "Provincia");
    }

    if (!isset($_SESSION["alimentazione"])) {
        array_push($options, "Alimentazione");
    }
    return $options;
}

echo($_SESSION["marca"]);
echo($_SESSION["modello"]);
echo($_SESSION["regione"]);
echo($_SESSION["provincia"]);
echo($_SESSION["alimentazione"]);

?>
