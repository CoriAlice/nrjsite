<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SitesTable extends Table {

    public function checkAndSave($id, $pars) {
        if ($pars['type'] != 'producer' AND
                $pars['type'] != 'consumer')
            return false;
        $old = $this->get($id);
        $old->name = $pars['name'];
        $old->type = $pars['type'];
        $old->location_x = $pars['location_x'];
        $old->location_y = $pars['location_y'];
        $old->stock = $pars['stock'];
        $this->save($old);
    }

}
