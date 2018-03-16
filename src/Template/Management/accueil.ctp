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
      <?= $this->Html->css('accueil.css') ?>
     <!--Notre fichier javascript situé dans webroot/js-->
    <?= $this->Html->script('scripts.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    </head>
    
    
    <body>

        <aside>
<img src="../webroot/img/welcome.png" alt="img_connexion">
</aside>
<section id="connexion">
    
<h2>Connexion</h2>

<p>
    Pour accéder aux pages du site, veuillez vous connecter ou vous inscrire. 
</p>


<?php
echo $this->Form->create();
echo $this->Form->input("login",array('label'=>'Identifiant'));
echo $this->Form->input("password",array('label'=>'Mot de passe','type'=>'password'));
echo $this->Form->submit('Valider');
echo $this->Form->end();
?>




  </section>    
        

        
    </body>
    
    
    </html>
