<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class ManagementController extends AppController {

    public function accueil() {
        $counter = 0;

        //connexion
        $this->loadModel("Users");
        $m = $this->Users->find();

        if ($this->request->is("post")) {
            $login = $this->request->data["login"];
            $password = $this->request->data["password"];

            foreach ($m as $user) {

                if ($user->login == $login AND password_verify($password, $user->passwd)) {
                    $counter = 1;
                }
            }
            if ($counter == 0)
                echo '<script language="Javascript"> alert ("Vous êtes pas encore inscrit ou votre mot de passe est invalide !" )</script>';
            else {
                session_start();
                $_SESSION['login'] = $login;
                echo '<script language="Javascript"> alert ("Vous êtes maintenant connecté !" )</script>';
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

        return $this->redirect(['action' => 'accueil']);
        //echo "<script> alert('Vous êtes déconnecté !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
    }

    public function inscription() {
        $this->loadModel("Users");
        $new = $this->Users->newEntity();

        if ($this->request->is("post")) {
            $new->login = $this->request->data["login"];
            $password = $this->request->data["password"];
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);

            $new->passwd = password_hash($this->request->data["password"], PASSWORD_DEFAULT);
            $checkpasswd = $this->request->data["password_checking"];

            if (password_verify($checkpasswd, $new->passwd))
                $this->Users->save($new);
            else
                echo '<script language="Javascript"> alert ("Mot de passe non identique" )</script>';
        }
    }

    public function listeSites() {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if (empty($_SESSION['login'])) {
            //si l'user n'est pas connecté on redirige vers l'accueil
            // echo "<script> alert('Page sécurisée, il faut vous connecter !')</script>";
            $this->redirect(['action' => 'accueil']);
        } else {

            $this->loadModel('Sites');

            //trouver la liste des sites existants pour l'afficher
            $m = $this->Sites->find();
            $this->set("m", $m);

            //formulaire pour ajouter un nouveau site
            $new = $this->Sites->newEntity();
            if ($this->request->is('post')) {

                $this->Sites->checkAndsave($this->request->data, $new);
            }
        }
    }

    public function detailsSite($idsite) {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if (empty($_SESSION['login'])) {
            //si l'user n'est pas connecté on redirige vers l'accueil
            //echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
            $this->redirect(['action' => 'accueil']);
        } else {

            $this->loadModel('Sites');
            $this->loadModel('Paths');

            $siteactuel = $this->Sites->get($idsite);

            //trouver les sites existants
            $m = $this->Sites->find();

            //trier les sites producer si le site actuel est consumer et vice-versa 
            $tabSitesTries = array();

            foreach ($m as $site) {
                if ($site->type != $siteactuel->type)
                    $tabSitesTries[] = $site->name;
            }
            $this->set("tabSitesTries", $tabSitesTries);

            //formulaire nouvelle voie
            $newPath = $this->Paths->newEntity();
            $sitename = "";

            if ($this->request->is('post') && $this->request->getData('submit') == 'Ajouter la voie') {
                $sitename = $tabSitesTries[$this->request->data['SiteName']];

                foreach ($m as $site) {
                    if ($site->name == $sitename) {
                        $newPath->ending_site_id = $site->id;
                        $newPath->starting_site_id = $idsite;
                        $newPath->max_capacity = $this->request->data['max_capacity'];
                        $newPath->name = $this->request->data['name'];
                        $this->Paths->save($newPath);
                    }
                }
            }

            //formulaire nouveau relevé
            $this->loadModel('Records');
            $newRecords = $this->Records->newEntity();
            $now = Time::now();
            $now->timezone = 'Europe/Paris';
            if ($this->request->is('post') && $this->request->getData('submit') == 'Ajouter le relevé') {
                $newRecords->site_id = $idsite;
                $newRecords->date = $now;
                $newRecords->value = $this->request->data['value'];
                $this->Records->save($newRecords);
            }

            //liste des relevés du site
            $listeRecordsDuSite = $this->Records->RecordsDuSite($idsite);
            $this->set("listeRecordsDuSite", $listeRecordsDuSite);

            //analyse données 
            //relevé moyen
            $moyenne = $this->Records->calculMoyenne($listeRecordsDuSite);

            //relevé max et min
            $min = $this->Records->calculMin($listeRecordsDuSite);
            $max = $this->Records->calculMax($listeRecordsDuSite);

            $this->set("moyenne", $moyenne);
            $this->set("max", $max);
            $this->set("min", $min);

            //recordsvalues
            $recordsvalues = array();
            $jours = array();
            $mois = array();
            $annees = array();

            foreach ($listeRecordsDuSite as $record) {

                $testdate = date_parse($record->date);
                $jours[] = $testdate['day'];
                $mois[] = $testdate['month'];
                $annees[] = $testdate['year'];

                $recordsvalues[] = $record->value;
            }
            $this->set("recordsvalues", $recordsvalues);

            $this->set("jours", $jours);
            $this->set("mois", $mois);
            $this->set("annees", $annees);


            //somme des débits des voies
            $voies = $this->Paths->find();
            $voiesdusite = array();
            foreach ($voies as $voie) {
                if ($voie->starting_site_id == $idsite OR $voie->ending_site_id == $idsite)
                    $voiesdusite[] = $voie;
            }
            $sommedebitvoies = 0;
            foreach ($voiesdusite as $voie) {

                $sommedebitvoies = $sommedebitvoies + $voie->max_capacity;
            }
            $this->set("somme", $sommedebitvoies);


            //formulaire edition du site
            if ($this->request->is(['post', 'put']) && $this->request->getData('submit') == 'Editer') {

                $this->Sites->checkAndsave($this->request->data, $siteactuel);
            }

            $this->set('siteactuel', $siteactuel);
        }
    }

    public function listeVoies() {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if (empty($_SESSION['login'])) {
            //si l'user n'est pas connecté on redirige vers l'accueil
            //echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
            $this->redirect(['action' => 'accueil']);
        } else {
            $this->loadModel('Paths');
            $this->loadModel('Sites');

            //trouver les voies existantes
            $p = $this->Paths->find();
            $this->set("p", $p);

            //trouver les sites existants
            $m = $this->Sites->find();
            $this->set("m", $m);
        }
    }

    public function deleteSite($id) {

        $this->loadModel('Sites');
        $entity = $this->Sites->get($id);
        $result = $this->Sites->delete($entity);

        $this->redirect(['controller' => 'Management', 'action' => 'liste_sites']);
    }

    public function carte() {
        //test user connecté
        session_start();
        // On teste si la variable de session existe et contient une valeur
        if (empty($_SESSION['login'])) {
            //si l'user n'est pas connecté on redirige vers l'accueil
            //echo "<script> alert('Page sécurisée, il faut vous connecter !');window.location.href='http://localhost/nrjsite/management/accueil';</script>";
            $this->redirect(['action' => 'accueil']);
        } else {
            $this->loadModel('Sites');

            //trouver la liste des sites existants pour l'afficher
            $m = $this->Sites->find();
            $this->set("m", $m);

// Convertir la requête en tableau va l'exécuter.
            $tab = $m->toArray();

            $this->set("tab", $tab);

            $locx = array(); //tableau des latitudes des sites
            $locy = array(); //tableau des longitudes
            $type = array(); //tableau des types (consumer ou producer)
            $name = array(); //tableau des noms
            $stock = array(); //tableau des stocks
            //remplissage des tableaux 
            for ($iter = 0; $iter < sizeof($tab); $iter++) {

                $locx[] = $tab[$iter]->location_x;
                $locy[] = $tab[$iter]->location_y;

                $type[] = $tab[$iter]->type;
                $name[] = $tab[$iter]->name;
                $stock[] = $tab[$iter]->stock;
            }
            $this->set("locx", $locx);
            $this->set("locy", $locy);
            $this->set("type", $type);
            $this->set("name", $name);
            $this->set("stock", $stock);
        }
    }

}
