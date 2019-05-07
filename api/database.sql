PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "bottles" (
	"units"	INTEGER NOT NULL UNIQUE,
	"price" INTEGER(2) NOT NULL
);
INSERT INTO bottles VALUES(50, 34);
CREATE TABLE IF NOT EXISTS "orders" (
	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"order_id"	TEXT NOT NULL UNIQUE,
	"payer_id"	Varchar(13) NOT NULL,
	"full_name"	TEXT NOT NULL,
	"email"	TEXT NOT NULL,
	"phone"	TEXT NOT NULL,
	"address"	TEXT NOT NULL,
	"city"	TEXT NOT NULL,
	"postal_code"	varchar(10) NOT NULL,
	"country"	Varchar(2) NOT NULL,
	"units"	INTEGER NOT NULL,
	"amount"	REAL NOT NULL,
	"status"	INTEGER NOT NULL,
	"date"	varchar(20) NOT NULL
);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('orders',13);
COMMIT;
