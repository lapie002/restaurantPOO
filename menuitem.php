<?php
// On enregistre notre autoload.
function chargerClasse($classname)
{
  require 'models/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');

// On appelle session_start() APRÈS avoir enregistré l'autoload.
session_start();

$db = Db::getInstance();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$menusManager = new MenusManager($db);
// $platsManager = new platsManager($db);

// on recupere l id du menu a effacer avec le get dans l url
$idDuMenu = $_GET['id'];
$idDuMenu = (int) $idDuMenu;

//vue menuitem.html content
include "frontoffice/header.php";
include "frontoffice/mainmenu.php";





//on recupere le menu avce son Id
$menu = $menusManager->getMenu($idDuMenu);

//image du menu
$imgMenu = $menu->getImage();

//on recupere touts les plats correspondant au Menu :
$plats = $menusManager->selectAllPLatsMenus($idDuMenu);
?>
<!-- Page Content -->
<section>

<div class="container">

  <div class="row text-center">
      <div class="col-md-12">
          <h1>les plats constituant le <?=$menu->getNom();?></h1>
      </div>
  </div>



<!--Row For Image and Short Description-->
<div class="row">

<div class="col-md-12">

  <div class="col-md-9">

    <?php
    foreach($plats as $plat)
    {
      $num = $menu->getId();
      $img = $plat->getImage();
    ?>

    <div class="col-sm-4 col-lg-4 col-md-4">
      <div class="thumbnail">
        <a href="#"><img src="uploads/<?=$img;?>" alt=""></a>
          <div class="caption">
              <h4 class="text-center"><a href="#"><?=$plat->getNom();?></a></h4>
                <p>Description : orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
        </div>
     </div>

    <?php
    }
    ?>

     </div><!--Row col-9 des plats-->


     <div class="col-md-3">
       <div class="thumbnail">
         <a href="#"><img src="uploads/<?=$imgMenu?>" alt=""></a>
           <div class="caption">
             <h4 class="pull-right"><?=$menu->getPrix();?>€</h4>
               <h4><a href="#"><?=$menu->getNom();?></a></h4>
                 <p>Description du menu : orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
           </div>
           <div class="checkout">
                 <p><a class="btn btn-info mybouton" target="_blank" href="#">Ajouter</a></p>
           </div>
         </div>
     </div>

</div>
</div><!--Row For Image and Short Description-->
</div><!--Container-->

</section>
<!-- /.container -->
<?php
	include "frontoffice/footer.php";
?>
