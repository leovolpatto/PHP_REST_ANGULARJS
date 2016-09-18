CREATE DATABASE php_rest
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;


CREATE TABLE pessoas (
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    sobrenome VARCHAR(80) NOT NULL,
    idade INT,
    ativa BOOLEAN
);


CREATE TABLE servicos (
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL
);


CREATE TABLE historicos (
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idPessoa INT(8) UNSIGNED,
    idServico INT(8) UNSIGNED,
    descricao VARCHAR(100),
    valor decimal(8,2),
    `data` timestamp DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idPessoa)
        REFERENCES pessoas(id) ON DELETE CASCADE
    FOREIGN KEY (idServico)
        REFERENCES servicos(id) ON DELETE SET NULL
);