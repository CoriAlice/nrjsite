<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class ManagementController extends AppController {

    public function accueil() {
        $counter=0;
                
        //connexion
        $this->loadModel("Users");
        $m=$this->Users->find();
        
         if($this->request->is("post")){
            $login=$this->request->data["login"];
            $password=$this->request->data["password"];
            
            foreach ($m as $user){
                
                if($user->login==$login AND $user->passwd==$password) {                   
                    $counter=1;
                }
            }
            if ($counter==0) echo '<script language="Javascript"> alert ("vous êtes pas encore inscrit" )</script>';
            else {
                session_start();
                $_SESSION['login'] = $login;
                echo '<script language="Javascript"> alert ("vous êtes maintenant connecté !" )</script>';
            }  
         }   
         
    }
    
    public function deconnexion() {
          // Démarrage ou restauration de la session
  session_start();
  // Réinitialisation du tableau de session
  // On le vide intégralement
  $_SESSION = array();
  // Destruction de la session
  session_destroy();
  // Destruction du tableau de session
  unset($_SESSION);
  
  echo "<script> alert('Vous êtes déconnecté !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
    }
    

    public function inscription() {
        $this->loadModel("Users");
        $new = $this->Users->newEntity();
        
         if($this->request->is("post")){
            $new->login=$this->request->data["login"];
            $new->passwd=$this->request->data["password"];
            $checkpasswd=$this->request->data["password_checking"];
            
            if($new->passwd==$checkpasswd)
            $this->Users->save($new);
            
            else echo '<script language="Javascript"> alert ("password non identique" )</script>';
        }
       $this->set("new",$new);
    }

    public function listeSites() {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if(empty($_SESSION['login'])) 
        {
            //si l'user n'est pas connecté on redirige vers l'accueil
            echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
                         
        }
        else {
        
        $this->loadModel('Sites');
      
        //trouver la liste des sites existants pour l'afficher
        $m=$this->Sites->find();
        $this->set("m",$m);
        
        //formulaire pour ajouter un nouveau site
        $new = $this->Sites->newEntity();
        if ($this->request->is('post')) {
                         
                if(($this->request->data['type'] != 'producer' AND
                $this->request->data['type'] != 'consumer')|| 
                ($this->request->data['stock'] <0) || 
                ($this->request->data['location_x'] <-90) || ($this->request->data['location_x'] >90) || ($this->request->data['location_y'] <-180) || ($this->request->data['location_x'] >180))
                
                    echo '<script language="Javascript"> alert ("saisie non valide" )</script>';
           
            else{
            $new->name=$this->request->data['name'];
            $new->type=$this->request->data['type'];
            $new->location_x=$this->request->data['location_x'];
            $new->location_y=$this->request->data['location_y'];
            $new->stock=$this->request->data['stock'];
            $this->Sites->save($new);   
            }
            
        }
        $this->set('new', $new);
        }
    }

    public function detailsSite($idsite) {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if(empty($_SESSION['login'])) 
        {
            //si l'user n'est pas connecté on redirige vers l'accueil
            echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
                         
        }
        else {
       
        $this->loadModel('Sites');
        $this->loadModel('Paths');
       
        $new = $this->Sites->get($idsite);
        
        //trouver les sites existants
        $m=$this->Sites->find();
        
        //trier les sites producer si le site actuel est consumer et vice-versa 
        $tabSitesTries=array();
        
        foreach($m as $site){
            if($site->type!=$new->type) $tabSitesTries[]=$site->name;
        }
        $this->set("tabSitesTries",$tabSitesTries);
        
        //formulaire nouvelle voie
        $newPath = $this->Paths->newEntity();
        $sitename="";
        
        if ($this->request->is('post') && $this->request->getData('submit') == 'Ajouter la voie' ){
            $sitename=$tabSitesTries[$this->request->data['SiteName']];  
  
         foreach($m as $site){
            if($site->name==$sitename) {
                $newPath->ending_site_id=$site->id;
                $newPath->starting_site_id=$new->id;
                $newPath->max_capacity=$this->request->data['max_capacity'];
                $newPath->name=$this->request->data['name'];
                $this->Paths->save($newPath);
            }
        }
            }
            
            //formulaire nouveau relevé
            $this->loadModel('Records');
            $newRecords=$this->Records->newEntity();
            $now=Time::now();
            $now->timezone='Europe/Paris';
            if ($this->request->is('post') && $this->request->getData('submit') == 'Ajouter le relevé' ){
                $newRecords->site_id=$idsite;
                $newRecords->date=$now;
                $newRecords->value=$this->request->data['value'];
                $this->Records->save($newRecords);
            }            
        
        
        //formulaire edition
        if ($this->request->is(['post', 'put'])&& $this->request->getData('submit') == 'Editer') {
            
            if(($this->request->data['type'] != 'producer' AND
                $this->request->data['type'] != 'consumer')|| 
                ($this->request->data['stock'] <0) || 
                ($this->request->data['location_x'] <-90) || ($this->request->data['location_x'] >90) || ($this->request->data['location_y'] <-180) || ($this->request->data['location_x'] >180))
                
                    echo '<script language="Javascript"> alert ("saisie non valide" )</script>';
           
            else{
            $new->name=$this->request->data['name'];
            $new->type=$this->request->data['type'];
            $new->location_x=$this->request->data['location_x'];
            $new->location_y=$this->request->data['location_y'];
            $new->stock=$this->request->data['stock'];
            $this->Sites->save($new);   
        }  
    }
    
    $this->set('new', $new);
        }
            }

    public function listeVoies() {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if(empty($_SESSION['login'])) 
        {
            //si l'user n'est pas connecté on redirige vers l'accueil
            echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
                         
        }
        else {
        $this->loadModel('Paths');
        $this->loadModel('Sites');
               
        //trouver les voies existantes
        $p=$this->Paths->find();
        $this->set("p",$p);
        
        //trouver les sites existants
        $m=$this->Sites->find();
        $this->set("m",$m);
        
    }}
    
    public function deleteSite($id){
        
       $this->loadModel('Sites');
       $entity = $this->Sites->get($id);
       $result = $this->Sites->delete($entity);

    }
    
     public function carte() {
         //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if(empty($_SESSION['login'])) 
        {
            //si l'user n'est pas connecté on redirige vers l'accueil
            echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
                         
        }
        else {
        $this->loadModel('Sites');
      
        //trouver la liste des sites existants pour l'afficher
        $m=$this->Sites->find();
        $this->set("m",$m);
       
// Convertir la requête en tableau va l'exécuter.
$tab = $m->toArray();

 $this->set("tab",$tab);
 
 $locx=array(); //tableau des latitudes des sites
 $locy=array(); //tableau des longitudes
 $type=array(); //tableau des types (consumer ou producer)
 $name=array(); //tableau des noms
 $stock=array(); //tableau des stocks
 
 //remplissage des tableaux 
 for ($iter = 0; $iter < sizeof($tab); $iter++) {
        
 $locx[]=$tab[$iter]->location_x;
 $locy[]=$tab[$iter]->location_y;
 
 $type[]=$tab[$iter]->type;
 $name[]=$tab[$iter]->name;
 $stock[]=$tab[$iter]->stock;
      
    }
    $this->set("locx", $locx);
     $this->set("locy", $locy);
     $this->set("type", $type);
      $this->set("name", $name);
      $this->set("stock", $stock);
}
}
 }

