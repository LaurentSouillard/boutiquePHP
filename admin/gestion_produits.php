<?php 

require_once('../inc/init.inc.php');

if(!internauteEstConnecteETAdmin())
{
    header('location:../connexion.php');
}

$url = 'http://localhost/boutique_php/photo/468432EZR_61260_2_V3T3.jpg';
$img = file_get_contents($url);
debug($img);

if($_POST)
{
    //debug($_POST);

    $photo_bdd = '';

    //debug($_FILES);

    //si il y a une action modification dans l'url, la photo_bdd sera la photo du produit actuel
    if(isset($_GET['action']) && $_GET['action'] == 'modification' )
    {
        $photo_bdd = $_POST['photo_actuelle'];
    }
    // si une photo à bien été uploadé c'est celle ci qui sera prise en compte
    if($_FILES['photo']['name'])
    {
        // je renomme la photo en y ajoutant la reference
        $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
        // je crée l'url de la photo qui sera enregistré en BDD
        $photo_bdd = URL . "photo/$nom_photo";
        // je crée le chemin oû enregistrer la photo dans mon projet
        $photo_dossier = RACINE_SITE . "photo/$nom_photo";
        //je copy la photo uploader depuis $_FILES vers le dossier photo
        copy($_FILES['photo']['tmp_name'], $photo_dossier);
    }

    foreach ($_POST as $indice => $value) {
        $_POST[$indice] = addslashes($value);
    }

    //si il y a une action modification dans l'url on fait un update d'un produit existant
    if(isset($_GET['action']) && $_GET['action'] == 'modification' )
    {
        $pdo->query("UPDATE produit SET reference = '$_POST[reference]', categorie = '$_POST[categorie]', titre = '$_POST[titre]',description = '$_POST[description]', couleur = '$_POST[couleur]', taille = '$_POST[taille]', sexe = '$_POST[sexe]', photo = '$photo_bdd', prix = '$_POST[prix]', stock = '$_POST[stock]' WHERE id_produit = '$_POST[id_produit]' ");
    }else{
        // sinon insertion d'un nouveau produit en bdd
        $pdo->query("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock ) VALUES ('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[sexe]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");
    }

    
}

// récupération des donnée puis les afficher
    $req = $pdo->query('SELECT * FROM produit');
    // debug($req);
    // die();
    $content .= "<h1>Affichage des " . $req->rowCount() . " produit(s)</h1>";
    $content .= "<table class=\"table table-bordered table-dark\"><thead><tr class=\"table-dark\">";
    for($i = 0; $i < $req->columnCount(); $i++)
    {
        $colonne = $req->getColumnMeta($i);
        //debug($colonne);
        $content .= "<th class=\"thead-dark\">$colonne[name]</th>";
    }

    $content .= "<th class=\"thead-dark\">Modification</th>";
    $content .= "<th>Suppression</th>";
    $content .= "</tr></thead>";

    while($ligne = $req->fetch(PDO::FETCH_ASSOC))
    {
        $content .= "<tr>";
        foreach($ligne as $key => $value) {
            if($key == "photo")
            {
                $content .= "<td><img src=\"$value\" width=\"70\" class=\"img-responsive\"></td>";
            }else{
                $content .= "<td>$value</td>";
            }
        }

        // nous ajoutons des actions dans l'url pour la modification et la suppression afin de les recuperer en GET
        $content .= "<td><a href=\"?action=modification&id_produit=$ligne[id_produit]\" ><span class=\"glyphicon glyphicon-edit\"></span></a></td>";
        $content .= "<td><a href=\"\" ><span class=\"glyphicon glyphicon-trash text-danger\"></span></a></td>";

        $content .= "</tr>";

    }

    $content .= "</table><hr><hr>";

    // on verifie si on a cliqué sur le boutton modification, dans ce cas la l'action sera modification
    if( isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $req = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
        $produit_actuel = $req->fetch(PDO::FETCH_ASSOC);
        //debug($produit_actuel);
    }
    // nous allons definir des varibale représentant tout les chamsp du produit pour faire en sorte de pré remplir le formulaire lorsqu'on est en modification
    // le code suivant vaut dire : si $produit_actuel['id_produit'] existe, ça sera la valeur de $id_produit, sinon ça reste vide
    $id_produit = ( isset($produit_actuel['id_produit']) ) ? $produit_actuel['id_produit'] : '';
    $reference = ( isset($produit_actuel['reference']) ) ? $produit_actuel['reference'] : '';
    $categorie = ( isset($produit_actuel['categorie']) ) ? $produit_actuel['categorie'] : '';
    $titre = ( isset($produit_actuel['titre']) ) ? $produit_actuel['titre'] : '';
    $description = ( isset($produit_actuel['description']) ) ? $produit_actuel['description'] : '';
    $couleur = ( isset($produit_actuel['couleur']) ) ? $produit_actuel['couleur'] : '';
    $taille = ( isset($produit_actuel['taille']) ) ? $produit_actuel['taille'] : '';
    $sexe = ( isset($produit_actuel['sexe']) ) ? $produit_actuel['sexe'] : '';
    $photo = ( isset($produit_actuel['photo']) ) ? $produit_actuel['photo'] : '';
    $prix = ( isset($produit_actuel['prix']) ) ? $produit_actuel['prix'] : '';
    $stock = ( isset($produit_actuel['stock']) ) ? $produit_actuel['stock'] : '';



