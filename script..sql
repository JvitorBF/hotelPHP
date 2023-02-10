create database hotel;

use hotel;

create table Hotel (
	id_hotel int PRIMARY KEY AUTO_INCREMENT,
    nome_hotel varchar(120) not null
);

create table Quarto (
    id_quarto int PRIMARY KEY AUTO_INCREMENT,
	num_quarto int not null,
    situacao boolean,
    qtd_cama int not null,
    id_hotel int not null, 
    FOREIGN key (id_hotel) REFERENCES Hotel(id_hotel)   
);

CREATE TABLE Locacao (
	id_locacao int PRIMARY KEY AUTO_INCREMENT,
    id_quarto int not null,
    data_entrada date,
    data_saida date,
    FOREIGN KEY (id_quarto) REFERENCES Quarto(id_quarto)    
);

INSERT INTO `hotel` (`id_hotel`, `nome_hotel`) VALUES (null, 'Residencial');
INSERT INTO `hotel`(`id_hotel`, `nome_hotel`) VALUES (null,'Centro Novo');

INSERT INTO `quarto`(`id_quarto`, `num_quarto`, `situacao`, `qtd_cama`, `id_hotel`) VALUES (null,101,false,1,1);
INSERT INTO `quarto`(`id_quarto`, `num_quarto`, `situacao`, `qtd_cama`, `id_hotel`) VALUES (null,102,false,2,1);
INSERT INTO `quarto`(`id_quarto`, `num_quarto`, `situacao`, `qtd_cama`, `id_hotel`) VALUES (null,101,false,1,2);
INSERT INTO `quarto`(`id_quarto`, `num_quarto`, `situacao`, `qtd_cama`, `id_hotel`) VALUES (null,102,false,2,2);