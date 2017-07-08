<?php

class AdminsManager {

     private $_db;

     public function setDb(PDO $db)
     {
        $this->_db = $db;
     }

     public function __construct($db)
     {
       $this->setDb($db);
     }


     public function getAdmin($email,$password)
     {
        $password = md5($password);

        $q = $this->_db->query("select * from Admins where email = '$email' and password = '$password'");

        $donnees = $q->fetch(PDO::FETCH_ASSOC);


        if($donnees)
        {
          return new Admin($donnees);
        }
        else
        {
          return false;
        }
     }

}
