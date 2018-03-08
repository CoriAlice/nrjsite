<section>
    
<h4>Connexion</h4>
<?php
echo $this->Form->create();
echo $this->Form->input("login",array('label'=>'Identifiant'));
echo $this->Form->input("password",array('label'=>'Mot de passe','type'=>'password'));
echo $this->Form->submit();
echo $this->Form->end();
?>

</section>

<?php 
    echo $this->Html->link($this->Html->image("logout.png", array("alt" => "deconnexion")),["controller"=>"Management","action"=>"deconnexion"],array('escape' => false));
?>
