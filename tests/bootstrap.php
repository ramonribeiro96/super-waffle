<?php

error_reporting(-1);

$composerAutoload = __DIR__ . '../vendor/bootstrap.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env.test');
$dotenv->load();

if (is_file($composerAutoload)) {
    require_once $composerAutoload;
}