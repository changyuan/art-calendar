<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn']         = 'mysql:host=localhost;port=3306;dbname=art_calendar';
$db['username']    = 'root';
$db['password']    = '';
$db['charset']     = 'utf8';
$db['tablePrefix'] = 'ac_';

return $db;
