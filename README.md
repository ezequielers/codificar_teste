# Projeto codificar

### Considerações
Toda a aplicação foi desenvolvida utilizando o Framework Laravel Tinker com banco de dados Mysql, NGinx e PHP-FPM 7.3, tudo isso utiliando conteinerização Docker.

### Requisitos
Para que o projeto possa ser executado será necessário ter instalado no ambiente o docker e docker-compose.

## Passos para subir o ambiente
Para que o ambiente seja executado os passas a seguir devem ser seguidos:
### Passos 1
Dentro do diretório executar o camando:
```
docker-compose up -d
```
Após ser executada a instalação dos requisitos o servidor estará online então será nexessária a instalação do vendor do composer usando o seguinte comando:
```
docker exec -ti php_fpm composer install
```
Após a instalação do vendor o servidor Laravel estará em funcionamento e poderá ser testado pelo seguinte endereço **http://localhost:8080**

### Passo 2
Após executar a instalação do composer chegou a hora de configurar o ambiente, para isto execute os seguintes comandos:
```
docker exec -ti php_fpm php artisan key:generate
```
```
docker exec -ti php_fpm php artisan config:cache
```
Para criar as tabelas necessárias execute o seguinte comando:
```
docker exec -ti php_fpm php artisan migrate
```
### Passo 3
Após criada a estrutura de banco de dados será necessário fazer a população das tabelas para tal será necessário executar a seguinte sequencia de comandos:
#### Usando o terminal
```
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/1
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/2
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/3
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/4
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/5
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/6
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/7
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/8
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/9
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/10
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/11
docker exec php_fpm curl http://172.19.128.3/api/armazena/despesas/2017/12
docker exec php_fpm curl http://172.19.128.3/api/armazena/redes
```
#### Usando o navegador
```
http://localhost:8080/api/armazena/despesas/2017/1
http://localhost:8080/api/armazena/despesas/2017/2
http://localhost:8080/api/armazena/despesas/2017/3
http://localhost:8080/api/armazena/despesas/2017/4
http://localhost:8080/api/armazena/despesas/2017/5
http://localhost:8080/api/armazena/despesas/2017/6
http://localhost:8080/api/armazena/despesas/2017/7
http://localhost:8080/api/armazena/despesas/2017/8
http://localhost:8080/api/armazena/despesas/2017/9
http://localhost:8080/api/armazena/despesas/2017/10
http://localhost:8080/api/armazena/despesas/2017/11
http://localhost:8080/api/armazena/despesas/2017/12
http://localhost:8080/api/armazena/redes
```

### Acessando os dados
Para visualizar o resultado dos dados ser utilizado um cliente REST ( Postman, SOAP Ui, etc ), usando o seguinte endereço para obter a listagem de despesas:
```
http://localhost:8080/api/pesquisa/listaDespesas?ano={ano}&mes={mes}&limit={limite}
```
Os parâmetros a serem passados são:
- `{ano}`, será setado o ano correspondente (2017 que foi importado)
- `{mes}`, será setado o mes correspondente sem zeros a esquerda
- `{limite}`, a quantidade de registros a serem retornados

Para visualizar o resultado dos dados ser utilizado um cliente REST ( Postman, SOAP Ui, etc ), usando o seguinte endereço para obter a listagem de redes sociais:
```
http://localhost:8080/api/pesquisa/lista-redes
```
