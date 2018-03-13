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
        <!--<nav class="top-bar expanded" data-topbar role="navigation">
            <ul class="title-area large-3 medium-4 columns">
                <li class="name">
                    <h1><a href=""><?= $this->fetch('title') ?></a></h1>
                </li>
            </ul>
            
            <div class="top-bar-section">
                <ul class="right">
                    <li><a target="_blank" href="https://book.cakephp.org/3.0/">Documentation</a></li>
                    <li><a target="_blank" href="https://api.cakephp.org/3.0/">API</a></li>
                </ul>
            </div> 
        </nav>-->
        
        <!--barre d'acceuil-->
     <section id="entete">			
				<img src="\nrjsite\webroot\img\logo.png" alt="logo" height="150" width="150">
                                <h1> Energy Datas </h1>
                                <h5> Le seul site répertoriant l'intégralité des sites de production d'énergie </h5>
                   			       
         	</section>
        
        
        <div class="topnav">
            <a href="/nrjsite/management/accueil">Accueil</a>
            <a href="/nrjsite/management/inscription">Inscription</a>
            <a href="/nrjsite/management/liste-sites">Les sites</a>
            <a href="/nrjsite/management/liste-voies">Les voies</a>
            <a href="/nrjsite/management/carte">Carte</a>
            <img         
<?php 
    echo $this->Html->link($this->Html->image("logout.png", array("alt" => "deconnexion")),["controller"=>"Management","action"=>"deconnexion"],array('escape' => false));
?>
        
        </div> 
        
        
       
    <?= $this->Flash->render() ?>
        <div class="container clearfix">
        <?= $this->fetch('content') ?>
        </div> 
        
   
        
        
        <footer>
	<p>
		Alice Cori - Agathe Henry - Lara Brayelle - Clément Saudreau
	</p>
	<p>
		ING 4 - Energie & Envionnement 
	</p>
        <p>
		Gr1-10-DE
	</p>
</footer>
        
        
      </body>
</html>
