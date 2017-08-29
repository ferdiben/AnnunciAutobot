<?php

//$text1 = "fiorinoffffcampaniaiserniadiesel";

//Parametri($text1);

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

echo($_SESSION["marca"]);
echo($_SESSION["modello"]);
echo($_SESSION["regione"]);
echo($_SESSION["provincia"]);
echo($_SESSION["alimentazione"]);

?>