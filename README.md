## About App

Backend and API.

## Configuration

### docker-compose.yml
```yml
version: '3'

services:

    ####################################################################################################
    # PHP
    ####################################################################################################
    php:
        build: .docker/php
        ports:
            - 5173:5173
        volumes:
            - .:/var/www:cached

    ####################################################################################################
    # Nginx
    ####################################################################################################
    nginx:
        image: nginx
        ports:
            - 80:80
        volumes:
            - .:/var/www
            - .docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
            - .docker/nginx/nginx.conf:/etc/nginx/nginx.conf
        depends_on:
            - php

    ####################################################################################################
    # DATABASE (MySQL)
    ####################################################################################################
    db:
        image: mysql:8.1
        ports:
            - 3306:3306
        volumes:
            - .docker/db/data:/var/lib/mysql
            - .docker/logs:/var/log/mysql
            - .docker/db/my.cnf:/etc/mysql/conf.d/my.cnf
            - .docker/db/sql:/docker-entrypoint-initdb.d
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: refactorian
            MYSQL_USER: refactorian
            MYSQL_PASSWORD: refactorian

    # ####################################################################################################
    # # DATABASE (MariaDB)
    # ####################################################################################################
    # db:
    #     image: mariadb:10.11
    #     ports:
    #         - 3306:3306
    #     volumes:
    #         - .docker/db/data:/var/lib/mysql
    #         - .docker/logs:/var/log/mysql
    #         - .docker/db/my.cnf:/etc/mysql/conf.d/my.cnf
    #         - .docker/db/sql:/docker-entrypoint-initdb.d
    #     environment:
    #         MYSQL_ROOT_PASSWORD: root
    #         MYSQL_DATABASE: laravel_db_name
    #         MYSQL_USER: laravel_db_user
    #         MYSQL_PASSWORD: laravel_db_pass

    ####################################################################################################
    # phpMyAdmin
    ####################################################################################################
    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        ports:
            - 8080:80
        links:
            - db
        environment:
            PMA_HOST: db
            PMA_PORT: 3306
            PMA_ARBITRARY: 1
        volumes:
            - .docker/phpmyadmin/sessions:/sessions

    ####################################################################################################
    # Adminer
    ####################################################################################################
    adminer:
        image: adminer
        ports:
            - 9090:8080
        depends_on:
            - db

    ####################################################################################################
    # Mailpit
    ####################################################################################################
    mail:
        image: axllent/mailpit:latest
        ports:
            - 8025:8025
            - 1025:1025

    ####################################################################################################
    # Redis
    ####################################################################################################
    redis:
        image: redis:latest
        command: redis-server --appendonly yes
        volumes:
            - .docker/redis/data:/data
        ports:
            - "6379:6379"

    ####################################################################################################
    # Minio
    ####################################################################################################
    minio:
        image: 'minio/minio:latest'
        ports:
            - '9000:9000'
            - '8900:8900'
        container_name: minio_storage
        environment:
            MINIO_ROOT_USER: minio
            MINIO_ROOT_PASSWORD: minio123
        volumes:
            - .docker/minio/data:/data
            - .docker/minio/config:/root/.minio
        command: 'minio server /data/minio --console-address ":8900"'
        healthcheck:
            test: ["CMD", "curl", "-f", "http://localhost:9000/minio/health/live"]
            retries: 3
            timeout: 5s

```

