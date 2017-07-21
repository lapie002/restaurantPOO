<?php
// On enregistre notre autoload.
function chargerClasse($classname)
{
  require 'models/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');

// On appelle session_start() APRÈS avoir enregistré l'autoload.
session_start();

if(isset($_GET['deconnexion']))
{
  session_destroy();
  header('Location: http://localhost/restaurantPOO/login.php');
  exit();
}

$db = Db::getInstance();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$menusManager = new MenusManager($db);


//vue menu.html content
include "frontoffice/header.php";
include "frontoffice/mainmenu.php";
?>
<!-- Page Content -->
<section>
<div class="container">
  <div class="row text-center">
      <div class="col-md-12">
          <h1>Les Menus</h1>
      </div>
  </div>
        <div class="row">
            <div class="col-md-12">
              <?php
              //on recupere touts les plats de la bdd :
              $menus = $menusManager->selectAllMenus();

              foreach($menus as $menu)
              {
              // num me sert pour la fenetre modale
              $num = $menu->getId();
              $img = $menu->getImage();
              ?>
              <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                  <a href="http://localhost/restaurantPOO/menuitem.php?id=<?=$num;?>"><img src="uploads/<?=$img?>" alt=""></a>
                    <div class="caption">
                      <h4 class="pull-right"><?=$menu->getPrix();?>€</h4>
                        <h4><a href="http://localhost/restaurantPOO/menuitem.php?id=<?=$num;?>"><?=$menu->getNom();?></a></h4>
                          <p>Description du menu : orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                          <!--
                          <div class="col-sm-12 col-lg-12 col-md-12">
                            <div class="pull-right">
                                  <a class="btn btn-primary" target="_blank" href="#">Ajouter</a>
                            </div>
                          </div>
                        -->
                    </div>
                    <div class="checkout">
                          <p><a class="btn btn-info mybouton" target="_blank" href="#">Ajouter</a></p>
                    </div>
                  </div>
               </div>
              <?php
              }
              ?>

            </div>
        </div>
</div>
</section>
<!-- /.container -->
<?php
	include "frontoffice/footer.php";
?>
