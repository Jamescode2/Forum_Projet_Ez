<?php
include_once("function.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Project EZ</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- Bouton du header permettant l'inscription, la connection, la déconnection & la consultation du profil -->
    <header id="head">
        <?php if(isConnect()) { ?>
            <a id="btnDeco" href="deco.php">Se Deconnecter</a>
            <button class="pseudoBtn" id="profil" onclick="openProfil()">Profil</button>
        <?php }else{ ?>
            <button class="pseudoBtn" id="inscription" onclick="openInscription()">inscription</button>
            <button class="pseudoBtn" id="connection" onclick="openConnect()">Connection</button>
        <?php } ?>
        <h1 id="titre">LE FORUM DES GEEKEZ</h1>
    </header>
    <?php echo $retour; ?>
    <br><hr>
    
<!-- Modal d'inscription -->
    <div class="modal" id="modal1">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closeInscription()">X</span></div>
    <h2 style="text-align:center">-- Formulaire d'Inscription --</h2>
    <form class="form" action="utilisateur/create.php" method="post">
    <input class="pseudoTxtarea" type="text" placeholder="E-Mail" name="mail">
    <input class="pseudoTxtarea" type="text" placeholder="Pseudo" name="pseudo">
    <input class="pseudoTxtarea" type="password" placeholder="mot de passe" name="mdp">
    <div style="text-align:center;"><input type="submit" value="S'Inscrire" class="pseudoBtn"></div>
    </form>
    </div>
    
<!-- Modal de connection -->
    <div class="modal" id="modal2">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closeConnect()">X</span></div>
    <h2 style="text-align:center">-- Formulaire de Connection --</h2>
    <form class="form" action="accueil.php" method="post">
    <input class="pseudoTxtarea" type="text" placeholder="Pseudo" name="pseudo1">
    <input class="pseudoTxtarea" type="password" placeholder="mot de passe" name="mdp1">
    <div style="text-align:center;"><input type="submit" value="Se Connecter" class="pseudoBtn"></div>
    </form>
    </div>
    
<!-- Modal du Profil -->
    <div class="modal" id="modal3">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closeProfil()">X</span></div>
    <h2 style="text-align:center">-- Page du profil --</h2>
    <form action="utilisateur/destroy.php" method="post">
    <div class="icon">
    <h4>Pseudo: <?php echo $_SESSION['loginPostForm']?></h4><div class="tdIcons"><img src="./assets/edit.png" alt="edit" onclick="modifPseudo()"></div>
    </div>
    <div class="icon">
    <h4>Mot de Passe: <?php StarPass() ?></h4><div class="tdIcons"><img src="./assets/edit.png" alt="edit" onclick="modifMdp()"></div>
    </div>
    <div style="text-align:center;"><input name="btnDeleteAccount" type="submit" value="Supprimer son Compte" class="pseudoBtn"></div>
    </form>
    </div>
    
<!-- modifPseudo -->
    <div class="modal" id="modal4">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closemodifPseudo()">X</span></div>
    <h2 style="text-align:center">-- Modification de Pseudo --</h2>
    <form class="form" action="utilisateur/update.php" method="post">
    <input class="pseudoTxtarea" type="text" placeholder="newPseudo" name="newPseudo">
    <div style="text-align:center;"><input type="submit" value="modifPseudo" class="pseudoBtn"></div>
    </form>
    </div>
<!-- modifMdp -->
    <div class="modal" id="modal5">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closemodifMdp()">X</span></div>
    <h2 style="text-align:center">-- Modification de mot de passe --</h2>
    <form class="form" action="utilisateur/update.php" method="post">
    <input class="pseudoTxtarea" type="password" placeholder="newMdp" name="newMdp">
    <div style="text-align:center;"><input type="submit" value="modifMdp" class="pseudoBtn"></div>
    </form>
    </div>

    <br>
<!-- fenêtre de création d'un nouveau Topic -->
    <?php if(isConnect()) { ?>
    <div id="createTopic"><button class="pseudoBtn" id="createTopicBtn" onclick="openCreateTopic()">Créer un topic</button></div>
    <?php } ?>
    <div class="modal" id="modal6">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closeCreateTopic()">X</span></div>
    <h2 style="text-align:center">-- creer un nouveau Topic --</h2>
    <form action="forum/create.php" method="post">
    <input name="createTopic" class="create" type="text" placeholder="Ajouter un titre">
    <div style="text-align:center;"><input type="submit" id="creeTopic" value="Créer un nouveau Topic" class="pseudoBtn"></div>
    </form>
    </div>
<!-- modifTopic -->
    <div class="modal" id="modal7">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closemodifTopic()">X</span></div>
    <h2 style="text-align:center">-- Update topic --</h2>
    <h4 id="topicActuel">Nom du Topic Actuel : </h4>
    <form class="form" action="forum/update.php" method="post">
    <input type="hidden" id="recuperationId" name="id"/>
    <input class="pseudoTxtarea" type="text" placeholder="modifTopic" name="modifTopic" id="modifTopic">
    <div style="text-align:center;"><input type="submit" value="modifTopic" class="pseudoBtn" onclick="UpdateTopic()"></div>
    </form>
    </div>
<!-- fenêtre de création d'un nouveau Message -->
    <div class="modal" id="modal8">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closeCreateMessage()">X</span></div>
    <h2 style="text-align:center">-- Ajouter un message--</h2>
    <form action="message/create.php" method="post">
    <input type="hidden" id="topicAssocie" name="topicAssocie">
    <input name="createMessage" class="pseudoTxtarea2" id="content" contenteditable>&nbsp;</input>
    <div style="text-align:center;">
    <input type="submit" value="Ajouter le Message" class="pseudoBtn">
    </div>
    </form>
    </div>
<!-- modifMessage -->
    <div class="modal" id="modal9">
    <div style="width:100%;text-align:right"><span class="closeBtn" onclick="closemodifMessage()">X</span></div>
    <h2 style="text-align:center">-- Update Message --</h2>
    <form class="form" action="message/update.php" method="post">
    <input type="hidden" id="recupIdMessage" name="idMessage"/>
    <input class="pseudoTxtarea" type="text" placeholder="modifMessage" name="modifMessage" id="modifMessage">
    <div style="text-align:center;"><input type="submit" value="modifMessage" class="pseudoBtn" onclick="UpdateMessage()"></div>
    </form>
    </div>
<!-- Table des topics & début du forum -->
    <table id="conteneur">
        <tr>
            <td id="colone1">Icone</td>
            <td id="colone2">Nom du Topic</td>
            <td id="colone3">Créateur</td>
            <td id="colone4">Nombre de Msg</td>
            <td id="colone4">Nombre de vues</td>
            <td id="colone5">Supprimer le Topic</td>
        </tr>
    </table>
    
<!-- Table des Message -->
    <div style="margin-top:50px;">
    <?php if(isConnect()) { ?>
    <div id="createTopic"><button class="pseudoBtn" id="createTopicBtn" onclick="openCreateMessage()">Ajouter un Message</button></div>
    <?php } ?>
    <table id="conteneur">
        <tr>
            <td id="colone1">Icone</td>
            <td id="colone2">Nom du Message</td>
            <td id="colone3">Créateur</td>
            <td id="colone4">Nom du Topic</td>
            <td id="colone5">Supprimer Message</td>
        </tr>
    </table>
    <div>
        <table id="conteneur2" class="message">

        </table>
    </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><hr>
    <footer style="text-align:center;color:red;font-weight: bold;margin:10px 0;" >
        Forum EZ Créer par des GeekEZ
    </footer>
    <script src="assets/index.js"></script>
</body>
</html>