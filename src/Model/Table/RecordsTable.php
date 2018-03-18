<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class RecordsTable extends Table {
    
    public function RecordsDuSite($idsite){
        
       //liste des relevés du site
            $listeRecords = $this->find();

            $listeRecordsDuSite = array();

            foreach ($listeRecords as $record) {

                if ($record->site_id == $idsite)
                    $listeRecordsDuSite[] = $record;
            }
            
            return $listeRecordsDuSite;
    }
    
    //analyse données 
     public function calculMoyenne($listeRecordsDuSite){
        
            //relevé moyen
            $moyenne;
            $total = 0;
            foreach ($listeRecordsDuSite as $record) {

                $total = $total + $record->value;
            }
            
            if (sizeof($listeRecordsDuSite) == 0) {
                $moyenne = 0;
                
            } else {
                $moyenne = $total / sizeof($listeRecordsDuSite);
            }
            
            return $moyenne;
     }

 public function calculMin($listeRecordsDuSite){
        
            //relevé min
            $valeurs = array();
            foreach ($listeRecordsDuSite as $record) {

                $valeurs[] = $record->value;
            }
            if (sizeof($listeRecordsDuSite) == 0) {
                $min = 0;
            } else {
                $min = min($valeurs);
            }
            
            return $min;
     }
     
     public function calculMax($listeRecordsDuSite){
        
            //relevé max 
            $valeurs = array();
            foreach ($listeRecordsDuSite as $record) {

                $valeurs[] = $record->value;
            }
            if (sizeof($listeRecordsDuSite) == 0) {
                $max = 0;
            } else {
                $max = max($valeurs);
            }
            
            return $max;
     }
     
     }
