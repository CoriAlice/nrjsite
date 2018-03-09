<!DOCTYPE html>
<html>
    <head>
    <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
        <?= $this->fetch('title') ?>
        </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    
     <!--Notre fichier css situé dans webroot/css-->
    <?= $this->Html->css('default.css') ?>
     <!--Notre fichier javascript situé dans webroot/js-->
    <?= $this->Html->script('scripts.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    </head>
    
    
    <body>


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

        
        
    </body>
    
    
    </html>
