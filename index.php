<?php


header('Content-type: application/json');

require __DIR__. '/vendor/autoload.php';
$f = new FrontController();

$database = MySqlPDOConnection::getInsatace();
$database->createDatabaseConnection();

$authController = (new AuthControllerFactory())->createInstance();
$userController = (new UserControllerFactory())->createInstance();
$categoryController = (new CategoryControllerFactory())->createInstance();
$productController = (new ProductControllerFactory())->createInstance();
$imageController = (new ImageControllerFactory())->createInstance(); 
//Auth Route
$f->registerRoute("POST", "/auth/register", new RegisterCommand($authController));
$f->registerRoute("GET", "/auth/verify-user-acc", new VerifyUserAccountCommand($authController));
$f->registerRoute("POST", "/auth/login", new LoginCommand($authController));
$f->registerRoute("POST","/auth/refresh-token", new RefreshTokenCommand($authController));

//User Route
$f->registerRoute("GET", "/users", new ListAllUserCommand(new JwtAuthMiddleware(), $userController));
$f->registerRoute("PATCH", "/users/password", new ChangePasswordCommand(new JwtAuthMiddleware(), $userController));
$f->registerRoute("POST", "/users/send-forgetten-password-email", new ForgettenPasswordEmailCommand($userController));
$f->registerRoute("PATCH", "/users/forgetten-password", new ChangeForgettenPasswordCommand($userController));
$f->registerRoute("GET","/users/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})",new FindOneUserByUuidCommand(new JwtAuthMiddleware(), $userController));
$f->registerRoute("PATCH","/users/fullname", new ChangeFullNameCommand(new JwtAuthMiddleware(), $userController));

//Category Route
$f->registerRoute('PATCH', '/categories/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/name', new UpdateCategoryNameByUuidCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('DELETE', '/categories/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})', new DeleteCategoryByUuidCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('POST', '/categories', new CrateNewCategoryCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('GET', '/categories', new FindAllCategoryCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('GET', '/categories/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})', new FindOneCategoryCommand($categoryController, new JwtAuthMiddleware));

//Product Route
$f->registerRoute('POST', '/products', new CreateNewProductCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("GET","/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new FindOneProductCommand($productController));
$f->registerRoute("PATCH", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new UpdateProductBrandNameCommand($productController, new JwtAuthMiddleware));

//Upload Route
$f->registerRoute('POST', '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image', new UploadImageForProductCommand($imageController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/product', new DeleteImageCommand($imageController, new JwtAuthMiddleware));
$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']); 