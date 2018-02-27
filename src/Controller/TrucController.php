<?php

namespace App\Controller;

use App\Controller\AppController;

class TrucController extends AppController {
    
    public function machin($idencours)
    {
        
        $this->loadModel("Sites");
        $m=$this->Sites->find();
        $this->set("m",$m);
        
        $this->loadModel("Users");
        $new=$this->Users->get($idencours);
       
        if($this->request->is("post")){
            $new->login=$this->request->data["login"];
            $new->passwd=$this->request->data["password"];
            $this->Users->save($new);
        }
       $this->set("new",$new);
    }
    
    
    
}
