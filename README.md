# About

Applying brokering load only makes sense in the tax context of Brazil. However it can be an example application that uses Docker container and Docker Compose. Simplified Architecture

* Apache / PHP 7.2
* FormDin PHP FrameWork
* Apache Tika - to extract information from PDFs
* MySQL

Summary of operation: A user using a web application sends a PDF file. The text of the PDF file is extracted using the apache tika that storing in MySQL.

Aplicação em php para testar carga de arquivos de corretagem em pdf, utilizando docker-compose e apache-tika.

situation: IN DEVELOPMENT

## PT-BR
Aplicarção carga corretagem só faz sentido no contexto tributario do Brasil. Contudo pode ser um exemplo de aplicação que usa container Docker e Docker Compose. Arquitetura simplificada

* Apache / PHP 7.2
* FormDin PHP FrameWork
* Apache Tika - para extrair informações dos PDFs
* MySQL

Resumo do funcionamento: Um usuario usando uma aplicação web envia um arquivo PDF. O texto do arquivo PDF é extraido usando o apache tika que armazendo no MySQL.

situação: EM DESENVOLVIMENTO


# Windows 7 

## Requisito
* Espaço em Disco : aproximadamente 2 GB no C:

## Instalação

1. Instalar o [Docker ToolBox](https://docs.docker.com/toolbox/toolbox_install_windows/). O Docker tem todo o ambiente para rodar aplicação.
1. Instalar o git para baixar com maior facilidade as atualizações.
1. Em documentos do usuário criar a pasta Kitematic
1. Entrar na pasta Kitematic via Windows Explorar, na barra de endereço digitar CMD
1. No terminal do Windows digitar `git clone https://github.com/bjverde/cargaCorretagem.git`
1. Editar o aquivo docker-compose.yml, pode usar um editor de texto simples (o bloco de notas ou notepad++ ou equivalente).
1. Clicar no *Docker Quickstart Terminal*. Essa tarefa pode demorar alguns segundos
1. Digitar o comando `cd /c/Users/<SEU USUARIO DO WINDOWS>/Documents/Kitematic/cargaCorretagem/`. Subistituindo o `<SEU USUARIO DO WINDOWS>` pelo seu usuario do windows.
1. Digitar o comando `docker-compose up --build` - para montar todo o ambiente nescessario. Essa etapa é demorada e pode levar alguns minutos dependendo da velocidade da sua internet.




# Windows 10

## Instalação

1. Instalar Docker. Seguir o tutorial do [mundo docker](https://www.mundodocker.com.br/docker-no-windows-10/)
