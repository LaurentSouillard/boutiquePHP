<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <ul class="nav navbar-default navbar-fixed-top">
        <li class="nav-item">
            <a class="nav-link" href="#">Accueil</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">BackOffice</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">panier</a>
        </li>
        <?php if(!internauteEstConnecte()): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>inscription.php">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>connexion.php">Connexion</a>
            </li>
        <?php else: ?> 
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>profil.php">profil</a>
            </li>
        <?php endif; ?>    
    </ul>

    <!-- la div suivante va nous permettre d'inserer du contenu propre à chaque page entre le haut.inc.php et le bas.inc.php --> 
    <div class="container">
    
  