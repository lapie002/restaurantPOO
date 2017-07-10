<?php

class PlatsManager {

     private $_db;

     public function setDb(PDO $db)
     {
        $this->_db = $db;
     }

     public function __construct($db)
     {
       $this->setDb($db);
     }

     public function add(Plat $plat)
     {
       // Préparation de la requête d'insertion.
       // Assignation des valeurs pour le plat.
       // Exécution de la requête.

      $q = $this->_db->prepare('INSERT INTO Plats(NOM,PRIX,IMAGE) VALUES(:nom,:prix,:image)');

      $q->bindValue(':nom',$plat->getNom());
      $q->bindValue(':prix',$plat->getPrix());
      $q->bindValue(':image',$plat->getImage());

      //$q->bindValue(':nom',$plat->getNom(),PDO::PARAM_STR);
      // $q->bindValue(':prix',0.0);
      // $q->bindValue(':image','hello.jpg');

      // Exécution de la requête.
      $reponse = $q->execute();

     // $q = bindValue(':degats',$perso->_degats,PDO::PARAM_INT);
     //  $q = bindValue(':degats',0);


       // Hydratation du plat passé en paramètre avec assignation de son identifiant et du prix initial.
       $plat->hydrate(
         ['id'    => $this->_db->lastInsertId(),
         'nom'    => $plat->getNom(),
         'prix'   => $plat->getPrix()]
       );

       return $reponse;

     }

     public function count()
     {
       // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
       $q = $this->_db->query('SELECT count(*) FROM Plats')->fetchColumn();

       return $q;
     }

     public function delete(Plat $plat)
     {
       // Exécute une requête de type DELETE.
      $q = $this->_db->exec('DELETE FROM Plats WHERE ID = '.$plat->getId());

      return $q;
     }

     public function exists($info)
     {
       // Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
       if(is_int($info)){
         // On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.
         return (bool) $this->_db->query('SELECT COUNT(*) FROM Plats WHERE ID = '.$info)->fetchColumn();
       }
       // Sinon c'est qu'on a passé un nom.
       else{
         // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
         $q = $this->_db->prepare('SELECT COUNT(*) FROM Plats WHERE NOM = :nom');
         $q->execute([':nom' => $info]);

         return (bool) $q->fetchColumn();
       }
     }


    //  public function get($info)
    //  {
    //    // Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
    //      // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
    //      if(is_int($info)){
    //        $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);
     //
    //        $donnees = $q->fetch(PDO::FETCH_ASSOC);
     //
    //        return new Personnage($donnees);
    //      }
    //    // Sinon, on veut récupérer le personnage avec son nom.
    //    // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
    //    else {
    //        $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
    //        $q->execute([':nom' => $info]);
     //
    //        $donnees = $q->fetch(PDO::FETCH_ASSOC);
     //
    //        return new Personnage($donnees);
    //    }
    //  }
    //
    //  public function getList($nom)
    //  {
    //    // Retourne la liste des personnages dont le nom n'est pas $nom.
    //    // Le résultat sera un tableau d'instances de Personnage.
    //    $persos = [];
     //
    //    $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
    //    $q->execute([':nom' => $nom]);
     //
    //    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    //    {
    //      $persos[] = new Personnage($donnees);
    //    }
    //
    //    return $persos;
    //
    //  }

     public function update(Plat $plat)
     {
       // Prépare une requête de type UPDATE.
       $q = $this->_db->prepare('UPDATE Plats SET NOM = :nom, PRIX = :prix, IMAGE = :image WHERE ID = :id');
       // Assignation des valeurs à la requête.
       $q->bindValue(':id',$plat->getId());
       $q->bindValue(':nom',$plat->getNom());
       $q->bindValue(':prix',$plat->getPrix());
       $q->bindValue(':image',$plat->getImage());

       // Exécution de la requête.
       $q->execute();

       // Exécution de la requête.
       $reponse = $q->execute();

       return $reponse;
     }

     public function updateSansImage(Plat $plat)
     {
       // Prépare une requête de type UPDATE.
       $q = $this->_db->prepare('UPDATE Plats SET NOM = :nom, PRIX = :prix WHERE ID = :id');
       // Assignation des valeurs à la requête.
       $q->bindValue(':id',$plat->getId());
       $q->bindValue(':nom',$plat->getNom());
       $q->bindValue(':prix',$plat->getPrix());

       // Exécution de la requête.
       $reponse = $q->execute();

       return $reponse;
     }

     public function getPLat($id){

          $q = $this->_db->query('SELECT ID, NOM, PRIX, IMAGE FROM Plats WHERE id = '.$id);

          $donnees = $q->fetch(PDO::FETCH_ASSOC);

          return new Plat($donnees);

     }


     public function selectAllPlats()
     {
        $plats = [];

        $q = $this->_db->query('SELECT ID, NOM, PRIX, IMAGE FROM Plats');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
          // var_dump($donnees);
          $plats[] = new Plat($donnees);

          // $plats[] = getPLat($donnees['IDPLAT']);

        }

        return $plats;

     }



}
