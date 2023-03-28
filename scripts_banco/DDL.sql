CREATE TABLE
    tbl_auditoria
    (
        id_auditoria INT NOT NULL AUTO_INCREMENT,
        dsc_acao VARCHAR(100) NOT NULL,
        id_usuario INT NOT NULL,
        dt_acao DATETIME NOT NULL,
        PRIMARY KEY (id_auditoria),
        CONSTRAINT tblauditoria_fk_usuario FOREIGN KEY (id_usuario) REFERENCES tbl_usuario
        (id_usuario),
        INDEX tblauditoria_fk_usuario (id_usuario)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_cidade
    (
        id_cidade INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(120),
        uf INT(2),
        ibge INT(7),
        PRIMARY KEY (id_cidade)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Municipios das Unidades Federativas';
    
CREATE TABLE
    tbl_cisterna
    (
        id_cisterna INT NOT NULL AUTO_INCREMENT,
        fk_id_tp_construcao INT NOT NULL,
        fk_id_pais INT NOT NULL,
        fk_id_estado INT NOT NULL,
        fk_id_cidade INT NOT NULL,
        dsc_materiais VARCHAR(80) NOT NULL,
        nm_bairro VARCHAR(100) NOT NULL,
        st_cisterna TINYINT(1) DEFAULT '1' NOT NULL,
        dt_cadastro TIMESTAMP DEFAULT 'current_timestamp()' ON
    UPDATE
        CURRENT_TIMESTAMP,
        dt_inauguracao DATETIME NOT NULL,
        nr_latitude DECIMAL(10,8),
        nr_longitude DECIMAL(11,8),
        fk_id_entidade INT NOT NULL,
        nm_endereco VARCHAR(60) NOT NULL,
        PRIMARY KEY (id_cisterna),
        CONSTRAINT tbl_cisterna_fk_tbl_cidade FOREIGN KEY (fk_id_cidade) REFERENCES tbl_cidade
        (id_cidade) ,
        CONSTRAINT tbl_cisterna_fk_tbl_entidade FOREIGN KEY (fk_id_entidade) REFERENCES
        tbl_entidade (id_entidade) ,
        CONSTRAINT tbl_cisterna_fk_tbl_estado FOREIGN KEY (fk_id_estado) REFERENCES tbl_estado
        (id_estado) ,
        CONSTRAINT tbl_cisterna_fk_tbl_pais FOREIGN KEY (fk_id_pais) REFERENCES tbl_pais (id_pais)
        ,
        CONSTRAINT tbl_cisterna_fk_tbl_tipo_construcao FOREIGN KEY (fk_id_tp_construcao) REFERENCES
        tbl_tipo_construcao (id_tp_construcao),
        INDEX tbl_cisterna_fk_tbl_pais (fk_id_pais),
        INDEX tbl_cisterna_fk_tbl_estado (fk_id_estado),
        INDEX tbl_cisterna_fk_tbl_cidade (fk_id_cidade),
        INDEX tbl_cisterna_fk_tbl_tipo_construcao (fk_id_tp_construcao),
        INDEX tbl_cisterna_fk_tbl_entidade (fk_id_entidade)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_entidade
    (
        id_entidade INT NOT NULL AUTO_INCREMENT,
        nm_fantasia VARCHAR(100) NOT NULL,
        nr_cnpj VARCHAR(14) NOT NULL,
        fk_id_pais INT NOT NULL,
        fk_id_estado INT NOT NULL,
        fk_id_cidade INT NOT NULL,
        nr_cep VARCHAR(8) NOT NULL,
        nm_bairro VARCHAR(100) NOT NULL,
        nm_endereco VARCHAR(60) NOT NULL,
        nr_telefone VARCHAR(12) NOT NULL,
        st_entidade TINYINT(1) DEFAULT '1' NOT NULL,
        nr_ddd INT(2) NOT NULL,
        nm_observacao text,
        dt_cadastro TIMESTAMP DEFAULT 'current_timestamp()' ON
    UPDATE
        CURRENT_TIMESTAMP,
        PRIMARY KEY (id_entidade),
        CONSTRAINT tbl_entidade_fk_tbl_cidade FOREIGN KEY (fk_id_cidade) REFERENCES tbl_cidade
        (id_cidade) ,
        CONSTRAINT tbl_entidade_fk_tbl_estado FOREIGN KEY (fk_id_estado) REFERENCES tbl_estado
        (id_estado) ,
        CONSTRAINT tbl_entidade_fk_tbl_pais FOREIGN KEY (fk_id_pais) REFERENCES tbl_pais (id_pais),
        INDEX tbl_entidade_fk_tbl_pais (fk_id_pais),
        INDEX tbl_entidade_fk_tbl_estado (fk_id_estado),
        INDEX tbl_entidade_fk_tbl_cidade (fk_id_cidade)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_estado
    (
        id_estado INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(75),
        uf VARCHAR(2),
        ibge INT(2),
        id_pais INT(3),
        ddd VARCHAR(50),
        PRIMARY KEY (id_estado)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Unidades Federativas';
    
CREATE TABLE
    tbl_menu
    (
        id_menu INT NOT NULL AUTO_INCREMENT,
        id_menu_pai INT DEFAULT '1' NOT NULL,
        url_menu VARCHAR(100),
        dsc_menu VARCHAR(500),
        is_pag_inicial TINYINT(1) DEFAULT '0' NOT NULL,
        nm_menu VARCHAR(40) NOT NULL,
        nro_ordem INT DEFAULT '0' NOT NULL,
        is_submenu TINYINT(1) DEFAULT '0' NOT NULL,
        st_menu TINYINT(1) DEFAULT '1' NOT NULL,
        PRIMARY KEY (id_menu)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_pais
    (
        id_pais INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(60),
        nome_pt VARCHAR(60),
        sigla VARCHAR(2),
        bacen INT(5),
        PRIMARY KEY (id_pais)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Países e Nações';
    
CREATE TABLE
    tbl_perfil
    (
        id_perfil INT NOT NULL AUTO_INCREMENT,
        nm_perfil VARCHAR(40) COLLATE utf8_bin NOT NULL,
        dsc_perfil VARCHAR(500),
        id_nivel INT,
        st_perfil TINYINT(1) DEFAULT '1' NOT NULL,
        PRIMARY KEY (id_perfil)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_perfil_menu
    (
        id_perfil INT NOT NULL,
        id_menu INT NOT NULL,
        PRIMARY KEY (id_perfil, id_menu),
        CONSTRAINT tbl_perfil_menu_fk_menu FOREIGN KEY (id_menu) REFERENCES tbl_menu (id_menu) ON
    DELETE
        CASCADE,
        CONSTRAINT tbl_perfil_menu_fk_perfil FOREIGN KEY (id_perfil) REFERENCES tbl_perfil
        (id_perfil)
    ON
    DELETE
        CASCADE,
        INDEX tbl_perfil_menu_fk_menu (id_menu)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_tipo_construcao
    (
        id_tp_construcao INT NOT NULL AUTO_INCREMENT,
        nm_tp_construcao VARCHAR(100) NOT NULL,
        id_usuario INT NOT NULL,
        st_tp_contrucao TINYINT(1) DEFAULT '1' NOT NULL,
        dt_cadastro TIMESTAMP DEFAULT 'current_timestamp()' ON
    UPDATE
        CURRENT_TIMESTAMP,
        PRIMARY KEY (id_tp_construcao)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
CREATE TABLE
    tbl_usuario
    (
        id_usuario INT NOT NULL AUTO_INCREMENT,
        nm_login VARCHAR(20) COLLATE utf8_unicode_ci NOT NULL,
        nm_senha VARCHAR(50) NOT NULL,
        id_perfil INT,
        st_usuario TINYINT(1) DEFAULT '1' NOT NULL,
        PRIMARY KEY (id_usuario),
        CONSTRAINT tblusuario_fk_tbl_perfil FOREIGN KEY (id_perfil) REFERENCES tbl_perfil
        (id_perfil) ON
    DELETE
        NO ACTION
    ON
    UPDATE
        NO ACTION,
        INDEX tblusuario_fk_tbl_perfil (id_perfil)
    )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;