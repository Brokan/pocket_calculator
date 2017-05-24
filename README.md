# Pocket calculator
Simpe web calculator with option to registered users save/load logs of calculations.

# Installation

1. git clone https://github.com/Brokan/pocket_calculator.git

2. composer install

3. Make folders writeable for third parties
/storage
/bootstrap/cache

4. Create database. Can use following MySQL script to create database.

CREATE SCHEMA IF NOT EXISTS test_calc;
CREATE USER 'test_calc'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON test_calc.* TO 'test_calc'@'localhost';

5. Create .env file (use .env.example file to make duplicate). And set in MySQL access to database. And APP KEY also.

APP_KEY=base64:uzVbbIjmbqb3P/TyoTPDKIq+CVbzdfd4/XpctFw8qSU=

DB_DATABASE=test_calc
DB_USERNAME=test_calc
DB_PASSWORD=password

6. Run migration command
php artisan migrate --path=database/migrations

7. Enjoy application.
