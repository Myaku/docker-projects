## Shell references

All commands on the folder with the docker-compose.yml

#### Check running images with their container IDs

And with compose, we can also know their service name and container name

`docker ps`
`docker-compose ps`

#### View existing images

All of this images are some GBs of space, so if we do more than we need, we should clean it a bit

`docker images`

#### Remove all images

`docker system prune -a`

> https://craigbuckler.medium.com/how-to-clean-your-docker-data-9fad45538888

#### Check existing volumes

`docker volume ls`

#### Remove unused volumes

Unused means that is not prepared to be accessed by any image. If images are removed first, this will wipe the volumes to start from scratch.

`docker volume prune -a`

#### Remove everything not in use

This affects containers, networks, images, build cache and anonymous volumes, as long as it is not used

If everything is stopped, this will clean everything to start anew. If not, it will clean everything not in use

`docker system prune -a --volumes`

#### Build the containers if there were changes in the Dockerfiles, the docker-compose.yml or some of the used files

`docker-compose build`

#### Start container in the background (won't be shown on the open terminal)

`docker-compose up -d`

We can also add `--build` to the end as a shorthand to do `docker-compose build` and then the `docker-compose up -d`

#### Stop all containers

`docker-compose down`

#### See live logs (would be the same as not using -d on the docker-compose up)

We can also specify the service name to only show that ones, but it's optional

`docker-compose logs -f [SERVICE_NAME]`

#### Execute a command inside the container from host cmd

The `docker-compose` version is a bit slower, but more accurate to the container terminal (normal docker one is not colored and even randomly sorts the lines in `composer --version` for example)

`docker exec CONTAINER_ID whoami`
`docker-compose exec SERVICE_NAME whoami`

## Make certificates with mkcert

Install this with chocolatey:

> https://github.com/FiloSottile/mkcert

`mkcert -install`
`mkcert localhost 127.0.0.1 ::1`

## Backup and restore data into db:

### Backup

`docker exec CONTAINER /usr/bin/mysqldump -u root --password=root DATABASE > backup.sql`

### Restore

`cat backup.sql | docker exec -i CONTAINER /usr/bin/mysql -u root --password=root DATABASE`

### Alternative

Thou I should check if it's worth: https://github.com/tiredofit/docker-db-backup

## TODO:

-   Maybe read and execute composer install in a multistage image, or maybe even in a different image at all, only to populate src libs. As not every project would use composer, both ways oculd be easy to comment to avoid it
    -   https://labs.iximiuz.com/tutorials/docker-multi-stage-builds
