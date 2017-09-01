<!DOCTYPE html>
<html>
    <head>
        <title>AnnunciAuto</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'loggato.php' ?>
    </head>
    <body>
        
        <nav class="navbar navbar-default navbar-inverse " role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand active" href="index.php"><span class="glyphicon glyphicon-home" style="color: orange;"></span> Home</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                        if ($_SESSION["email"] == null) {
                            ?>
                            <li><a href="contatti.html">Contatti</a></li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        <?php } else { ?>
                            <li><a href="areaPersonale.php">Area Personale</a></li>
                            <li><a href="contatti.html">Contatti</a></li>
                            </ul>
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                            <?php } ?>

                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                            if ($_SESSION["email"] == null) {
                                ?>
                                <li><p class="navbar-text">Non hai account?</p></li>
                                <li><a href="registrazione.html">Registrati</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                                    <ul id="login-dp" class="dropdown-menu">
                                        <li>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Login
                                                    <form class="form" role="form" method="get" action="login.php" accept-charset="UTF-8" id="login-nav">
                                                        <div class="form-group">
                                                            <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                            <input value="<?php echo $_COOKIE["loggato"]?>" type="text" name="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                            <input type="password" name="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required>
                                                            <div class="help-block text-right"><a href="">Hai dimenticato password ?</a></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li><p class="navbar-text" style="color: orange;">Benvenuto <?php echo ucfirst($_SESSION["nome"]); ?>!  </p></li>
                                <li><a href="destroy_session.php" style="color: red;">Logout</a></li>                  
                            <?php } ?>
                        </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
    </body>
</html>
