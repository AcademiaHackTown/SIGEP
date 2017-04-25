# SIGEP
Sistema de Gerenciamento de Projeto

O Sistema de Gerenciamento de Projeto é uma ferramenta desevolvida para auxiliar integrantes e setores responsáveis por projetos de pesquisa e extensão. Foi desenvolvivido para funcionar em um ambiente web com conexão a um servidor de banco de dados.

## Funcionalidades

O sistema conta com 6 níveis de usuário, com a seguinte ordem:

1. Coordenador
2. Colaborador
3. Bolsista - Graduação **
4. Bolsista - Médio **
5. Adminstrador
6. Aluno

As funcionalidade então são divididas de acordo com o nível de cada usuário.

- Coordenador
	- Supervisão de membros do projeto
		- Atribuição de Tarefas
		- Análise de Tarefas (aprovar / devolver para correção)
		- Visualização dos Registros de Atividades submetidos pelos bolsistas
	- Registro de Atividades
	- Relatório de alunos (no caso do projeto em questão estar envolvido com algum tipo de curso / treinamento)
	- Edição de dados cadastrais do projeto
- Colaborador
	* Em desenvolvimento
- Bolsista (Graduação e Médio)
	- Acesso às tarefas atribuidas pelo coordenador
		- Pendentes
		- Em avaliação (já submetidas)
		- Aprovadas
	- Submissão de tarefas pendentes
	- Upload de arvquivos para a área de alunos (ver a sessão *Alunos* deste arquivo)
	- Registro de Atividades
		- Preenchimento
		- Visualização (com versão para impressão)
- Administrador
	* Projetos
	- Cadastro de projetos
	- Destivação de projetos
	- Edição de dados cadastrais do projeto
	* Contas
	- Ativação de contas
	- Desativaçao de contas
	- Alteração do tipo geral da conta (ver a seção *Tipos de Usuário* deste arquivo)
- Aluno
	- Sessão de notícias (em desenvolvimento)
	- Visualização de arquivos upados pelo(s) bolsista(s) do projeto em questão
		- Apostila do curso / treinamento
		- Slides
		- Atividades
		- Outros downloads

## Alunos

O sistema tem uma área para o tipo de usuário "Aluno". Esta seção do sistema, foi pensada para projetos que envolvam algum tipo de curso ou treinamento
durante o seu desenvolver.

## Tipos de Usuário

Os seguintes tipos de usuário estão presentes no sistema:

1. Coordenador
2. Colaborador
3. Bolsista - Graduação **
4. Bolsista - Médio **
5. Adminstrador
6. Aluno

Como visto na seção **Funcionalidades**.

Existem duas classificações para em relação ao tipo de um usuário. 

- Tipo Geral
- Tipo Específico

#### Tipo Geral
	
	O tipo geral de um usuário remete à sua função no sistema. O adminstrador por exemplo tem seu tipo de usuário definido como **Adminstrador**.
Um usuário que será coordenador em algum projeto deve ser do tipo geral **Coordenador**, pois, os outros tipos não podem possuir projetos. Esta referência é tratada na própria tabela do usuário e pode ser mudada a qualquer momento pelo Adminstrador do sistema.

#### Tipo Específico

	O tipo específico de um usuário é a representação de sua função no projeto na qual está vinculado. Desta forma, um usuário tendo o tipo geral **Coordenador**, pode ser **Bolsista** em um outro projeto, por meio do tipo específico atribuido a ele em relação àquele projeto.
