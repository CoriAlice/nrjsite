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
        <script>
            window.onload = function () {

                var dataPoints = [];
                var recordsvalues =<?php echo json_encode($recordsvalues) ?>;
                var jours =<?php echo json_encode($jours) ?>;
                var mois =<?php echo json_encode($mois) ?>;
                var annees =<?php echo json_encode($annees) ?>;

                //Better to construct options first and then pass it as a parameter
                var options = {
                    title: {
                        text: "Historique des relevés du site"
                    },
                    axisX: {
                        valueFormatString: "DD MMM YYYY",
                    },
                    animationEnabled: true,
                    exportEnabled: true,
                    data: [
                        {
                            type: "spline", //change it to line, area, column, pie, etc
                            dataPoints: dataPoints
                        }
                    ]
                };

                function addData() {
                    for (var i = 0; i < recordsvalues.length; i++) {
                        dataPoints.push({
                            x: new Date(annees[i], mois[i] - 1, jours[i]),
                            y: recordsvalues[i]
                        });
                    }

                    $("#chartContainer").CanvasJSChart(options);
                }
                addData();
            }
        </script>
    </head>

    <section id="voies">
        <h2>Détails</h2>
        <p>Retrouvez toutes les informations concernant le site sélectionné.</p>
        <br/>




        <table>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Stock</th>
            </tr>

            <?php
            echo"<tr>";
            echo "<td>" . $siteactuel->name . "</td>";
            echo "<td>" . $siteactuel->type . "</td>";
            echo "<td>" . $siteactuel->location_x . "</td>";
            echo "<td>" . $siteactuel->location_y . "</td>";
            echo "<td>" . $siteactuel->stock . "</td>";
            echo"</tr>";
            ?>

        </table>
        <br>
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
        <br>

        <h4>Statistiques du site</h4>
        <table>
            <?php
            if ($siteactuel->type == 'producer') {
                echo'<tr>';
                echo'<th>Production moyenne</th>';
                echo'<th>Production maximale relevée</th>';
                echo'<th>Production minimale relevée</th>';
                echo'<th>Capacité totale d approvisionnement</th>';
                echo'</tr>';


                echo"<tr>";
                echo "<td>" . number_format($moyenne, 2);
                echo "<td>" . $max;
                echo "<td>" . $min;
                echo "<td>" . $somme;
            }
            ?>
        </table>

        <table>
            <?php
            if ($siteactuel->type == 'consumer') {
                echo'<tr>';
                echo'<th>Consommation moyenne</th>';
                echo'<th>Consommation maximale relevée</th>';
                echo'<th>Consommation minimale relevée</th>';
                echo'<th>Capacité totale d approvisionnement</th>';
                echo'</tr>';


                echo"<tr>";
                echo "<td>" . number_format($moyenne, 2);
                echo "<td>" . $max;
                echo "<td>" . $min;
                echo "<td>" . $somme;
            }
            ?>
        </table>

        <br>
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
        <br>


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

        <?= $this->Form->create($siteactuel) ?>
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


