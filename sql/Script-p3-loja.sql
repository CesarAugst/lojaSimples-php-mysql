-- ==--==--==--==--==--==-- BERÇARIO -- ==--==--==--==--==--==--
/*
	START TRANSACTION;
	COMMIT;
	ROLLBACK ;
*/
-- create database p3;
SET time_zone='America/Sao_Paulo';
use p3;

-- ==--==--==--==--==--==-- TABELAS -- ==--==--==--==--==--==--
drop table if exists usuario;
create table usuario(
	id_usuario int auto_increment primary key,
    login varchar(255),
    senha varchar(255),
    nome varchar(255),
    email varchar(255),
    super_user boolean default false
);

drop table if exists produto;
create table produto(
	id_produto int auto_increment primary key,
    nome varchar(255),
    imagem varchar(255),
    valor decimal(10,2),
    descricao varchar(255),
    categoria varchar(255)
);
insert into produto values (default, 'vaca', 'default.jpg', 123.45, 'Mimosa pronta para ordenha', 'animal');

drop table if exists comentario;
create table comentario(
	id_comentario int auto_increment primary key,
    conteudo varchar(255),
    data datetime default now(),
    fk_autor int,
    fk_produto int
);

drop table if exists carrinho;
create table carrinho(
	id_carrinho int auto_increment primary key,
    fk_usuario int,
    fk_produto int,
    quantidade int
);

-- ==--==--==--==--==--==-- CRIA PROCEDURES -- ==--==--==--==--==--==--
-- cadastra usuario se nao existir, se existir retorna erro
DROP PROCEDURE IF EXISTS cadastra_usuario;
DELIMITER $$ 
	CREATE PROCEDURE cadastra_usuario(login_digitado varchar(255), senha varchar(255), nome varchar(255), email varchar(255))
    BEGIN
    declare existente varchar(255);
    set existente = (select login from usuario where login = login_digitado);
		IF login_digitado = existente THEN 
			select "cadastro ja existe" as erro;
		ELSE
			insert into usuario values(default,login_digitado,senha,nome,email, default);
		END IF;
    END 
$$ Delimiter ;

-- Busca a senha cadastrada com base no login para efetuar o login no php
DROP PROCEDURE IF EXISTS busca_senha_com_login;
DELIMITER $$ 
	CREATE PROCEDURE busca_senha_com_login(login_digitado varchar(255))
    BEGIN
		Select senha, id_usuario, super_user from usuario where login = login_digitado;
    END 
$$ Delimiter ;

-- Lista as categorias para exibir na hora de filtrarno checkbox  pela pesquisa
DROP PROCEDURE IF EXISTS lista_categorias;
DELIMITER $$ 
	CREATE PROCEDURE lista_categorias()
    BEGIN
		Select distinct categoria  as resultado from produto;
	END 
$$ Delimiter ;

-- Lista produtos para exibição pela categoria, se nao tiver categoria, mostra tudo
DROP PROCEDURE IF EXISTS lista_produtos;
DELIMITER $$ 
	CREATE PROCEDURE lista_produtos(categoria_digitada varchar(255), filtro_digitado varchar(255))
    BEGIN
		IF categoria_digitada = 'tudo' and filtro_digitado = 'tudo'THEN
			Select * from produto;
        ELSEIF categoria_digitada = 'tudo' THEN
			Select * from produto where nome like (concat('%',filtro_digitado,'%'));
		ELSEIF filtro_digitado = 'tudo' THEN
			Select * from produto where categoria = categoria_digitada;
		ELSE
			Select * from produto where categoria = categoria_digitada and nome like (concat('%',filtro_digitado,'%'));
        END IF;
    END 
$$ Delimiter ;

-- Lista comentarios com base no produto
DROP PROCEDURE IF EXISTS lista_comentarios_por_produto;
DELIMITER $$
	CREATE PROCEDURE lista_comentarios_por_produto (produto int)
	BEGIN
		select * from comentario where fk_produto = produto order by data DESC;
	END 
$$ DELIMITER ;

-- Lista tudo de determinado produto
DROP PROCEDURE IF EXISTS descricao_produto;
DELIMITER $$
	CREATE PROCEDURE descricao_produto (id_digitado int)
	BEGIN
		select * from produto where id_produto = id_digitado;
	END 
$$ DELIMITER ;

