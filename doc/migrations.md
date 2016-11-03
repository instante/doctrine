# Migrations generated from previous repository state

## Create new migration

1. read `migrations/schema.yml` -> FROM
2. validate that database is in FROM version
3. read current schema loaded from current schema reader to EntityManager -> TO
4. export TO -> migrations/schema.yml:
** database schema
** version chain (list of migration files to achieve this state)
5. create new migration version into migrations/Version*.php

## Migrate

1. validate migration chain from `migrations/schema.yml`
