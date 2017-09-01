<!DOCTYPE html>
<html>
    <head>

        <title>AnnunciAuto</title>
        <link href = "css/bootstrap.min.css" rel = "stylesheet">
        <link href = "css/Login.css" rel = "stylesheet">
        <link href = "css/filtri.css" rel = "stylesheet">

    </head>

    <body style="background:url(/img/cars3.jpg) fixed #2C1E00; background-size: 100% 100%">
        <!--Navigation -->
        <div id = "includedContent"></div>

        <!--Page Content -->
        <div class = "container">
            <div class = "row">

                <div class = "col-md-3">
                    <div id = "includedContent2"></div>
                </div>

                <div class = "col-md-9">
                    <div class = "row">

                        <?php							
						
                        $rangeQuery = array("marca" => ucfirst($_GET["marca"]),
                            "modello" => ucfirst($_GET["modello"]),
                            "regione" => ucfirst($_GET["regione"]),
                            "provincia" => ucfirst($_GET["provincia"]),
                            "alimentazione" => array_filter(array('$in' => unserialize(ucfirst($_GET["alimentazione"])))),
                            "prezzo" => array_filter(array('$gt' => intval($_GET["prezzo_min"]), '$lt' => intval($_GET["prezzo_max"]))));

                        $filter = array_filter($rangeQuery);

                        $p = intval($_GET['p']);
                        $ann_pag = 1;
                        $to_skip = $p * $ann_pag;
                        $id_auto = $_GET["id_auto"];

                        $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
                        $db = $connection->selectDB('annunciauto');
                        $collection = $db->selectCollection('Auto');
                        $a = null;
                        $a = $collection->find($filter);
                        $num_pag = ceil(($a->count()) / $ann_pag);
                        $q = $collection->findOne($filter);
						$Utente = $connection->$db->Utenti;
						$pref = $_POST["addpref"];

                        if (isset($_POST["addpref"])) {
							
							$query1 = $Utente->findOne(array("email" => $_SESSION["email"]), array("preferiti[]" => $pref));

                            foreach ($query1['preferiti[]'] as $auto) {
                                if ($auto == $pref) {
                                    $trovato = 1;
                                    break;
                                } else {
                                    $trovato = 0;
                                }

								}
                            if ($trovato == 0) {
                                $newdata = array('$push' => array("preferiti[]" => $pref));
                                $Utente->update(array("email" => $_SESSION["email"]), $newdata);
                            } else if ($trovato == 1) {
                                $Utente->update(array("email" => $_SESSION["email"]), array('$pull' => array("preferiti[]" => $pref)));
                            }
                        }

                        if ($q != null) {
                            foreach ($a as $doc) {
                                $immagin = $doc["immagine"];
                                ?>
                                <div style="background-color: rgba(21,21,21,0.7); color:#FFF;" class = "col-sm-4 col-lg-4 col-md-4">
                                <div style="border:1px solid white; border-radius:4px; margin-top:20px; margin-bottom:20px; padding:4px;">
                                    <div align="center"><a href="annuncio.php?id_auto=<?php echo ($doc["_id"]); ?>"><img src = "<?php echo ($immagin[0]); ?>" alt = "" width="250" height="200"></a></div>
                                            <div class = "caption">
                                                <h4 class = "pull-right"><?php echo number_format(($doc["prezzo"]), 0, '', '.'); ?>€</h4>
                                                <h4><a style="color: orange;" href="annuncio.php?id_auto=<?php echo ($doc["_id"]); ?>"><?php echo ucfirst(($doc["marca"])); ?>&nbsp;<?php echo ($doc["modello"]); ?></a>
                                                </h4>
                                                <p><i class="glyphicon glyphicon-map-marker"></i><?php echo ($doc["regione"]); ?>, <?php echo ($doc["provincia"]); ?></p>
                                            </div>
                                            <div class = "ratings">
                                                <p class = "pull-right">15 reviews</p>
                                                <form method="POST" action="cerca.php" id="preferiti">
                                                    <input name="addpref" id="addpref" type="hidden" value="<?php echo($doc['_id']); ?>">
                                                  <?php
                                            $preferiti = $Utente->findOne(array("email" => $_SESSION["email"]), array("preferiti[]" => $doc['_id']));
                                            foreach ($preferiti['preferiti[]'] as $auto) {
                                                if ($auto == $doc['_id']) {
                                                    $trovato = 1;
                                                    break;
                                                } else {
                                                    $trovato = 0;
                                                }
                                            }
                                            if ($trovato == 0 || $preferiti['preferiti[]'] == null) {
                                                ?>
                                                <span onclick="javascript:this.parentNode.submit()" id="star"><img title="Aggiungi ai Preferiti" src = "/AnnunciAuto/imgprof/star_plus.png"></span>
                                            <?php } else { ?>
                                                <span onclick="javascript:this.parentNode.submit()" id="star"><img title="Rimuovi dai Preferiti" src = "/AnnunciAuto/imgprof/star_minus.png"></span>
                                            <?php } ?>
                                                </form>
                                            </div>
                                    </div>
                                </div>
                            <?php }
                        } else { ?>
                            <h2 style="color: red" align="center">La ricerca non ha prodotto risultati!</h2>
<?php } ?>
                    </div>
                    <div align="center">
                            <form action="cerca.php" id="skip" method="post"> 

                                <ul class="pagination">

                                    <?php
                                    $p = $_GET['p'];
                                    if ($p > 0) {
                                        ?>
                                        <li><a href="https://annunciautobot.herokuapp.com/cerca.phpcerca.php?p=<?php echo ($p - 1); ?>">&laquo;</a></li>
                                        <?php
                                    }
                                    if ($num_pag > 0) {
                                        for ($i = 0; $i < ($num_pag); $i++) {
                                            ?>
                                            <li><a href="https://annunciautobot.herokuapp.com/cerca.php?p=<?php echo ($i); ?>"><?php echo ($i + 1); ?></a></li>
                                            <?php
                                        }
                                    }
                                    if ($p != ($num_pag - 1)) {
                                        ?>         
                                        <li><a href="https://annunciautobot.herokuapp.com/cerca.php?p=<?php echo ($p + 1); ?>">&raquo;</a></li>
                                    <?php } ?>
                                </ul>

                            </form>

                        </div>
                </div>

            </div>

        </div>
        <!--/.container -->

        <div class = "container">

            <hr>

            <!--Footer -->
            <footer>
                <div class = "row">
                    <div class = "col-lg-12">
                        <p>Copyright &copy;
                            Your Website 2014</p>
                    </div>
                </div>
            </footer>

        </div>
        <!--/.container -->

        <!--jQuery -->
        <script src = "js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <script src="js/function.js"></script>
        <script src="js/navbar_inactive.js"></script>
        <script src="js/filtri.js"></script>

        <script type="text/javascript">
            function hideLogout() {
                document.getElementById('logout').style.visibility = 'hidden';
            }
            function hideLogin() {
                document.getElementById('login').style.visibility = 'hidden';
            }
        </script>
    </body>
</html>
