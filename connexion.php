<?php

require_once("inc/init.inc.php");

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
    // on retire le tableau membre de la session
    unset($_SESSION['membre']);

}

if(internauteEstConnecte())
{
    header('location:profil.php');
}


if($_POST)
{
    $erreur= '';
    //debug($_POST);
    $req = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]' ");

    //debug( get_class_methods($req) );

    if($req->rowCount() >= 1 )
    {
        // on récupere les informations du membre trouvé sous form de tableau grâce à la methode fetch() du PDOStatement ($req est un nouvel objet de la calsse PDOStatement)
        // PDO::FETCH_ASSOC pour un tableau associatif ( intilulé du champs => valeur )
        $membre = $req->fetch(PDO::FETCH_ASSOC);
        // debug($membre);
        // die();

        // on verifie si le mot de passe saisi par l'utilisateur correspond à celui du membre trouvé précedement grâce à la fonction password_verify( 'mot de passe saisie', 'mot de passe bdd' )
        if(password_verify( $_POST['mdp'], $membre['mdp'] ))
        {
            $_SESSION['membre']['id_membre'] = $membre['id_membre'];
            $_SESSION['membre']['pseudo'] = $membre['pseudo'];
            $_SESSION['membre']['nom'] = $membre['nom'];
            $_SESSION['membre']['prenom'] = $membre['prenom'];
            $_SESSION['membre']['email'] = $membre['email'];
            $_SESSION['membre']['civilite'] = $membre['civilite'];
            $_SESSION['membre']['ville'] = $membre['ville'];
            $_SESSION['membre']['code_postal'] = $membre['code_postal'];
            $_SESSION['membre']['adresse'] = $membre['adresse'];
            $_SESSION['membre']['statut'] = $membre['statut'];

            header('location:profil.php');

        }else{
            $erreur .= '<div class="alert alert-danger"> erreur de mot de passe< /div>';
        }

    }else{
        $erreur .= '<div class="alert alert-danger"> pseudo non reconnu ! </div>';
    }

    $content .= $erreur;

}

?>

<?php require_once("inc/haut.inc.php"); ?>

<div class="text-center">
     <h1>Connexion</h1>
</div>

<?= $content ?>

<form method="post" action="">
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control">
    </div>    

    <div>
        <label for="mdp">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" class="form-control">
    </div>

    <div>
        <input type="submit" value="Se connecter" class="btn btn-primary">
    </div>
</form>


<?php require_once("inc/bas.inc.php"); ?>

