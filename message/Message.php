<?php

require_once __DIR__.'/../utilisateur/Utilisateur.php';
require_once __DIR__.'/../forum/Forum.php';

class Message
{

    private $contenu;
    private $forum;
    private $auteur;
    private $date;

    /**
     * @param $contenu
     * @param $forum
     * @param $auteur
     * @param $date
     */
    public function __construct($contenu, $forum, $auteur, $date)
    {
        $this->contenu = $contenu;
        $this->forum = $forum;
        $this->auteur = $auteur;
        $this->date = $date;
    }

    public function __toString(): string
    {
        return $this->contenu.' - '.$this->auteur->getPseudo().' - '.$this->date;
    }


}