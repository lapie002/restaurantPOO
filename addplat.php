<?php
// remplacer par autoload :
//include_once 'connection.php';

// On enregistre notre autoload.
function chargerClasse($classname)
{
  require 'models/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');

// On appelle session_start() APRÈS avoir enregistré l'autoload.
session_start();

if (isset($_GET['deconnexion']))
{
  session_destroy();
  header('Location: .');
  exit();
}

$db = Db::getInstance();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$platsManager = new PlatsManager($db);

if(isset($_POST['creer']))
{
  // insertion de l image en base de donnees.
  // On peut valider le fichier et le stocker définitivement
  $fileTMP    = $_FILES['image']['tmp_name'];
  $fileNAME = $_FILES['image']['name'];
  $fileTYPE = $_FILES['image']['type'];
  // tableau des extensions
  $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

  if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
  {
    // Testons si l'extension est autorisée
    $infosfichier = pathinfo($_FILES['image']['name']);
    $extension_upload = $infosfichier['extension'];

    if (in_array($extension_upload, $extensions_autorisees))
    {
      //echo $file;
      move_uploaded_file($fileTMP, 'uploads/' . $fileNAME);
    }
  }


// On crée un nouveau plat.
$plat = new Plat(['nom' => $_POST['nom'], 'prix' => $_POST['prix'], 'image' => $fileNAME]);

  if ($platsManager->exists($plat->getNom()))
  {
    $message = "<div class='alert alert-danger fade in col-lg-6'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Erreur !</strong> ce plat existe déjà en base de données.</div>";
    unset($plat);
  }
  else
  {
    $messageInsertOk =$platsManager->add($plat);

    //gestion du message success | error pour insertion du plat dans la bdd - pour update avec image
    if($messageInsertOk){
         $message = "<div class='alert alert-success fade in col-lg-6'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Bravo !</strong> le plat a bien été ajouté en base de données.</div>";
    }
    else{
         $message = "<div class='alert alert-danger fade in col-lg-6'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Erreur !</strong> le plat n'a pas pu être ajouté en base de données.</div>";
    }
  }
}

if(isset($_SESSION['login'])){

  $nomAdminSession    = $_SESSION['nom'];
  $prenomAdminSession = $_SESSION['prenom'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


<!-- mon script de validation du formulaire -->
<!-- <script src="./js/validation.js"></script> -->
<script type="text/javascript">

/* soit on met dans des variable soit on recup avec un id: document.getElementById, soit avec le name: document.myForm.title.focus();*/
function validate()
{
    var nomPlat = document.getElementById('nom').value;
    var prixPlat = parseFloat(document.getElementById('prix').value);
    var imagePlat = document.getElementById('fileToUpload').value;

    if(nomPlat == "" || nomPlat == null)
    {
        alert( "Inscrivez un nom pour le plat !" );
        document.myFormAddPlat.nom.focus();
        return false;
     }
     if(isNaN(prixPlat) || prixPlat < 0 )
     {
         alert("Entrez uniquement des caractères numériques pour le prix du plat! (Entrée autorisée: 0 à 9)");
         document.myFormAddPlat.prix.focus();
         return false;
     }
     if( imagePlat == "" || imagePlat == null )
     {
         alert( "Entrez une image pour le plat!" );
         document.myFormAddPlat.fileToUpload.focus();
         return false;
    }

     return(true);
}
</script>

</head>

<body>
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#plats"><i class="fa fa-fw fa-cutlery"></i>Gestion Plats <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="plats" class="collapse">
                            <li>
                                <a href="http://localhost/restaurantPOO/addplat.php">Ajouter un Plat</a>
                            </li>
                            <li>
                                <a href="http://localhost/restaurantPOO/showplats.php">Lister les plats</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                      <a href="javascript:;" data-toggle="collapse" data-target="#menu"><i class="fa fa-fw fa-bars"></i>Gestion Menus <i class="fa fa-fw fa-caret-down"></i></a>
                      <ul id="menu" class="collapse">
                          <li>
                              <a href="http://localhost/restaurantPOO/addmenu.php">Ajouter un Menu</a>
                          </li>
                          <li>
                              <a href="http://localhost/restaurantPOO/showmenus.php">Lister les Menus</a>
                          </li>
                      </ul>
                    </li>
                    <li>
                      <a href="javascript:;" data-toggle="collapse" data-target="#admin"><i class="fa fa-fw fa-users"></i>Gestion Admins <i class="fa fa-fw fa-caret-down"></i></a>
                      <ul id="admin" class="collapse">
                          <li>
                              <a href="http://localhost/restaurantPOO/addadmin.php">Ajouter un Admin</a>
                          </li>
                          <li>
                              <a href="http://localhost/restaurantPOO/showadmins.php">Lister les Admins</a>
                          </li>
                      </ul>
                    </li>
                </ul>
            </div>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Back-Office Resto</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php //echo $first_name . ' ' . $last_name; ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php //echo $first_name . ' ' . $last_name; ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php //echo $first_name . ' ' . $last_name;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="http://localhost/restaurantPOO/showplats.php?deconnexion=true"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
<!-- /.navbar-collapse -->
</nav>


    <div id="wrapper">

                <div id="page-wrapper">

                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="page-header">
                                        Formulaire d'ajout d'un Plat
                                    </h1>
                                </div>
                                <div class="col-lg-12">
                                <?php
                                  //on affiche le message de suuccess | error d insertion
                                  if(isset($message)){echo $message;}
                                ?>
                                </div>
                            </div>
                            <!-- /.row    -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- onsubmit="return validate();" -->
                                    <!-- <form role="form" method="post" enctype="multipart/form-data" action="" name="myForm"> -->
                                    <form role="form" action="" method="post" name="myFormAddPlat" onsubmit="return validate();" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>le nom</label>
                                            <input class="form-control" type="text" name="nom" id="nom" />
                                        </div>

                                        <div class="form-group">
                                            <label>le prix</label>
                                            <input class="form-control" type="text" name="prix" id="prix" />
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">l'image</label>
                                            <input type="file" class="filestyle" name="image" id="fileToUpload" data-buttonText="Choisir">
                                        </div>
                                        <button type="submit" class="btn btn-default" name="creer">Envoyer</button>
                                        <!-- <input type="submit" value="Mise à jour plat" name="updatePlatId" /> -->
                                    </form>
                                </div>
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
</body>


<!-- jQuery -->
<script src="./js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="./js/bootstrap.min.js"></script>



</html>
<?php
//fin du test de session admin
}
else
{
  //on redirige vers la page de login
  header('Location: http://localhost/restaurantPOO/login.php');
}
?>