-- Insere um comentario
DROP PROCEDURE IF EXISTS insere_comentario;
DELIMITER $$
	CREATE PROCEDURE insere_comentario (conteudo text, id_autor int, id_produto int)
	BEGIN
		insert into comentario values (default, conteudo, default, id_autor, id_produto);
	END 
$$ DELIMITER ;

-- exclui um comentario
DROP PROCEDURE IF EXISTS exclui_comentario;
DELIMITER $$
	CREATE PROCEDURE exclui_comentario (id_digitado int)
	BEGIN
		DELETE FROM comentario WHERE id_comentario = id_digitado;
	END 
$$ DELIMITER ;

-- torna ou retira super privilégios
DROP PROCEDURE IF EXISTS seta_super;
DELIMITER $$
	CREATE PROCEDURE seta_super(id_digitado int, operacao boolean)
	BEGIN
		IF operacao = true THEN
			UPDATE usuario SET super_user = 1 WHERE id_usuario= id_digitado;
        ELSE
			UPDATE usuario SET super_user = 0 WHERE id_usuario= id_digitado;
		END IF;
	END 
$$ DELIMITER ;

-- Insere um produto
DROP PROCEDURE IF EXISTS insere_produto;
DELIMITER $$
	CREATE PROCEDURE insere_produto (nome varchar(100), imagem varchar(255), valor decimal (6,2), descricao text, categoria varchar(255))
	BEGIN
		insert into produto values (default, nome, imagem, valor, descricao, categoria);
	END 
$$ DELIMITER ;

-- exclui um produto no sistema
DROP PROCEDURE IF EXISTS exclui_produto;
DELIMITER $$
	CREATE PROCEDURE exclui_produto (id_digitado int)
	BEGIN
		DELETE FROM produto WHERE id_produto = id_digitado;
	END 
$$ DELIMITER ;

-- Insere um produto no carrinho
DROP PROCEDURE IF EXISTS adiciona_produto_carrinho;
DELIMITER $$
	CREATE PROCEDURE adiciona_produto_carrinho (id_usuario int, id_produto int, quantidade int)
	BEGIN
		insert into carrinho values (default, id_usuario, id_produto, quantidade);
	END 
$$ DELIMITER ;

DROP PROCEDURE IF EXISTS lista_carrinho;
DELIMITER $$
	CREATE PROCEDURE lista_carrinho (id_usuario int)
	BEGIN
		select * from carrinho where fk_usuario = id_usuario;
	END 
$$ DELIMITER ;

DROP PROCEDURE IF EXISTS remove_carrinho;
DELIMITER $$
	CREATE PROCEDURE remove_carrinho (id_digitado int)
	BEGIN
		DELETE FROM carrinho WHERE id_carrinho = id_digitado;
	END 
$$ DELIMITER ;


DROP PROCEDURE IF EXISTS comprar_carrinho;
DELIMITER $$
	CREATE PROCEDURE comprar_carrinho (id_digitado int)
	BEGIN
		DELETE FROM carrinho WHERE fk_usuario = id_digitado;
	END 
$$ DELIMITER ;

SET SQL_SAFE_UPDATES = 0;
-- ==--==--==--==--==--==-- USAR PROCEDURES -- ==--==--==--==--==--==--
-- use p3;
/*
-- (carrinho)
select * from carrinho
	CALL comprar_carrinho(1);
	CALL lista_carrinho(1);
	CALL adiciona_produto_carrinho(1,3,5);
    CALL remove_carrinho(1);
    
-- (usuario)
select * from usuario
	CALL procura_id_pelo_usuario('cc');
	CALL procura_nome_pelo_id(1);
    CALL busca_senha_com_login('login');
	CALL cadastra_usuario('login4','senha2','nome2','email2@email2.com');
    CALL seta_super(1,1);
    
-- (produto)
select * from produto;
	CALL exclui_produto(1);
	CALL descricao_produto(1);
	CALL lista_produtos('tudo','tudo');
	CALL lista_categorias();
    CALL insere_produto('gelo', 'default.jpg', 12.25, 'agua no estado solido', 'solidos');
    
-- (comentario)
select * from comentario;
	CALL exclui_comentario(2);
	CALL insere_comentario('batata', 6, 1);
    CALL lista_comentarios_por_produto(1);
*/