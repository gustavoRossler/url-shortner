# Comandos no console para rodar o projeto

Na pasta principal do projeto você encontrará um arquivo .env com as configurações do projeto.

Está preenchido com um template da configuração.

Você pode alterar o nome de usuário do banco de dados, senha, e até mesmo as portas de acesso caso necessário.

As alterações devem ser feitas antes de subir os containers.



### 1 - Clonar repositório
```bash
git clone https://github.com/gustavoRossler/url-shortner.git
```

### 2 - Acessar o diretório do projeto clonado
```bash
cd url-shortner
```
(Sendo url-shortner o nome da pasta criada)

### 3 - Subir os containers 
```bash
docker-compose up -d
```
(O SO pode pedir permissão para acessar os diretórios dos volumes criados nessa etapa)

### 4 - Rodar o composer para instalar os módulos PHP e scripts necessários
```bash
docker-compose exec app composer install
```

### Opcional
Pode rodar os tests para ver se está tudo funcionando
```bash
docker-compose exec app php artisan test
```


# Rotas da API

## Usuários:
- Criar:

**Método:** POST

http://localhost:8080/api/users

| Parâmetro | Tipo   |
| :-------: | :----: |
| name      | string |
| email     | string |


------

- Mostrar usuário:

**Método:** GET

http://localhost:8080/api/users/{id}

**id** é o ID do usuário a ser retornado.

------

Mostrar todos os usuários:

**Método:** GET

http://localhost:8080/api/users/list

Obs.: Essa rota foi criada para facilitar os testes, uma vez que não há mecanismo de autenticação.

------

- Atualizar:

**Método:** PUT

http://localhost:8080/api/users/{id}

**id** é o ID do usuário a ser atualizado.

| Parâmetro | Tipo   |
| :-------: | :----: |
| name      | string |
| email     | string |

------

- Deletar:

**Método:** DELETE

http://localhost:8080/api/users/{id}

**id** é o ID do usuário a ser deletado.



## Encurtador de URL
- Criar:

**Método:** POST

http://localhost:8080/api/url-shortner

| Parâmetro | Tipo   | Observação |
| :-------: | :----: | :--------: |
| url       | string | URL a ser encurtada |
| user_id   | int    | ID do usuário |

------

- Info:

**Método:** GET

http://localhost:8080/api/url-shortner/{codigo}

**codigo** é o código gerado no cadastro da URL, campo **code**.

------

- URL por usuário:

**Método:** GET

http://localhost:8080/api/url-shortner/by-user/{idUser}

**idUser** é o ID do usuário que criou as URL.

Retorna a lista de URL criadas pelo usuário informado.

------

## Execução das URL

Para acessar a URL basta acessar o valor gerado no campo **short** do cadastro, que é basicamente http://localhost:8080/{codigo}.

A aplicação então irá computar o acesso e redirecionar à URL original.

