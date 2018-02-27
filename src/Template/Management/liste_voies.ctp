<table>
<?php 
foreach($p as $path){
    echo"<tr>";
    echo"<td>Nom : ".$path->name."</td>";
    
    foreach($m as $site){
        if($path->starting_site_id==$site->id AND $site->type=='producer') echo"<td>Site producteur : ".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
        if($path->ending_site_id==$site->id AND $site->type=='producer') echo"<td>Site producteur : ".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
    }
    foreach($m as $site){
        if($path->starting_site_id==$site->id AND $site->type=='consumer') echo"<td>Site consommateur : ".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
        if($path->ending_site_id==$site->id AND $site->type=='consumer') echo"<td>Site consommateur : ".$this->Html->link($site->name,["controller"=>"Management","action"=>"details_site",$site->id])."</td>";
       
    }
     echo"<td>Capacité maximum : ".$path->max_capacity."</td>";
}
?>
</table>
