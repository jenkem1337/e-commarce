<?php


header('Content-type: application/json');

require __DIR__. '/vendor/autoload.php';
$f = new FrontController();

$database = MySqlPDOConnection::getInsatace();
$database->createDatabaseConnection();

$authController = (new AuthControllerFactory())->createInstance();
$userController = (new UserControllerFactory())->createInstance();

//Auth Route
$f->registerRoute("POST", "/auth/register", new RegisterCommand($authController));
$f->registerRoute("GET", "/auth/verify-user-acc", new VerifyUserAccountCommand($authController));
$f->registerRoute("POST", "/auth/login", new LoginCommand($authController));
$f->registerRoute("POST","/auth/refresh-token", new RefreshTokenCommand($authController));

//User Route
$f->registerRoute("GET", "/user/find-all", new ListAllUserCommand(new JwtAuthMiddleware(), $userController));
$f->registerRoute("PATCH", "/user/change-password", new ChangePasswordCommand(new JwtAuthMiddleware(), $userController));
$f->registerRoute("POST", "/user/send-forgetten-password-email", new ForgettenPasswordEmailCommand($userController));
$f->registerRoute("PATCH", "/user/change-forgetten-password", new ChangeForgettenPasswordCommand($userController));
$f->registerRoute("GET","/user/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/find-one",new FindOneUserByUuidCommand(new JwtAuthMiddleware(), $userController));
$f->registerRoute("PATCH","/user/change-fullname", new ChangeFullNameCommand(new JwtAuthMiddleware(), $userController));
$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']); 