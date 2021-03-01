# docker-composer
## _The Last Markdown Editor, Ever_

[![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)



Projeto utilizando docker-composer. Esse projeto atua em cima de uma arquitetura de micro serviços, a ideia é realizar um ambiente completo de desenvolvimento,  dentro de um cenario de infraestrutura completa e robusta. A infra acontece por meios de redirecionamento usado nesse caso o nginx como proxy reverso.  Temos a seguinte rotas


## Ambiente store

- /store, esta rota balanceia entre dois webs, a aplicação presente nesses webs consulta o banco de dados a procura do cliente x, neste momento gera-se uma sessão para o cliente X utilizando o ID do cliente, ou seja guarda a sessao no PHP
- utilizando docker-composer é criado uma tabela no banco de dados "carrinho" e atribui o valor do carrinho na sessão, então devemos recuperar via SELECT dados e nome do cliente para ser exibido na tela, caso nao haja chave de cache para este cliente, gera-se uma chave, na segunda busca deverar trazer dados do cache


## Ambiente WEB API
- rota /web_api cai no web de web_api, a aplicação tera uma rota chamada  /web_api/cart que trará os dados da sessão, em formato JSON com informações da sessão



## Ambiente CHECKOUT
- ROTA /checkout, cai no checkout web, aplicação receberá como parametro a sessão do cliente, e com base nisso fará uma busca na API utilizando a sessão. Com o retorno sera feita uma busca em tempo real de todos os dados do cliente e carrinho que estão na sessão


## Comandos mais utilizados

```sh
- docker-compose build
- docker-compose up -d
- docker-compose stop
```
## Tools and Stack utilizados

[Mysql](https://docs.oracle.com/cd/E17952_01/index.html)
[Nginx](https://www.nginx.com/)
[PHP](https://www.php.net/)
[Graylog](https://www.graylog.org/products/open-source)
[Grafana](https://grafana.com/)
[Docker](https://docs.docker.com/)
[Docker Composer](https://docs.docker.com/compose/)
[ELK](https://www.elastic.co/pt/learn)
## Conceitos importantes para esse projeto
- Entender o conceito de redes e redirecionamento
- Conceito de proxy reverso
- Banco de dados
- Monitoramento 
- Observabilidade
- Conceitos e noções de cache 
- 

/report -> Elastic
/checkout -> Banco + comunicação externa
/store > app +banco + cache + sessão
/logs -> Conectar no graylog
/web_api -> Retorna Json



