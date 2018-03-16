<html>
    <head>
     <!--Notre fichier css situé dans webroot/css-->
    <?= $this->Html->css('details_site.css') ?>
     <!--Notre fichier javascript situé dans webroot/js-->
    <?= $this->Html->script('scripts.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
     <script type="text/javascript">
     function OnOff1() {
    
if (document.getElementById("relevé").style.display == "block")
document.getElementById("relevé").style.display = "none";
else
document.getElementById("relevé").style.display = "block";
}
function OnOff2() {
    
if (document.getElementById("voie").style.display == "block")
document.getElementById("voie").style.display = "none";
else
document.getElementById("voie").style.display = "block";
}
function OnOff3() {
    
if (document.getElementById("site").style.display == "block")
document.getElementById("site").style.display = "none";
else
document.getElementById("site").style.display = "block";
}
</script>
    </head>

    <section id="voies">
        <h2>Détails</h2>
        <p>Retrouvez toutes les informations concernant le site sélectionné.</p>
        <br/>

<ul id="detailsSite">
    <?php
    echo "<li>Nom : " . $new->name . "</li>";
    echo "<li>Type : " . $new->type . "</li>";
    echo "<li>Latitude : " . $new->location_x . "</li>";
    echo "<li>Longitude : " . $new->location_y . "</li>";
    echo "<li>Stock : " . $new->stock . "</li>";
    ?>
</ul>

<!--Relevés du site-->
    <h4>Relevés</h4>
<table>
            <tr>
                <th>Date</th>
                <th>Valeur</th>
            </tr>
    <?php
    foreach ($listeRecordsDuSite as $record) {
        echo"<tr>";
        echo"<td>" . $record->date . "</td>";
        echo"<td>" . $record->value . "</td>";
        echo "</tr>";
    }
    ?>
</table>
<?php
if($new->type=='producer'){
echo "Production moyenne : ".number_format($moyenne,2);
echo "Production maximume relevée : ".$max;
echo "Production minimume relevée : ".$min;
}
if($new->type=='consumer'){
echo "Consommation moyenne : ".number_format($moyenne,2);
echo "Consommation maximume relevée : ".$max;
echo "Production minimume relevée : ".$min;
}

echo "Capacité totale d'approvisionnement : ".$somme;

?>
    </section>    
    

<!--ajouter un relevé-->
<center><button class="button" onclick="OnOff1();">Ajouter un relevé au site</button></center>

<span id="relevé" style="display:none;">
    <br>
    
    <?= $this->Form->create() ?>
    <?= $this->Form->input('value', array('label' => 'Valeur', 'type' => 'number')) ?>
    <?= $this->Form->submit('Ajouter le relevé', array('name' => 'submit')) ?>
    <?= $this->Form->end() ?>
</span><br>


<!--ajouter voies-->
<center><button class="button" onclick="OnOff2();">Ajouter une voie d'acheminement au site</button></center>

<span id="voie" style="display:none;">
    <br>

    <?= $this->Form->create() ?>
    <?= $this->Form->input('SiteName', array('label' => 'Nom du site à raccoder', 'options' => $tabSitesTries)) ?>
    <?= $this->Form->input('max_capacity', array('label' => 'Capacité maximum', 'type' => 'number')) ?>
    <?= $this->Form->input('name', array('label' => 'Nom de la voie')) ?>
    <?= $this->Form->submit('Ajouter la voie', array('name' => 'submit')) ?>
    <?= $this->Form->end() ?>
</span><br>


<!--Formulaire d'edition à cacher et à dévoiler avec javascript-->
<center><button class="button" onclick="OnOff3();">Editer le site</button></center>

<span id="site" style="display:none;">
    <br>

    <?= $this->Form->create($new) ?>
    <?= $this->Form->input('name', array('label' => 'Nom')) ?>
    <?=
    $this->Form->input('type', array('options' => array(
            'consumer' => 'consumer',
            'producer' => 'producer')))
    ?>
    <?= $this->Form->input('location_x', array('label' => 'Latitude', 'type' => 'number')) ?>
    <?= $this->Form->input('location_y', array('label' => 'Longitude', 'type' => 'number')) ?>
    <?= $this->Form->input('stock', ['type' => 'number']) ?>
<?= $this->Form->submit('Editer', array('label' => 'Editer', 'name' => 'submit')) ?>
<?= $this->Form->end() ?>
</span><br>

</html>


