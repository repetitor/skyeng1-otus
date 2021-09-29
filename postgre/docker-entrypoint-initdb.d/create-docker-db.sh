#!/bin/bash
set -e
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER admin;
    CREATE DATABASE task_storage;
    ALTER USER admin WITH PASSWORD '123';
    GRANT ALL PRIVILEGES ON DATABASE task_storage TO admin;
EOSQL