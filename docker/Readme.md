## Laravel docker compose

This project is the starting point for a local deployment of a laravel application. Mainly used
by [Skipper](https://github.com/tiknil/skipper).

## .env file

The `MAC_DB_PORT` env variable defines which port the mysql container should be attached to. It can be left empty, and
docker will automatically select an available port. The port is useful for connecting to the database with external
tools, such as the Database viewer inside PHPStorm.

Note that this does not effect the port used by other containers to connect to MySQL.

A summary:

| Source | Hostname  | Port        |
|--------|-----------|-------------|
| PC     | localhost | MAC_DB_PORT |
| Docker | mysql     | 3306        |

## Nginx folder

nginx folder contains a `default.conf` file, mapped inside the `/etc/nginx/conf.d` container directory, which is the
nginx equivalent of apache sites-enabled.

## Mysql folder

mysql folder contains a `init.sql` file, that is run by MySQL at every startup.

## Network

Networking is a bit complex. By default, all services in a docker compose file are placed on the same virtual docker
network and can communicate with each other. The default key in the network section does exacty that.

At the same time, Skipper requires the http container (nginx) to be in the same networks as the reverse proxy. As a
consequence, we need to define both networks in our docker compose file and explicitly attach our nginx service to both.

Avoid placing the other containers in the skipper networks though, it may create some issues with docker forwarding
requests to the container of a different docker compose project.
