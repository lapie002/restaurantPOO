<?php
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

//acces au MenusManager
$menusManager = new MenusManager($db);
//acces au PlatsManager
$platsManager = new PlatsManager($db);

// on recupere l id du plat a mettre a jour
$updateMenuId = $_GET['updateMenuId'];


if(isset($_POST['updateMenuId']))
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

    // #On update le menu avec image
    //les variable recuperer apres l envoie du formulaire : Objet Menu
    $nom = $_POST['nom'];
    $image = $fileNAME;
    $prix = $_POST['prix'];

    //le tableau contenant les id des plats selectionnes
    // faire un methode update de Composer avec id du menu en question
    //************************Gros du travail**********************************//
    //le tableau contenant les id des plats selectionnes
    $idplat = $_POST['tabIdPlats'];
    $lesPlatsDuMenu = [];

    if(isset($_POST['tabIdPlats']) && !empty($_POST['tabIdPlats']))
    {
          $Col_Array = $_POST['tabIdPlats'];

          foreach($Col_Array as $selectIdPlat)
          {
              //avec l'id du plat en question on stock un Objet Plat dans le tableau : $lesPlatsDuMenu[]
              $lesPlatsDuMenu[] = $platsManager->getPLat($selectIdPlat);
          }
    }
    //************************Gros du travail**********************************//

    // On crée un nouveau menu avec les variable recuperer eN POST
    $menu = new Menu(['id' => $updateMenuId,'nom' => $nom, 'prix' => $prix, 'image' => $image]);

    //on met a jour le menu
    $messageInsertOk = $menusManager->update($menu);

    //On supprime les relation plats-menu dans Composer
    $menusManager->suppressionCorrespondancePlatsMenu($updateMenuId);

    //On injecte les nouvelles dependance de relation plats-menu dans Composer
    $menusManager->faireCorrespondrePlatsMenu($updateMenuId,$lesPlatsDuMenu);


    if($messageInsertOk==true)
    {
      $message = "<div class='alert alert-success fade in col-lg-6'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Bravo !</strong> le menu a bien été mis à jour en base de données.</div>";
    }
    else
    {
      $message = "<div class='alert alert-danger fade in col-lg-6'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Erreur !</strong> le menu n'a pas pu être mis à jour en base de données.</div>";
    }

  }
  else {
    # code... Update sans image
    //...





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
    <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css"/>
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

    <!-- jQuery -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>

    <!-- Include the plugin's CSS and JS: -->
    <script type="text/javascript" src="./js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="./css/bootstrap-multiselect.css" type="text/css"/>

</head>

<body>

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<!--          <div class="collapse navbar-collapse navbar-ex1-collapse">
              <ul class="nav navbar-nav side-nav">
                  <li>
                      <a href="http://localhost/ProjetMVC/index.php?controller=products&action=index" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-edit"></i> Products<i class="fa fa-fw fa-caret-down"></i></a>
                      <ul id="demo" class="collapse">
                          <li>
                              <a href="#">Liste des Produits</a>
                          </li>
                          <li>
                              <a href="#">Ajouter Plat</a>
                              <a href="#">Ajouter Plat</a>
                              <a href="#">Ajouter Plat</a>
                              <a href="#">Ajouter Plat</a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>    -->
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
                            <a href="http://localhost/restaurantPOO/showmenus.php?deconnexion=true"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
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
                                        Formulaire de mise d'un Menu
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
                                    <form role="form" action="" method="post" enctype="multipart/form-data">
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

                                        <div class="form-group">
                                          <label class="control-label">les Plats</label></br>
                                          <select id="tabIdPlats" name="tabIdPlats[]" multiple="multiple">
                                              <?php
                                                $objPlats = $platsManager->selectAllPlats();
                                                // var_dump($objPlats);
                                                if(empty($objPlats))
                                                {
                                                  echo 'Pas de Plats Erreur !';
                                                }
                                                else{
                                                  foreach($objPlats as $objPlat) {
                                                    echo '<option value=' , $objPlat->getId() , '>' , $objPlat->getNom() ,'</option>';
                                                  }
                                                }
                                              ?>
                                          </select>
                                        </div>
                                        <button type="submit" class="btn btn-default" name="updateMenuId">Envoyer</button>
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

<!-- Initialize the js boostrap plugin: -->
<script src="./js/bootstrap-multiselect.js"></script>
<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabIdPlats').multiselect();
    });
</script>





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
