
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript">
            function OnOff() {

                if (document.getElementById("le_texte").style.display == "block")
                    document.getElementById("le_texte").style.display = "none";
                else
                    document.getElementById("le_texte").style.display = "block";
            }
        </script>

        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>

        <!--Notre fichier css situé dans webroot/css-->
        <?= $this->Html->css('liste_sites.css') ?>
        <?= $this->Html->css('default.css') ?>
        <!--Notre fichier javascript situé dans webroot/js-->
        <?= $this->Html->script('scripts.js') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>

        <h2> Liste des sites </h2>
        <table>
            <tr>
                <th>Nom du site</th>
                <th>Afficher le détail</th>
                <th>Supprimer</th>
            </tr>
            <?php
            foreach ($m as $site) {
                echo"<tr>";
                echo"<td>" . $site->name . "</td>";
                //echo"<td>".$this->Html->link("details",["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
                echo "<td>" . $this->Html->image("loupe.png", [
                    "alt" => "details",
                    "id" => "bouton_loupe",
                    'url' => ['controller' => 'Management', 'action' => 'details_site', $site->id]]) . "</td>";
                // echo "<td>".$this->Html->link($this->Html->image("loupe.png", array("alt" => "suppression")),["controller"=>"Management","action"=>"details_site",$site->id],array('escape' => false))."</td>";
                echo "<td>" . $this->Html->link($this->Html->image("poubelle.png", ["id" => "bouton_supp"], array("alt" => "suppression")), ["controller" => "Management", "action" => "delete_site", $site->id], array('confirm' => 'confirmer la suppression', 'escape' => false)) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

    <center><button class="button" onclick="OnOff();">Ajouter un nouveau site</button></center>

    <span id="le_texte" style="display:none;">
        <br>

        <?php
        echo $this->Form->create();
        echo $this->Form->input('name', array('label' => 'Nom'));
        echo $this->Form->input('type', array('options' => array(
                'consumer' => 'consumer',
                'producer' => 'producer')));
        echo $this->Form->input('location_x', array('label' => 'Latitude', 'type' => 'number'));
        echo $this->Form->input('location_y', array('label' => 'Longitude', 'type' => 'number'));
        echo $this->Form->input('stock', ['type' => 'number']);
        echo $this->Form->submit("Valider");
        echo $this->Form->end();
        ?>
    </span><br>


</body>


</html>