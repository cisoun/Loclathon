# Loclathon

Source repository for the [Loclathon's website](https://loclathon.ch).

## Requirements

- apache >= 2
- php >= 5
- php-sqlite
- sqlite3

## Setup

### 1. Set up database

```sh
cat api/database.sql | sqlite3 api/database.db

# Add write persmission to 'api' and the database.
chmod 774 ./api
chmod 774 ./api/database.db
```

### 2. Edit configuration file

```sh
cp api/config.example.php api/config.php
nano api/config.php
```

### 3. Finalize

```sh
chown http:http -R . # Or www-data.
```
