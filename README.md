# Super Cool Community

Vulnerable community web application. Write posts, make comments, and hack the server!

## Run in Docker

Docker runs Apache server with DB and PHPMyAdmin installed

```
docker build -t sccommunity-webapp .
docker run -p 1337:80 --rm -it --name sccommunity-webapp-test -v`pwd`/app:/var/www/html sccommunity-webapp
```

or 

```
make build
make run
```

## Setup

Use the `install.php` script to help setup your community and its config.

## Admin

Use the `admin.php` page to administer your community. The username and password for the admin page are in the config file.

## SQL 

SQL is in the `sccommunity.sql` file.
