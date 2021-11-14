CREATE TABLE `perks`(  
  `id_perks` INT NOT NULL AUTO_INCREMENT,
  `id_products` INT NOT NULL,
  `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`id_perks`)
);
