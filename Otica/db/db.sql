CREATE DATABASE db_otica;

USE db_otica;

CREATE TABLE adm (
  id INT PRIMARY KEY,
  login VARCHAR(50) NOT NULL,
  senha VARCHAR(50) NOT NULL
);

CREATE TABLE clientes (
  id_cliente INT PRIMARY KEY,
  nome_cliente VARCHAR(100) NOT NULL,
  cpf VARCHAR(14),
  cidade VARCHAR(30),
  telefone VARCHAR(20) NOT NULL,
  celular VARCHAR(20) NOT NULL,
  data_nascimento DATE,
  data_cadastro DATE,
  responsavel VARCHAR(24)
);

CREATE TABLE vendas (
  id_cliente INT,
  id_compra INT,
  id_geral INT,
  data_consulta DATE NOT NULL,
  medico VARCHAR(50),
  oe VARCHAR(50),
  dnp_oe VARCHAR(50),
  altura_oe FLOAT,
  od VARCHAR(50) ,
  dnp_od VARCHAR(50),
  altura_od FLOAT,
  adicao FLOAT,
  armacao VARCHAR(24),
  nr_pedido INT,
  lente VARCHAR(24),
  valor DECIMAL(10, 2),
  observacao TEXT,
  data_compra DATE NOT NULL,
  responsavel VARCHAR(24) NOT NULL
);
