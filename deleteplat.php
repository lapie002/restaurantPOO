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

$platsManager = new PlatsManager($db);

// on recupere l id du plat a effacer avec le get dans l url
$idDuPlatAeffacer = $_GET['id'];

//on recupere le plat a effacer
$platAeffacer = $platsManager->getPLat($idDuPlatAeffacer);

//on efface le plat avec la methode delete qui prend un param:l'objet plat a effacer
$resp = $platsManager->delete($platAeffacer);

// il faudra rajouter une methode de suppressionPlat - avec une suppression de la ligne dans idPlat,idMenu de Composer
//...


if($resp)
{
  $_SESSION['suppressionPlat'] = true;
}
else
{
  $_SESSION['suppressionPlat'] = false;
}

header('Location: http://localhost/restaurantPOO/showplats.php');

?>
