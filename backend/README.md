# BACKEND

Para rodar a API do backend, seguir os seguintes passos (considerando que você clonou o repositório na htdocs do xampp)

# Habilitar o módulo de mod_rewrite dentro do xampp

Seguir os passos disponíveis no link para habilitar o mod_rewrite caso esteja desabilitado: https://www.phpflow.com/php/how-to-enable-mod_rewrite-module-in-apache/
# Criar arquivo .htaccess na raiz do xampp (htdocs no caso)
Criar um arquivo `.htaccess` na pasta htdocs, contendo o seguinte conteúdo:
```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ /projetoWEB/backend/index.php [L,QSA]
```

# Testar API via Insomnia/Postman
Para testar a api, com o apache rodando, testar na seguinte rota dentro do insomnia ou postman: 

* `http://localhost/api/rotaSimples`
* a rota deve retornar uma string diferente para cada método (GET,POST,PUT,DELETE)