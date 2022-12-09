<?php

require_once __DIR__.'/../forum/Forum.php';
require_once __DIR__.'/../message/Message.php';

class Utilisateur
{
    private $mail;
    private $pseudo;
    private $mdp;

    //private $estAdmin = false;

    private $forums = [];
    private $messages = [];

    /*
     * [
     *  'nom_forum1' => ['mon_message1','mon_message37'],
     *  'nom_forum2' => ['mon_message0','mon_message42']
     * ]
     */

    private $enRelation = [];

    /*
     * [
     * 'amitié' => [ 'John', 'jack', 'JC' ],
     * 'archEnnemy' => ['Le bouffon vert', 'ta maman']
     * ]
     *
     *
     */

    /**
     * @param $pseudo
     * @param $nom
     * @param $prenom
     */
    public function __construct($id, $mail, $pseudo, $mdp)//, $estAdmin = false)
    {
        $this->id = $id;
        $this->mail = $mail;
        $this->pseudo = $pseudo;
        $this->mdp = $mdp;

        //$this->estAdmin = $estAdmin;
    }

    public function ajouterForum(Forum $forum)
    {
        $this->forums[]= $forum;
    }

    /**
     * @return array
     */
    public function getForums()
    {
        return $this->forums;
    }

//    public function inscrire(Forum $forum, Utilisateur $utilisateur = null){
//        if($this->estAdmin){
//            // ($u ?? $autreValeur) -> si $u n'est pas null renvoie $u sinon renvoie autre valeur
//            $forum->inscrire($utilisateur ?? $this);
//        }
//    }

    public function ecrire_message(Forum $forum,string $contenu) : Message
    {
        $message = new Message($contenu, $forum, $this, date('Y-m-d'));

        if(!isset($this->messages[$forum->getNom()])){
            $this->messages[$forum->getNom()] = [];
        }
        $this->messages[$forum->getNom()][] = $message;
        $forum->ajouterMessage($message);

        return $message;
    }

    public function creerAmitie(Utilisateur $ami){
        if($ami !== $this){
            $this->ajouterEnRelation('amitié', $ami);
            $ami->ajouterEnRelation('amitié', $this);
            return true;
        }
        return false;
    }

//    public function ajouterAmi(Utilisateur $ami){
//        $this->amis [] = $ami;
//    }

    /**
     * @return array
     */
    public function getEnRelation(string $relation): array
    {
        return isset($this->enRelation[$relation]) ?
                $this->enRelation[$relation] : [];
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @return mixed
     */
    public function getMdp()
    {
        return $this->mdp;
    }



    public function getMessages(Forum $forum = null)
    {
        if($forum === null){
            $tous_les_messages = [];
            foreach ($this->messages as $nomForum => $messages) {
                foreach($messages as $message){
                    $tous_les_messages[] = $message;
                }
            }
            return $tous_les_messages;
        }

        return $this->messages[$forum->getNom()] ?? [];
    }

//    public function setEstAdmin(bool $estAdmin)
//    {
//        $this->estAdmin = $estAdmin;
//    }
    private function ajouterEnRelation(string $relation, Utilisateur $utilisateur)
    {


        if(! isset($this->enRelation[$relation])){
            $this->enRelation[$relation] = [];
        }

        $this->enRelation[$relation][$utilisateur->getPseudo()] = $utilisateur;

    }


}