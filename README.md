
Symfony CLI version 5.4.11
php <= 8.1

git init

git clone https://github.com/JulienMorel76350/Symfony3BCI_Morel-Julien.git

composer i 

Env mysql like DATABASE_URL="mysql://root@127.0.0.1:3306/symfonyexam?serverVersion=8&charset=utf8mb4"

Php bin console:d:d:c 

php bin/console make:migration

php bin/console doctrine:migrations:migrate

Symfony server:start 
et voila