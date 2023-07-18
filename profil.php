<?php

require_once('inc/init.inc.php'); 
//debug($_SESSION);

if(!internauteEstConnecte())
{
    header('location:connexion.php');
    exit();
}

if(internauteEstConnecteETAdmin())
{
    $content .= "<h1> Vous êtes Admin du site </h1>";
}else{
    $content .= "<h1> Vous êtes User du site </h1>";
}

?>

<?php  require_once('inc/haut.inc.php') ?>

<?= $content ?> 

<h4>Bonjour <?= $_SESSION['membre']['pseudo'] ?></h4>

<h5> Vos infomations : </h5>
<h6>
    <strong>Nom : </strong> <?=  $_SESSION['membre']['nom'] ?> 
</h6>
<h6>
    <strong>Prénom : </strong> <?=  $_SESSION['membre']['prenom'] ?> 
</h6>
<h6>
    <strong>email : </strong> <?=  $_SESSION['membre']['email'] ?> 
</h6>


<?php  require_once('inc/bas.inc.php') ?>
