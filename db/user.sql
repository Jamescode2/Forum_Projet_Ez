CREATE TABLE `utilisateurs` (
    `id` int(15) NOT NULL AUTO_INCREMENT, 
    `mail` varchar(56) NOT NULL, 
    `pseudo` varchar(25) NOT NULL, 
    `mdp` varchar(60) NOT NULL, 
    `admin` tinyint(1) NOT NULL, 
    PRIMARY KEY(`id`)
);