<html>
    <head>
     <!--Notre fichier css situé dans webroot/css-->
    <?= $this->Html->css('liste_voies.css') ?>
     <!--Notre fichier javascript situé dans webroot/js-->
    <?= $this->Html->script('scripts.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    </head>

    <section id="voies">
        <h2>Voies d'acheminement</h2>
        <p>Retrouvez l'ensemble des voies d'acheminement référencées.</p>
        <br/>
        
        <table>
            <tr>
                <th>Nom</th>
                <th>Site producteur</th>
                <th>Site consommateur</th>
                <th>Débit maximal</th>
            </tr>
            <?php 
            foreach($p as $path){
                echo"<tr>";
                echo"<td>".$path->name."</td>";
    
                foreach($m as $site){
                    if($path->starting_site_id==$site->id AND $site->type=='producer') echo"<td>".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
                    if($path->ending_site_id==$site->id AND $site->type=='producer') echo"<td>".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
                }
                foreach($m as $site){
                    if($path->starting_site_id==$site->id AND $site->type=='consumer') echo"<td>".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
                    if($path->ending_site_id==$site->id AND $site->type=='consumer') echo"<td>".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
       
                }
                echo"<td>".$path->max_capacity."</td>";
            }
            ?>
        </table>
        
    </section>    
    
</html>

