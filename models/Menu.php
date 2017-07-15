<?php

class Menu
{

  private $_id;
  private $_nom;
  private $_prix;
  private $_image;

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

  //Set prix du menu
  public function setPrix($prix)
  {
     # on met la valeur du prix à zero
     $prix = (float) $prix;

     // On vérifie que l id superieur à zero
     $this->_prix = $prix;

  }

  //Set image du menu
  public function setImage($image)
  {
   # on affecte le nom a l'objet si $nom est une chaine de caracteres
   if(is_string($image))
   {
     $this->_image = $image;
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

   public function getPrix()
   {
    # retourne le prix de l'objet en question
    return $this->_prix;
   }

   public function getImage()
   {
    # retourne l'image de l'objet en question
    return $this->_image;
   }
}
