# Install the front-end application using Docker

## Requirements

You need the latest versions of [Docker engine](https://docs.docker.com/engine/) and [Docker Compose](https://docs.docker.com/compose/) installed.

The installation procedure is mostly the same than for the [local installation](https://github.com/damien-carcel/app-skeleton/blob/master/doc/install/front/local.md#install), except that every command is run into the `node` container.

## Start the containers

Copy the file `docker-compose.override.yaml.dist` as `docker-compose.override.yaml`.
You may configure the nginx output port as you see fit.
Then start the containers by running:
```bash
$ docker-compose up -d
```

## Install

First, launch the JSON server by running:
```bash
$ docker-compose run --rm node yarn run serve-api
# or
$ docker-compose run --rm node npm run serve-api
```

Then install the dependencies:
```bash
$ docker-compose run --rm node yarn install
# or
$ docker-compose run --rm node npm install
```

Copy the content of the file `.env.dist` into a new file `.env`, and keep only the line dedicated to the JSON server.

Finally, build the application for development (non minimized JS and CSS files) by running:
```bash
$ docker-compose run --rm node yarn run build:dev
# or
$ docker-compose run --rm node npm run build:dev
```

or for production (minimized JS and CSS files) by running:
```bash
$ docker-compose run --rm node yarn run build:prod
# or
$ docker-compose run --rm node npm run build:prod
```

You can now access the application on [localhost:8080](http://localhost:8080) (`8080` being the default output of the `nginx-front` container).