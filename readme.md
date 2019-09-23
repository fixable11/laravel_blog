## Installation 

1. `git clone https://github.com/fixable11/laravel_blog.git ./ `
2. `make init` <br>
If your opperation system doesn't support **make** command, you have to write list of commands manually. You can find them in a Makefile.

3. `cp .env.example .env`
4. `make bash` and then input list of commands in container 
```
composer dumpautoload
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
```
5. `sudo chmod 777 -R ./storage/`

A full list of useful commands are in the Makefile

Server is available under address http://localhost:8080/ <br>
Phpmyadmin address http://localhost:8081/ (login: root; password: root)

Api documentation: https://documenter.getpostman.com/view/7459001/SVmztGGf?version=latest#a4474934-a937-4a33-9a6b-25a478b71050

### Usefull commands

`make up` - launch docker container <br>
`make down` - shut docker container down <br>
`make bash` - go into docker container bash <br>
`make test` - start phpunit test <br>
`make sniff` - start code sniffer <br>
`make stan` - start php stan <br>
`make check-code` - start test, sniffer and stan <br>
`make perm` - change file owner <br>
