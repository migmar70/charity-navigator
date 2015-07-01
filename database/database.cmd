@ECHO OFF

CALL "tables.cmd"
REM CALL "functions.cmd"
REM CALL "stored procedures.cmd"

IF EXIST "%output%" DEL /q database.sql

TYPE "tables.sql">>database.sql

REM TYPE "functions.sql">>database.sql
REM TYPE "stored procedures.sql">>database.sql
REM TYPE "data.sql">>database.sql

