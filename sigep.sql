CREATE TABLE `pessoa` (
    `PSCODINT` int(11) NOT NULL,
    `PSCPFCHA` char(11) COLLATE utf8_bin NOT NULL COMMENT 'CPF da pessoa',
    `PSTPFINT` int(11) NOT NULL COMMENT 'FK TPUSUINT',
    `PSNOMCHA` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'Nome da pessoa',
    `PSRGCHAR` char(30) COLLATE utf8_bin NOT NULL COMMENT 'RG',
    `PSEXPCHA` char(30) COLLATE utf8_bin NOT NULL COMMENT 'Orgão expedidor',
    `PSEXPDAT` char(30) COLLATE utf8_bin NOT NULL COMMENT 'Data de expedição',
    `PSMAECHA` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'Nome da mae',
    `PSPAICHA` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'Nome do pai',
    `PSCEPCHA` char(30) COLLATE utf8_bin NOT NULL,
    `PSRUAVCH` varchar(50) COLLATE utf8_bin NOT NULL,
    `PSNUMVCH` char(6) COLLATE utf8_bin NOT NULL,
    `PSNBAVCH` varchar(50) COLLATE utf8_bin NOT NULL,
    `PSCOMVAR` char(50) COLLATE utf8_bin NOT NULL COMMENT 'Complemento',
    `PSTELCHA` char(30) COLLATE utf8_bin NOT NULL,
    `PSCELCHA` char(30) COLLATE utf8_bin NOT NULL,
    `PSSENHACHA` varchar(120) COLLATE utf8_bin DEFAULT NULL,
    `PSEMVCH` varchar(30) COLLATE utf8_bin NOT NULL,
    `PSATINT` int(1) DEFAULT '0' COMMENT 'Ativacao da Conta',
    constraint pk_pessoa primary key (PSCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Dados da pessoa';

CREATE TABLE `tipo_projeto` (
    `TPCODINT` int(11) NOT NULL,
    `TPNOMCHA` char(20) DEFAULT NULL,
    `TPDESVAR` varchar(100) NOT NULL DEFAULT 'indefinido',
    constraint pk_tipo_projeto primary key (TPCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `projeto` (
    `PRCODINT` int(11) NOT NULL COMMENT 'Código do Projeto',
    `PRTITVAR` varchar(200) COLLATE utf8_bin NOT NULL,
    `PRAPEVAR` varchar(40) COLLATE utf8_bin DEFAULT 'Nenhum titulo definido',
    `PRRESVAR` text COLLATE utf8_bin NOT NULL,
    `PRCHVVAR` varchar(100) COLLATE utf8_bin NOT NULL,
    `prcoordint` int(11) NOT NULL COMMENT 'FK de coordenador',
    `PRCRVAR` varchar(8000) COLLATE utf8_bin DEFAULT NULL,
    `PRDTIDAT` char(40) COLLATE utf8_bin DEFAULT NULL,
    `PRDTFDAT` char(40) COLLATE utf8_bin DEFAULT NULL,
    `PRSTAINT` tinyint(1) NOT NULL DEFAULT '0',
    `PRTPFINT` int(11) NOT NULL COMMENT 'fk de tipo projeto',
    constraint pk_projeto primary key (PRCODINT),
    constraint fk_prpsf foreign key (prcoordint) references pessoa(PSCODINT),
    constraint fk_prtpf foreign key (PRTPFINT) references tipo_projeto(TPCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Dados do projeto';

CREATE TABLE `arquivos` (
    `ARIDINT` int(11) NOT NULL,
    `ARARQCHA` varchar(100) COLLATE utf8_bin NOT NULL,
    `ARTPINT` int(11) NOT NULL,
    `ARPRFINT` int(11) NOT NULL,
    `ARPSFINT` int(11) NOT NULL,
    constraint pk_arquivos primary key (ARIDINT),
    constraint fk_arprf    foreign key (ARPRFINT) references projeto(PRCODINT),
    constraint fk_arpsf    foreign key (ARPSFINT) references pessoa(PSCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `atividade` (
    `ATCODINT` int(11) NOT NULL,
    `ATPRFINT` int(11) NOT NULL,
    `ATDESVAR` text COLLATE utf8_bin NOT NULL,
    constraint pk_atividade primary key (ATCODINT),
    constraint fk_atprf     foreign key (ATPRFINT) references projeto(PRCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `cronograma_projeto` (
    `CPCODINT` int(11) NOT NULL,
    `CPPRFINT` int(11) DEFAULT NULL COMMENT 'FK de projeto',
    `CPATFINT` int(11) NOT NULL COMMENT 'FK de atividade',
    `CPME1INT` int(1) DEFAULT '0',
    `CPME2INT` int(1) DEFAULT '0',
    `CPME3INT` int(1) DEFAULT '0',
    `CPME4INT` int(1) DEFAULT '0',
    `CPME5INT` int(1) DEFAULT '0',
    `CPME6INT` int(1) DEFAULT '0',
    `CPME7INT` int(1) DEFAULT '0',
    `CPME8INT` int(1) DEFAULT '0',
    `CPME9INT` int(1) NOT NULL DEFAULT '0',
    `CPME10INT` int(1) NOT NULL DEFAULT '0',
    `CPME11INT` int(1) NOT NULL DEFAULT '0',
    `CPME12INT` int(1) NOT NULL DEFAULT '0',
    constraint pk_cronograma_projeto primary key (CPCODINT),
    constraint fk_cpprf             foreign key (CPPRFINT) references projeto(PRCODINT),
    constraint fk_cpatf             foreign key (CPATFINT) references atividade(ATCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `pessoa_projeto` (
    `PPCODINT` int(11) NOT NULL,
    `PPPRFINT` int(11) NOT NULL COMMENT 'FK DE Código Projeto',
    `PPPSFINT` int(11) NOT NULL COMMENT 'FK DE Código pessoa',
    `PPTPFINT` int(11) NOT NULL COMMENT 'Tipo de Pessoa no projeto',
    `PPPLVCH` varchar(8000) COLLATE utf8_bin NOT NULL DEFAULT 'Nenhum',
    constraint pk_pessoa_projeto primary key (PPCODINT),
    constraint fk_ppprf foreign key (PPPRFINT) references projeto(PRCODINT),
    constraint fk_pppsf foreign key (PPPSFINT) references pessoa(PSCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Pessoas do Projeto';

CREATE TABLE `registro_atividade` (
    `RACODINT` int(11) NOT NULL,
    `RACONTVAR` varchar(8000) COLLATE utf8_bin NOT NULL,
    `RADTEDAT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `RADTADAT` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `RAPSCODINT` int(11) NOT NULL DEFAULT '0' COMMENT 'FK DE PESSOA',
    `RAPRFINT` int(11) NOT NULL DEFAULT '0' COMMENT 'FK DE PROJETO',
    `RADTLVAR` text COLLATE utf8_bin NOT NULL,
    constraint pk_registro_atividade primary key (RACODINT),
    constraint fk_rapsf foreign key (RAPSCODINT) references pessoa(PSCODINT),
    constraint fk_raprf foreign key (RAPRFINT) references projeto(PRCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `tarefas` (
    `tratfint` int(11) NOT NULL COMMENT 'FK de Atvidade',
    `trcodint` int(11) NOT NULL COMMENT 'Código da tarefa',
    `trdesvar` varchar(1000) NOT NULL COMMENT 'Descrição da tarefa',
    `trdticha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Data inicio',
    `trdtfcha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Data fim',
    `trstaint` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Status da terefa Sim Não Parcial',
    `trpsfint` int(11) NOT NULL COMMENT 'FK de pessoa a quem a tarefa foi atribuida',
    `trprfint` int(11) NOT NULL COMMENT 'FK de projeto',
    `trtitvar` varchar(100) NOT NULL DEFAULT 'Titulo da tarefa',
    constraint pk_tarefas primary key (trcodint),
    constraint fk_tratf foreign key (tratfint) references atividade(ATCODINT),
    constraint fk_trpsf foreign key (trpsfint) references pessoa(PSCODINT),
    constraint fk_trprf foreign key (trprfint) references projeto(PRCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tarefa_entrega` (
    `TECODINT` int(11) NOT NULL,
    `TECONTVAR` text COLLATE utf8_bin NOT NULL,
    `TEARQVAR` varchar(4000) COLLATE utf8_bin NOT NULL,
    `TETRFINT` int(11) NOT NULL COMMENT 'FK de tarefa',
    `TEPSFINT` int(11) NOT NULL COMMENT 'FK de pessoa',
    `TEDATDAT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    constraint pk_tarefa_entrega primary key (TECODINT),
    constraint fk_tetrf foreign key (TETRFINT) references tarefa(trcodint),
    constraint fk_tepsf foreign key (TEPSFINT) references pessoa(PSCODINT)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;