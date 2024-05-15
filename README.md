# AppGestao
 Gerenciamento Integarado de Orçamento e Serviço

# Roda o composer install 
php composer install

php composer update

# Iniciando o Banco de dados Projeto

php spark migrate --all


# Populando as Tabelas
php spark db:seed Usuario

php spark db:seed Grupo

php spark db:seed SubGrupo