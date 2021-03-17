PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "orders" (
    "id"              INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "first_name"      TEXT NOT NULL,
    "last_name"       TEXT NOT NULL,
    "street"          TEXT NOT NULL,
    "city"            TEXT NOT NULL,
    "npa"             INTEGER(10) NOT NULL,
    "country"         VARCHAR(2) NOT NULL,
    "email"           VARCHAR(255) NOT NULL,
    "phone"           VARCHAR(32) NOT NULL,
    "units"           INTEGER NOT NULL,
    "payment"         VARCHAR(10) NOT NULL,
    "shipping"        VARCHAR(10) NOT NULL,
    "price"           REAL NOT NULL,
    "payment_fees"    REAL NOT NULL,
    "shipping_fees"   REAL NOT NULL,
    "total"           REAL NOT NULL,
    "paypal_order_id" VARCHAR(18),
    "date"            INTEGER DEFAULT (strftime('%s', 'now'))
);
COMMIT;
