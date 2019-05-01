#!/bin/bash

cat api/database.sql | sqlite3 api/database.db
