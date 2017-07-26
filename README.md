# hms_backend

## Cloning error troubleshoot
If Laravel couldn't run after cloning:
1. Reinstall composer (composer install)
2. If "[Exception] The bootstrap/cache directory must be present and writable." appears, add bootstrap/cache directory manually
3. You have to create the env file. Copy the .env.example and rename it to .env
4. You have generate the APP_KEY (php artisan key:generate)

## CORS Handler
We use https://github.com/barryvdh/laravel-cors for CORS support to allow API requests from different domains

To install:
```sh
$ composer require barryvdh/laravel-cors
```

## Use JWT
To install:
```sh
$ composer require tymon/jwt-auth
```

## Use doctrine/dbal
To install:
```sh
$ composer require doctrine/dbal
```

## Use Guzzle
Guzzle is used for calling another api
To install:
```sh
$ composer require guzzlehttp/guzzle
$ composer require symfony/psr-http-message-bridge
```

<<<<<<< HEAD
=======
## Use Predis
Predis is used to connect redis with laravel
To install:
```sh
$ composer require predis/predis
```

# Installing dependencies for socket.io on node js
To install:
```sh
$ npm install express ioredis socket.io --save
```
To run :
From : public/nodejs/
```sh
$ node socket.js
```
From : public/redis_server/
run node_server.exe
or
```sh
$ redis_server --maxheap 1024 MB
```
