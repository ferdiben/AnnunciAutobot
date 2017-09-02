<!DOCTYPE html>
<html>
    <head>
        <title>AnnunciAuto</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/Login.css" rel="stylesheet">
        <?php include'loggato.php' ?> 
    </head>
    <body style="background:url(/AnnunciAuto/imgprof/cars3.jpg) fixed #2C1E00; background-size: 100% 100%">
        <div id="includedContent"></div>
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id = "includedContent2"></div>
                </div>
                <div class="col-md-9">

                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <?php
                        $id = $_GET["id_auto"];

                        $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
                        $db = $connection->selectDB('annunciauto');
                        $collection = $db->selectCollection('Auto');
                       


                        $annuncio = $collection->find(array('_id' => new MongoId($id)));
					

                        foreach ($annuncio as $auto) {
                            foreach ($auto['immagine'] as $img[]) {
                                
                            }
                        }
                        ?>

                        <ol class="carousel-indicators">
                            <?php if ($img[0] != null) { ?>
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <?php } ?>
                            <?php if ($img[1] != null) { ?>
                                <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                            <?php } ?>
                            <?php if ($img[2] != null) { ?>
                                <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                            <?php } ?>
                            <?php if ($img[3] != null) { ?>
                                <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
                            <?php } ?>
                            <?php if ($img[4] != null) { ?>
                                <li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
                            <?php } ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php if ($img[0] != null) { ?>
                            <div class="item active" align="center"><div>
                                    <img class="img-responsive" style="max-height: 400px;" alt="First slide"  src="<?php echo ($img[0]); ?>">
                                </div></div>
                            <?php } ?>
                            <?php if ($img[1] != null) { ?>
                                <div class="item" align="center"><div>
                                    <img class="img-responsive" style="max-height: 400px;" alt="Second slide" src="<?php echo ($img[1]); ?>">
                                </div></div>
                            <?php } ?>
                            <?php if ($img[2] != null) { ?>
                                <div class="item" align="center"><div>
                                    <img class="img-responsive" style="max-height: 400px;" alt="Third slide" src="<?php echo ($img[2]); ?>">
                                </div></div>
                            <?php } ?>
                            <?php if ($img[3] != null) { ?>
                                <div class="item" align="center"><div>
                                    <img class="img-responsive" style="max-height: 400px;" alt="Third slide" src="<?php echo ($img[3]); ?>">
                                </div></div>
                            <?php } ?>
                            <?php if ($img[4] != null) { ?>
                                <div class="item" align="center"><div>
                                    <img class="img-responsive" style="max-height: 400px;" alt="Third slide" src="<?php echo ($img[4]); ?>">
                                </div></div>
                            <?php } ?>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>

                    <div class="caption-full" style="background-color: rgba(21,21,21,0.7); padding: 5px;">
                        <h3 class="pull-right" style="color: white;"><?php echo ($auto["prezzo"]); ?>€</h3>
                        <h3 style="color: orange;"><?php echo ucfirst(($auto["marca"])); ?>&nbsp;<?php echo ($auto["modello"]); ?>
                        </h3>
                        <h4 style="color: white;">Alimentazione: <?php echo ucfirst(($auto["alimentazione"])); ?></h4>
                        <h4 style="color: white;"><i class="glyphicon glyphicon-map-marker"></i>&nbsp;<?php echo ($auto["provincia"]); ?>, <?php echo ($auto["regione"]); ?></h4>
                        <h4 style="color: white;">Descrizione: <?php echo ($auto["descrizione"]); ?></h4>
                        <button class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#myModal">
                            CONTATTI

                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <div class="container">
            <hr>
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; Your Website 2014</p>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.container -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/function.js"></script>
        <script src="js/navbar_inactive.js"></script>
        <script src="js/filtri.js"></script>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<?php 
                        $utente = $connection->$db->Utenti;
                        $utente = $utente->findOne(array('email' => $auto["email"]));
                        $utente_telefono = $utente["telefono"];
                        $utente_email = $utente["email"];
						$utente_img = $utente["imgutente"];
						$utente_nome = $utente["nome utente"]?>
						
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                       <div> <img src = "<?php echo ($utente_img); ?>" class = "img-circle" height= "50px">&nbsp&nbsp&nbsp <b style="font-size: 25px"><?php echo ($utente_nome); ?></b></div>
                        
						
                        <h3>Numero: <?php echo ($utente_telefono); ?></h3>
                        <hr>
                        <h3>Email: <?php echo ($utente_email); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
