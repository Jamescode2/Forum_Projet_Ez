<?php

require_once __DIR__.'/../utilisateur/Utilisateur.php';
require_once __DIR__.'/../message/Message.php';

class Forum
{
    private $nom;
    private $url;

    private $utilisateurs = [];
    private $messages = [];

    private $admins = [];
    /**
     * @param $nom
     * @param $url
     */
    public function __construct($nom, $url)
    {
        $this->nom = $nom;
        $this->url = $url;
    }

    public function ajouterAdmin(Admin $admin){
        $this->admins[$admin->getPseudo()] = $admin;
    }

    public function retirerAdmin(Admin $admin){
        unset($this->admins[$admin->getPseudo()]);

        //$pos_admin = array_search($admin, $this->admins, true);
    }

    public function inscrire(Utilisateur $utilisateur){

        if(isset($this->utilisateurs[$utilisateur->getPseudo()])){
            return;
        }

        //ajouter l'utilisateur à ma liste d'utilisateur
        $this->ajouterUtilisateur($utilisateur);
        //l'utilisateur doit m'ajouter à sa liste de forums
        $utilisateur->ajouterForum($this);
    }

    public function ajouterUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateurs[$utilisateur->getPseudo()] = $utilisateur;
    }

    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    public function ajouterMessage(Message $message)
    {
        $nom_auteur = $message
            ->getAuteur()
            ->getNom();

        if(!isset($this->messages[$nom_auteur])){
            $this->messages[$nom_auteur] = [];
        }

        $this->messages[$nom_auteur][] = $message;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getMessages(Utilisateur $utilisateur = null)
    {
        if($utilisateur === null){
            $tous_les_messages = [];
            foreach ($this->messages as $nomForum => $messages) {
                foreach($messages as $message){
                    $tous_les_messages[] = $message;
                }
            }
            return $tous_les_messages;
        }

        return $this->messages[$utilisateur->getPseudo()] ?? [];
    }

}

