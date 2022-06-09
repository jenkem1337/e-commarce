<?php

use PHPMailer\PHPMailer\PHPMailer;

header('Content-type: application/json');

require __DIR__. '/vendor/autoload.php';

$f = new FrontController();

//Auth Route
$f->registerRoute("POST", "/auth/register", new RegisterCommand(new AuthController(new AuthServiceImpl(new UserRepositoryImpl(new UserDaoImpl(new MySqlPDOConnection())), new EmailServiceImpl(new PHPMailer(true))))));
$f->registerRoute("GET", "/auth/verify-user-acc", new VerifyUserAccountCommand(new AuthController(new AuthServiceImpl(new UserRepositoryImpl(new UserDaoImpl(new MySqlPDOConnection())), new EmailServiceImpl(new PHPMailer(true))))));

$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);