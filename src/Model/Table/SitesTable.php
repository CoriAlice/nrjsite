<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SitesTable extends Table {

    public function checkAndsave($data, $site) {

        if (($data['type'] != 'producer' AND
                $data['type'] != 'consumer') ||
                ($data['stock'] < 0) ||
                ($data['location_x'] < -90) || ($data['location_x'] > 90) || ($data['location_y'] < -180) || ($data['location_x'] > 180))
            echo '<script language="Javascript"> alert ("Saisie non valide" )</script>';
        else {
            $site->name = $data['name'];
            $site->type = $data['type'];
            $site->location_x = $data['location_x'];
            $site->location_y = $data['location_y'];
            $site->stock = $data['stock'];
            $this->save($site);
        }
    }

}
