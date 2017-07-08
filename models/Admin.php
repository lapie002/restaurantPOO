<?php

class Admin
{
  private $_id;
  private $_nom;
  private $_prenom;
  private $_email;
  private $_password;

  /* fonction hydratation des donnees provenant de la BDD */
  public function hydrate(array $donnees)
  {
      foreach($donnees as $key => $value)
      {
        // On récupère le nom du setter correspondant à l'attribut.
        $method = 'set'.ucfirst($key);

        // Si le setter correspondant existe.
        if(method_exists($this, $method))
        {
          // On appelle le setter.
          $this->$method($value);
        }
      }
   }

   /* le constructeur de l'objet Personnage */
   public function __construct(array $donnees){

         $this->hydrate($donnees);
   }

   /* SETTERS */
   public function setId($id)
   {
      # on pasre la valeur de l'id en INT
      $id = (int) $id;
      // On vérifie que l id superieur à zero
      if ($id > 0)
      {
        $this->_id = $id;
      }
   }

   public function setNom($nom)
   {
    # on affecte le nom a l'objet si $nom est une chaine de caracteres
    if(is_string($nom))
    {
      $this->_nom = $nom;
    }
   }

   public function setPrenom($prenom)
   {
     # on affecte le nom a l'objet si $nom est une chaine de caracteres
     if(is_string($prenom))
     {
       $this->_prenom = $prenom;
     }
   }

   public function setEmail($email)
   {
    # on affecte le nom a l'objet si $nom est une chaine de caracteres
    if(is_string($email))
    {
      $this->_email = $email;
    }
   }

   public function setPassword($password)
   {
    # on affecte le nom a l'objet si $nom est une chaine de caracteres
    if(is_string($password))
    {
      $this->_password = $password;
    }
   }



   /* GETTERS */
   public function getId()
   {
    # retourne l'id de l'objet en question
    return $this->_id;
   }

   public function getNom()
   {
    # retourne le nom de l'objet en question
    return $this->_nom;
   }

   public function getPrenom()
   {
    # retourne le prenom de l'objet en question
    return $this->_prenom;
   }

   public function getEmail()
   {
    # retourne l'image de l'objet en question
    return $this->_email;
   }

   public function getPassword()
   {
    # retourne l'image de l'objet en question
    return $this->_password;
   }
}
