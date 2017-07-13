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

// on recupere l id du menu a effacer avec le get dans l url
$idDuMenuAeffacer = $_GET['id'];
$idDuMenuAeffacer = (int) $idDuMenuAeffacer;

//on recupere le plat a effacer
$menuAeffacer = $menusManager->getMenu($idDuMenuAeffacer);

//on efface le plat avec la methode delete qui prend un param:l'objet plat a effacer
$resp = $menusManager->delete($menuAeffacer);


if($resp)
{
  $_SESSION['suppressionMenu'] = true;
}
else
{
  $_SESSION['suppressionMenu'] = false;
}

header('Location: http://localhost/restaurantPOO/showmenus.php');

?>
