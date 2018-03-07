<?= $this->Html->css('test.css') ?>

<ul id="detailsSite">
<?php 
echo "<li>Nom : ".$new->name."</li>";
echo "<li>Type : ".$new->type."</li>";
echo "<li>Latitude : ".$new->location_x."</li>";
echo "<li>Longitude : ".$new->location_y."</li>";
echo "<li>Stock : ".$new->stock."</li>";
?>
</ul>

<!--ajouter un relevé-->
<section class="large-6">
    <h4>Ajouter un relevé au site</h4>
<?= $this->Form->create() ?>
<?= $this->Form->input('value', array('label'=>'Valeur','type'=>'number'))?>
<?= $this->Form->submit('Ajouter le relevé',array('name' => 'submit')) ?>
<?= $this->Form->end() ?>
</section>

<!--ajouter voies-->
<section class="large-6">
    <h4>Ajouter une voie d'acheminement au site</h4>
<?= $this->Form->create() ?>
<?= $this->Form->input('SiteName', array('label'=>'Nom du site à raccoder','options' => $tabSitesTries))?>
<?= $this->Form->input('max_capacity', array('label'=>'Capacité maximum','type'=>'number'))?>
<?= $this->Form->input('name', array('label'=>'Nom de la voie'))?>
<?= $this->Form->submit('Ajouter la voie',array('name' => 'submit')) ?>
<?= $this->Form->end() ?>
</section>


<!--Formulaire d'edition à cacher et à dévoiler avec javascript-->
<section class="large-6">
    <h4>Editer le site</h4>
<?= $this->Form->create($new) ?>
<?= $this->Form->input('name',array('label'=>'Nom')) ?>
<?= $this->Form->input('type',array('options' => array(
    'consumer' => 'consumer',
    'producer' => 'producer')))?>
<?= $this->Form->input('location_x',array('label'=>'Latitude','type'=>'number')) ?>
<?= $this->Form->input('location_y',array('label'=>'Longitude','type'=>'number')) ?>
<?= $this->Form->input('stock',['type'=>'number']) ?>
<?= $this->Form->submit('Editer',array('label'=>'Editer','name' => 'submit')) ?>
<?= $this->Form->end() ?>
</section>



