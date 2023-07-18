<?php 

require_once('inc/init.inc.php'); 

// liste des methodes (fonctions) du pdo
//debug( get_class_methods($pdo) );

if($_POST)
{

	
    // on verifie si on récupere bien toutes les informations du formulaire
    //debug($_POST);

    $erreur = '';

    // on verifie si le pseudo est bien compris entre 3 et 20 caractéres  ( restriction ) 
    if( strlen( $_POST['pseudo'])  <= 3 || strlen( $_POST['pseudo']) > 20  )
    {
        $erreur .=  '<div class="alert alert-danger" role="alert"> le pseudo doit avoir entre 3 et 20 caractéres </div>'; 
    }
    if( !preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo']))
    {
        $erreur .=  '<div class="alert alert-danger" role="alert"> le pseudo contient un ou plusieurs caractéres non autorisés </div>';
    }
    
    // on tente de récuperer un membre de la bdd ayant comme pseudo celui saisi par l'utilisateur dans le formulaire
    $req = $pdo->query("SELECT * FROM membre WHERE pseudo =  '$_POST[pseudo]' ");

    //debug( get_class_methods($req) );

	// on verifie si la requete précedente à touvé un mambre ou pas
	if( $req->rowCount() >= 1 )
	{
		$erreur .= '<div class="alert alert-danger" role="alert"> le pseudo est déja pris !! </div>';
	}

	
	
	// on recupere les données du formulaire pour leurs faire appliquer une fonction qui permet d'échaper entre autre les quotes (')
	foreach( $_POST as $indice => $value )
	{
		$_POST[$indice] = addslashes($value);
		
		// echo $_POST[$indice] . "<br>";
	}
	
	// on crypte le mot de passe avant de lenvoyer dans la bdd
	$mdp = password_hash($_POST['mdp'],PASSWORD_DEFAULT);

	//$content .= $mdp;


	// on verifie si $erreur est resté vide (cela veut dire qu'aucune erreur n'a été faite dans les champs du formulaire)
	if(empty($erreur))
	{
		$pdo->query("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES ('$_POST[pseudo]', '$mdp', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]') ");

		$content .= '<div class="alert alert-success"> Inscription validé !</div>';

	}

    $content .= $erreur; 
}



?>


<?php require_once('inc/haut.inc.php'); ?>

    <h1> Inscription </h1>

    <?= $content ?> 

    <form method="post" action="">
		<label for="pseudo">pseudo</label>
		<input type="text" class="form-control" placeholder="votre pseudo" name="pseudo" id="pseudo" required><br>
	
		<label for="mdp">mot de passe</label>
		<input type="password" class="form-control" placeholder="votre mot de passe" name="mdp" id="mdp" required><br>

		<label for="nom">nom</label>
		<input type="text" class="form-control" placeholder="votre nom" name="nom" id="nom"><br>
	
		<label for="prenom">prenom</label>
		<input type="text" class="form-control" placeholder="votre prenom" name="prenom" id="prenom"><br>

		<label for="email">email</label>
		<input type="text" class="form-control" placeholder="votre email" name="email" id="email" required><br>
	
	<br>
		<label for="civilite">civilite</label> 
		<input type="radio" class="" name="civilite" id="civilite" value="m" checked>
		Homme -- Femme
		<input type="radio" class="" name="civilite" id="civilite" value="f"><br><br>  
	
		<label for="ville">ville</label>
		<input type="text" class="form-control" placeholder="votre ville" name="ville" id="ville">	<br>
	
		<label for="cp">code postal</label>
		<input type="text" class="form-control" placeholder="votre cp" name="cp" id="cp"><br>
	
		<label for="adresse">adresse</label>
		<textarea class="form-control" placeholder="votre adresse" name="adresse" id="adresse"></textarea><br>
	
		<input type="submit" class="btn btn-primary">
	
    </form>

<?php require_once('inc/bas.inc.php'); ?>
