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

if (isset($_POST['creer']))
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
    $message = 'Le nom du plat est déjà pris.';
    unset($plat);
  }
  else
  {
    $platsManager->add($plat);
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>TP : Restaurant Villa Plaza</title>
    <meta charset="utf-8" />
  </head>
  <body>
    <p>Créer un plat  : </p>

  <form action="" method="post" enctype="multipart/form-data">
  <p>
    Nom : <input type="text"  name="nom" maxlength="50" />
  </p>
  <p>
    Prix : <input type="text" name="prix" />
  </p>
  <p>
    Image : <input type="file" class="filestyle" name="image" id="fileToUpload" data-buttonText="Choisir">
  </p>
  <p>
    <input type="submit" value="Créer un plat" name="creer" />
  </p>
</form>
</body>
</html>
