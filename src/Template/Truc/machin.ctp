
<table>
<?php 
foreach($m as $site){
    echo"<tr>";
    echo"<td>".$site->name."</td>";
    
    
    echo "</tr>";
}
?>
</table>

<?php
$this->assign("title","test title");
?>

<section class="large-6">
    <h4>Ajouter un nouveau site</h4>
<?php
 $this->Form->create();
 $this->Form->input("login");
 $this->Form->input("password");
 $this->Form->input("password");
 $this->Form->submit();
 $this->Form->end();
?>
</section>