?>

<?php require_once('incAdmin/header.php');  ?>

<?= $content ?> 

    <h1> Ajout de produits </h1>

    <form method="post" action="" enctype="multipart/form-data">

        <input type="hidden" name="id_produit" value="<?= $id_produit ?>">

        <label for="reference">Reference</label>
        <input type="text" name="reference" placeholder="la reference" id="reference" class="form-control" value="<?= $reference ?>">

        <label for="categorie">categorie</label>
        <input type="text" name="categorie" placeholder="la categorie" id="categorie" class="form-control" value="<?= $categorie ?>">

        <label for="titre">titre</label>
        <input type="text" name="titre" placeholder="le titre" id="titre" class="form-control" value="<?= $titre ?>">

        <label for="description">description</label>
        <textarea name="description" id="description" rows="10" class="form-control"> <?= $description ?> </textarea>

        <label for="couleur">couleur</label>
        <select name="couleur" id="couleur" class="form-control">
            <option <?php if($couleur == 'bleu' ) echo 'selected' ?> >bleu</option>
            <option <?php if($couleur == 'rouge' ) echo 'selected' ?> >rouge</option>
            <option <?php if($couleur == 'vert' ) echo 'selected' ?> > vert</option>
            <option <?php if($couleur == 'blanc' ) echo 'selected' ?> >blanc</option>
            <option <?php if($couleur == 'noir' ) echo 'selected' ?> >noir</option>
            <option <?php if($couleur == 'jaune' ) echo 'selected' ?> >jaune</option>
            <option <?php if($couleur == 'violet' ) echo 'selected' ?> >violet</option>
        </select>

        <label for="taille">taille</label>
        <select name="taille" id="taille" class="form-control">
            <option <?php if($taille == 'S' ) echo 'selected' ?> >S</option>
            <option <?php if($taille == 'M' ) echo 'selected' ?> >M</option>
            <option <?php if($taille == 'L' ) echo 'selected' ?> >L</option>
            <option <?php if($taille == 'XL' ) echo 'selected' ?>  >XL</option>
        </select>

        <label for="sexe">sexe</label>
        <select name="sexe" id="sexe" class="form-control">
            <option value="m" <?php if($sexe == 'm' ) echo 'selected' ?> >Homme</option>
            <option value="f" <?php if($sexe == 'f' ) echo 'selected' ?> >Femme</option>
            <option value="mixte" <?php if($sexe == 'mixte' ) echo 'selected' ?> >Mixte</option>
        </select>

        <label for="photo">photo</label>
        <input type="file" name="photo" id="photo" class="form-control">
        <?php if($photo): ?>
            <p>Vous pouvez uploader une nouvelle image si vous le souhaitez.</p><br>
            <img src="<?= $photo ?>" width="100">
        <?php endif; ?>
        <input type="hidden" name="photo_actuelle" value="<?= $photo ?>"><br>
            
        <label for="prix">prix</label>
        <input type="text" name="prix" placeholder="le prix" id="prix" class="form-control" value="<?= $prix ?>">

        <label for="stock">stock</label>
        <input type="text" name="stock" id="stock" placeholder="stock" class="form-control" value="<?= $stock ?>">
        <br>

        <div class="text-center">
            <input type="submit" value="Enregistrer le produit" class="btn btn-primary">
        </div>

    </form>


<?php require_once('incAdmin/footer.php');  ?>


