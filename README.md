<?php include 'loggato.php' ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>AnnunciAuto</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
        <link href="css/Login.css" rel="stylesheet">

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

    </head>
    <body style="background:url(/AnnunciAuto/imgprof/cars3.jpg) fixed #2C1E00; background-size: 100% 100%">
        <div id="includedContent"></div>
        <div class="container">
        <div align="center">
            <div align="center" style="background-color: rgba(21,21,21,0.7); padding: 1px; width: 60%; float: center;">
                <h1 align="center" style="color: orange;">Area Personale</h1>
            </div><br><br>
        </div>
            <div class = "col-md-5">
                <div style="background-color: rgba(21,21,21,0.7);"  align="center"><br><br>
                    <div>
                        <img src="<?php echo ($_SESSION["img"]); ?>" alt="" width="250" class="img-rounded "/>
                    </div><br>
                    <div>
                        <h4 style="color: orange;"><?php echo ucfirst($_SESSION["nome"]); ?></h4>
                        <small> <?php echo ($_SESSION["indirizzo"]) ?> </small>
                        <p>
                            <i class="glyphicon glyphicon-envelope"></i> <?php echo ($_SESSION["email"]); ?>
                            <br />
                            <i class="glyphicon glyphicon-phone"></i> <?php echo ($_SESSION["telefono"]); ?>
                            <br />
                            <i class="glyphicon glyphicon-gift"></i> <?php echo ($_SESSION["data"]); ?>
                        </p>
                    </div>
                </div>
            </div>  
            <div class = "col-md-7">
                <!--                    <div class = "col-md-1">
                                    </div>-->
                <div  class = "col-md-12">
                    <div style="background-color: rgba(21,21,21,0.7);" class = "panel panel-danger">
                        <div class = "panel-heading" style="background-color: #222;">
                            <button onclick="change_ann()" type="button" class="btn btn-danger" style="color: white; margin-top: 4px;"><span class="glyphicon glyphicon-th-list"></span>I Tuoi Annunci</button>
                            <button onclick="change_pref()" type="button" class="btn btn-danger" style="color: white; margin-top: 4px;"><span class="glyphicon glyphicon-star"></span>Preferiti</button>
                            <button type="button" class="btn btn-danger" style="float:right; color: white; margin-top: 4px;" onclick="window.location = 'http://localhost/AnnunciAuto/inserimento_annuncio.html'"  href="inserimento_annuncio.html"><span class="glyphicon glyphicon-plus"></span>Inserisci</button>
                        </div>
                        <div class = "panel-body" style="width:100%; height:400px; overflow-y:scroll;">
                            <ul class = "list-group" id="annunci">
                                <h4 style="color: orange;" align="center">I TUOI ANNUNCI:</h4><br>
                                <?php
                                $connection = new MongoClient();
                                $db = $connection->AnnunciAuto;
                                $collection = $connection->$db->Auto;
                                $id_auto = $_GET["id_auto"];

                                $doc = array(
                                    "email" => $_SESSION["email"]);

                                $a = null;
                                $a = $collection->find($doc);
                                $q = $collection->findOne($doc);
                                if ($q == null) {
                                    ?>
                                    changepref();
                                    <li style="background-color: rgba(21,21,21,0.1);" class = "list-group-item">
                                        <h4 align="center" style="color: red">Non hai inserito nessun annuncio</h4>
                                    </li> 
                                    <?php
                                } else {
                                    foreach ($a as $doc) {
                                        $immagin = $doc["immagine"];
                                        ?>
                                        <li style="background-color: rgba(21,21,21,0.1);" class = "list-group-item">
                                            <form method="POST" action="remove_ann.php" id="remove" name="preferiti">
                                                <input name="remove" id="remove" type="hidden" value="<?php echo($doc['_id']); ?>">
                                                <div onclick="javascript:this.parentNode.submit()" id="remove" align="right"><span style="color:red" class="glyphicon glyphicon-remove" title="Rimuovi annuncio"></span></div>
                                            </form>
                                            <div align="center"><a href="annuncio.php?id_auto=<?php echo ($doc["_id"]); ?>"><img src = "<?php echo ($immagin[0]); ?>" alt = "" width="40%" height="40%"></a></div>
                                                    <div class = "caption">
                                                        <h4 class = "pull-right" style="color: white;"><?php echo number_format(($doc["prezzo"]), 0, '', '.'); ?>€</h4>
                                                        <h4><p><a style="color: orange;" href="annuncio.php?id_auto=<?php echo ($doc["_id"]); ?>"><?php echo ucfirst(($doc["marca"])); ?>&nbsp;<?php echo ($doc["modello"]); ?></a></p></h4>
                                                    </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </ul>
                                            <ul class = "list-group" id="preferiti">
                                                <small align="center">PREFERITI</small><br>
                                                <?php
                                                $pref = $_POST["addpref"];
                                                $collection1 = $connection->$db->Utenti;
                                                
                                                if (isset($_POST["addpref"])) {
                                                    $collection1->update(array("email" => $_SESSION["email"]), array('$pull' => array("preferiti[]" => $pref)));
                                                }

                                                $query2 = $collection1->findOne(array("email" => $_SESSION["email"]));
                                                
                                                if ($query2['preferiti[]'] != null) {
                                                    foreach ($query2['preferiti[]'] as $auto) {
//                                                    var_dump($auto);
                                                        $query = $collection->findOne(array("_id" => new MongoId($auto)));
                                                        $immagin = $query["immagine"];
//                                                    var_dump(ite$query));
                                                        ?>
                                                        <li style="background-color: rgba(21,21,21,0.1);" class = "list-group-item">
                                                            <form method="POST" action="" id="addpref" name="preferiti">
                                                                <input name="addpref" id="addpref" type="hidden" value="<?php echo($query['_id']); ?>">
                                                                <div onclick="javascript:this.parentNode.submit()" id="addpref" align="right"><span><img title="Rimuovi dai Preferiti" src = "/AnnunciAuto/imgprof/star_minus.png"></span></div>
                                                            </form>
                                                            <div align="center"><a href="annuncio.php?id_auto=<?php echo ($query["_id"]); ?>"><img src = "<?php echo ($immagin[0]); ?>" alt = "" width="40%" height="40%"></div>
                                                                    <div class = "caption">
                                                                        <h4 class = "pull-right"><?php echo number_format(($query["prezzo"]), 0, '', '.'); ?>€</h4>
                                                                        <h4><?php echo ucfirst(($query["marca"])); ?>&nbsp;<?php echo ($query["modello"]); ?></a>
                                                                        </h4>
                                                                    </div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <li style="background-color: rgba(21,21,21,0.1);" class = "list-group-item">
                                                                    <h4 align="center" style="color: red">La lista Preferiti &egrave; vuota</h4>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                            </ul> 
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>

                                                    </div>

                                                    <style>
                                                        .wrap
                                                        {
                                                            padding-top: 30px;
                                                        }

                                                        .glyphicon
                                                        {
                                                            margin-bottom: 10px;
                                                            margin-right: 10px;
                                                        }

                                                        small
                                                        {
                                                            display: block;
                                                            color: #888;
                                                        }

                                                        .well
                                                        {
                                                            border: 1px solid blue;
                                                        }
                                                    </style>

                                                    <!-- Profile Card - END -->
                                                    </div>
                                                    <script src="js/navbar_inactive.js"></script>
                                                    <script type="text/javascript">
                                                            document.getElementById('preferiti').style.display = "none";
                                                            function change_pref() {
                                                                document.getElementById('preferiti').style.display = "block";
                                                                document.getElementById('annunci').style.display = "none";
                                                            }
                                                            function change_ann() {
                                                                document.getElementById('annunci').style.display = "block";
                                                                document.getElementById('preferiti').style.display = "none";
                                                            }
                                                    </script>
                                                    </body>
                                                    </html>
