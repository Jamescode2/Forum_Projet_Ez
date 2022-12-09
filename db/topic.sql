CREATE TABLE `topic` (
    `id` int(15) NOT NULL AUTO_INCREMENT, 
    `pseudo` varchar(25) NOT NULL, 
    `topic` varchar(56) NOT NULL, 
    `date` DATETIME,
    PRIMARY KEY(`id`)
);