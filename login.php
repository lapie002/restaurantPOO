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
                  <form method="post" action="login.php">
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
