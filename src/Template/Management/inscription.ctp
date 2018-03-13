<html>
    <head>
     <!--Notre fichier css situé dans webroot/css-->
    <?= $this->Html->css('inscription.css') ?>
     <!--Notre fichier javascript situé dans webroot/js-->
    <?= $this->Html->script('scripts.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    </head>
    
<aside>
<img src="../webroot/img/energies.jpg" alt="img_inscription">
</aside>

<section id="inscription">
    
<h2>Inscription</h2>
<p>N'hésitez pas, c'est gratuit !</p>
<?php
echo $this->Form->create();
echo $this->Form->input("login",array('label'=>'Identifiant'));
echo $this->Form->input("password",array('label'=>'Mot de passe','type'=>'password'));
echo $this->Form->input("password_checking",array('label'=>'Vérification mot de passe','type'=>'password'));
echo $this->Form->submit("Valider");
echo $this->Form->end();
?>
</section>

</html>
