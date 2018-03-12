<?php
    session_start();

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=liste;charset=utf8', 'root', '');
    }

    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $req = $bdd->prepare('SELECT id_utilisateur FROM t_utilisateur WHERE utimail = :email');
    $req->bindParam(':email', $_POST['email']);
    $req->execute();


    $_SESSION['erreur'] = array();

    if (!preg_match('/^[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü\s\-]{3,20}$/', $_POST['nom'])) {
        $_SESSION['erreur']['nom'] = 'Votre nom doit faire entre 3 et 20 caractères et ne peux pas contenir de caractères spéciaux.';
    }

    if (!preg_match('/^[a-zA-Zàáâäçèéêëìíîïñòóôöùúûü\s\-]{3,20}$/', $_POST['prenom'])) {
        $_SESSION['erreur']['prenom'] = 'Votre prénom doit faire entre 3 et 20 caractères et ne peux pas contenir de caractères spéciaux.';
    }

    if (!preg_match('/^[\w\-\.]+@[\w\-\.]+\.[\w\-]{2,4}$/', $_POST['email'])) {
        $_SESSION['erreur']['email'] = 'Votre adresse mail est invalide.';
    } else  if ($req->rowCount() > 0) {
        $_SESSION['erreur']['email'] = 'Cette adresse mail est déjà enregistrée.';
    }

    if (!preg_match('/^[.\S]{4,16}$/', $_POST['mdp'])) {
        $_SESSION['erreur']['password'] = 'Votre mot de passe doit contenir entre 4 et 16 caractères et ne peux pas contenir d\'espace';
    }

    if ($_POST['mdpverif'] !=  $_POST['mdp']) {
        $_SESSION['erreur']['confirmation'] = 'Votre confirmation de mot de passe et votre mot de passe ne correspondent pas.';
    }

    if ($_FILES['photoprofil']['size'] > 0)
    {
        $dossier = 'assets/profil/';
        $fichier = basename($_FILES['photoprofil']['name']);
        $taille_maxi = 100000;
        $taille = filesize($_FILES['photoprofil']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['photoprofil']['name'], '.');

        //Début des vérifications de sécurité...
        if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg...';
        }
        if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
            //formatage du nom (suppression des accents, remplacements des espaces par "-")
            $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if(move_uploaded_file($_FILES['photoprofil']['tmp_name'], $dossier . $fichier)) //correct si la fonction renvoie TRUE
            {
                echo 'Upload effectué avec succès !';
                $chemin = $dossier . $fichier;

                if (empty($_SESSION['erreur'])) {
                    unset($_SESSION['erreur']);
                    $req = $bdd->prepare('INSERT INTO t_utilisateur (utiprenom, utinom, utimdp, utiemail, utiadresse, utiimage) VALUES (:prenom, :nom, :mdp, :email, :adresse , :photoprofil)');
                    $req->bindParam(':prenom', $_POST['prenom']);
                    $req->bindParam(':nom', $_POST['nom']);
                    $req->bindParam(':mdp', sha1($_POST['mdp']));
                    $req->bindParam(':email', $_POST['email']);
                    $req->bindParam(':adresse', $_POST['adresse']);
                    $req->bindParam(':photoprofil', $chemin);
                    $req->execute();
                    header('Location: connexion.php');
                }
            }
        } else {
            header('Location: index.php?page=inscription');
        }
    } else {
        if (empty($_SESSION['erreur'])) {
            unset($_SESSION['erreur']);
            $req = $bdd->prepare('INSERT INTO t_utilisateur (utiprenom, utinom, utimdp, utiemail, utiadresse) VALUES (:prenom, :nom, :mdp, :email, :adresse )');
            $req->bindParam(':prenom', $_POST['prenom']);
            $req->bindParam(':nom', $_POST['nom']);
            $req->bindParam(':mdp', sha1($_POST['mdp']));
            $req->bindParam(':email', $_POST['email']);
            $req->bindParam(':adresse', $_POST['adresse']);
            $req->execute();
            header('Location: connexion.php');
        } else {
            header('Location: index.php?page=inscription');
        }
    }

?>
