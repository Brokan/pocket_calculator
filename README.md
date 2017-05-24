# Pocket calculator
Simpe web calculator with option to registered users save/load logs of calculations.

Need PHP 7+ for this application.

# Installation

1. Clone repository
<p>git clone https://github.com/Brokan/pocket_calculator.git</p>

2. composer install

3. Make folders writeable for third parties
<p>/storage</p>
<p>/bootstrap/cache</p>

4. Create database. Can use following MySQL script to create database.

<p>CREATE SCHEMA IF NOT EXISTS test_calc;</p>
<p>CREATE USER 'test_calc'@'localhost' IDENTIFIED BY 'password';</p>
<p>GRANT ALL PRIVILEGES ON test_calc.* TO 'test_calc'@'localhost';</p>

5. Create .env file (use .env.example file to make duplicate). And set in MySQL access to database. And APP KEY also.

<p>APP_KEY=base64:uzVbbIjmbqb3P/TyoTPDKIq+CVbzdfd4/XpctFw8qSU=</p>

<p>DB_DATABASE=test_calc</p>
<p>DB_USERNAME=test_calc</p>
<p>DB_PASSWORD=password</p>

6. Run migration command
<p>php artisan migrate --path=database/migrations</p>

7. Enjoy application.
