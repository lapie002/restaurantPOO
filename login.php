<?php

// On enregistre notre autoload.
function chargerClasse($classname)
{
  require 'models/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');

session_start();

$db = Db::getInstance();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// On émet une alerte à chaque fois qu'une requête a échoué.

$adminsManager = new AdminsManager($db);

if(isset($_POST['email']) && isset($_POST['password']))
{

    $email = $_POST['email'];
    $pwd = $_POST['password'];

    $admin = $adminsManager->getAdmin($email,$pwd);

    if($admin==false)
    {
      header('Location: http://localhost/restaurantPOO/login.php');
    }
    else
    {
    	$_SESSION['nom']    = $admin->getNom();
      $_SESSION['prenom'] = $admin->getPrenom();
      $_SESSION['login']  = "OK";

      header('Location: http://localhost/restaurantPOO/showplats.php');
    }
}
?>


<?php
  //vue login.html content
	include "frontoffice/header.php";
	include "frontoffice/mainmenu.php";
?>

<section id="contact">
<div class="container">
    <div class="row text-center" >
        <div class="col-md-12">
                    <h1>Identifiez Vous</h1>
        </div>
    </div>
    <div class="row text-center pad-top" >
        <div class="col-md-4 col-md-offset-4">
            <div class="row ">
                  <form role="form" method="post" action="">
                      <div class="col-md-12 ">
                          <div class="form-group">
                              <label for="email">Email :</label>
                              <input type="email" name="email" id="email" class="form-control" required="required" placeholder="Enter your Email" />
                          </div>
                      </div>
                      <div class="col-md-12 ">
                          <div class="form-group">
                              <label for="password">Password :</label>
                              <input type="password" name="password" id="password" class="form-control" required="required" placeholder="Enter your Password" />
                          </div>
                      </div>
                      <div class="col-md-12">
                          <button type="submit" value="Login" class="btn btn-primary btn-lg">Login</button>
                     </div>
                  </form>
            </div>
        </div>
    </div>
</div>
</section>
<?php
	include "frontoffice/footer.php";
?>
