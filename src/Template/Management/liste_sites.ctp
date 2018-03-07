
<table>
<?php 
foreach($m as $site){
    echo"<tr>";
    echo"<td>".$site->name."</td>";
    echo"<td>".$this->Html->link("details",["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
   // echo "<td><button type='button'>Delete!</button></td>";
   // echo $this->Form->create('Search', array('action'=>'isFeatured'));
    //echo"<td>".$this->Html->link("Delete",["controller"=>"Management","action"=>"liste_sites",$site->id,0])."</td>";
  // echo $this->Form->button('Submit Form', array('action'=>'delete_site'))
    echo "<td>".$this->Html->link($this->Html->image("poubelle.png", array("alt" => "suppression")),["controller"=>"Management","action"=>"delete_site",$site->id],array('confirm'=>'confirmer la suppression','escape' => false))."</td>";
    echo "</tr>";
}
?>
</table>

<section class="large-6">
    <h4>Ajouter un nouveau site</h4>
<?= $this->Form->create() ?>
<?= $this->Form->input('name',array('label'=>'Nom')) ?>
<?= $this->Form->input('type',array('options' => array(
    'consumer' => 'consumer',
    'producer' => 'producer')))?>
<?= $this->Form->input('location_x',array('label'=>'Latitude','type'=>'number')) ?>
<?= $this->Form->input('location_y',array('label'=>'Longitude','type'=>'number')) ?>
<?= $this->Form->input('stock',['type'=>'number']) ?>
<?= $this->Form->submit() ?>
<?= $this->Form->end() ?>
</section>

