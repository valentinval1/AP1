<?php session_start();

if(isset($_SESSION['erreur']))
{
    $error = $_SESSION['erreur'];
}

 if (!empty($error))
{ ?>
    <div class="alert alert-danger pt-4 my-5">
      <p class="mb-2"><strong>Les erreurs suivantes sont survenues :</strong></p>
      <ul>
        <?php foreach ($error as $msg) { ?>
          <li><?php echo $msg; ?></li>
          <?php } ?>
      </ul>
    </div>
    <?php
  } ?>

<h1>Inscription</h1>
  <form action="inscriptiontraitement.php" method="post"  enctype="multipart/form-data">

    <input type='hidden' name='MAX_FILE_SIZE' value='250000'>

    <label for="nom"><span class="gras">Nom</span><input type="text" name="nom" class="form-control taille" id="nom" placeholder="Votre nom" required></label><br/>
    
    <label for="prenom"><span class="gras">Prénom</span><input type="text" name="prenom" class="form-control taille" id="prenom" placeholder="Votre prénom" required></label><br/>

    <label for="email"><span class="gras">Adresse mail</span><input type="email" name="email" class="form-control taille" id="email" placeholder="ex: cesi@hotmail.fr" required></label> <br/>

    <label for="adresse"><span class="gras">Adresse</span><input type="text" name="adresse" class="form-control taille" id="adresse" placeholder=" ex:390 rue du Général , 76000 - Rouen" required></label> <br/>

    <label for="mdp"><span class="gras">Mot de passe</span><input type="password" name="mdp" class="form-control taille" id="mdp" required></label><br/>

    <label for="mdpverif"><span class="gras">Vérification mot de passe</span><input type="password" name="mdpverif" class="form-control taille" id="mdpverif" required></label><br/>

    <label for="photoprofil"><span class="gras">Photo de profil</span><br/><input type="file" name="photoprofil" class="taille3" id="photoprofil"></label><br/><br/>

    <input type="submit" name="envoie" value="S'inscrire" class="btn btn-primary taille2 decal3">
  </form>
