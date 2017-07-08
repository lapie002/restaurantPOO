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

?>

<!DOCTYPE html>
<html>
  <head>
    <title>TP : Restaurant Villa Plaza</title>
    <meta charset="utf-8" />
  </head>
  <body>
    <p>Nombre de plats créés : <?= $platsManager->count() ?></p>
    <?php
    if (isset($message)) // On a un message à afficher ?
    {
      echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
    }
    ?>
        <p><a href="?deconnexion=1">Déconnexion</a></p>
        <fieldset>
          <legend>Les Plats </legend>
          <p>
          <?php

              $plats = $platsManager->selectAllPlats();

              if(empty($plats))
              {
                echo 'Pas de Plats !';
              }

              else
              {
                foreach ($plats as $unPlat)
                {
                  // www.befunky.com pour la retouche des images des plats
                  echo '<a href="updateplat.php?updatePlatId=', $unPlat->getId(), '">', htmlspecialchars($unPlat->getNom()), '</a> Prix du plat : ',htmlspecialchars($unPlat->getPrix()),' image du plat : <img src="uploads/', $unPlat->getImage(), '" alt="', $unPlat->getNom() ,'" style="width:32px;height:32px;" /><br />';
                }
              }
        ?>
        </p>
        </fieldset>
  </body>
</html>
