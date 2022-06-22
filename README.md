# SMS Verification with Login System
> Build a SMS Verification with Login System Using PHP and Mysql
> Using environment from [PHPWeb-Environment-Docker](https://github.com/phongdk29101999/PHPWeb-Environment-Docker) repository

## Requirement

- install Docker-CE

## Initialize cli file

```
cp cli.example cli && sudo chmod +x cli
```

## Build & Run

```
./cli build
```

## Load database

```
./cli load-database -f ./mysql/init/web_db.sql
```

## Access to web

```
http://localhost
```

## access to phpMyAdmin

```
http://localhost:8080
```
