<?php
require './vendor/autoload.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
try {
$authController = (new AuthControllerFactory())->createInstance();
$userController = (new UserControllerFactory())->createInstance();
$categoryController = (new CategoryControllerFactory())->createInstance();
$productController = (new ProductControllerFactory())->createInstance();
$imageController = (new ImageControllerFactory())->createInstance(); 


        
Dotenv\Dotenv::createImmutable(__DIR__)->load();

$f = new FrontController();
$database = MySqlPDOConnection::getInsatace();
$database->createDatabaseConnection();

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
$f->registerRoute("GET", '/products/search', new FindProductsBySearchCommand($productController));
$f->registerRoute("GET", "/products/partial", new FindAllProductWithPaginationCommand($productController));
$f->registerRoute("GET", "/products", new FindAllProductCommand($productController));
$f->registerRoute("GET","/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new FindOneProductCommand($productController));
$f->registerRoute('POST', '/products', new CreateNewProductCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PATCH", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/brand", new UpdateProductBrandNameCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PATCH", '/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/model', new UpdateProductModelNameCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PATCH", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/header", new UpdateProductHeaderCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PATCH", '/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/description', new UpdateProductDescriptionCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PATCH", '/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/price', new UpdateProductPriceCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new DeleteProductCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", '/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/subscriber', new DeleteProductSubscriberCommand($productController, new JwtAuthMiddleware));

//Upload Route
$f->registerRoute('POST', '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image', new UploadImageForProductCommand($imageController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/product', new DeleteImageCommand($imageController, new JwtAuthMiddleware));

$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']); 

} catch (\Exception $err) {
    (new ErrorResponseDto($err->getMessage(), $err->getCode()))->onError(function (ErrorResponseDto $err) {
        echo json_encode([
            'error_message' => $err->getErrorMessage(),
            'status_code' => $err->getErrorCode()
        ]);
    });
}
