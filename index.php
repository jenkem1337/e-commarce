<?php
require './vendor/autoload.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
try {
Dotenv\Dotenv::createImmutable(__DIR__)->load();

$authController = (new AuthControllerFactory())->createInstance();
$userController = (new UserControllerFactory())->createInstance();
$categoryController = (new CategoryControllerFactory())->createInstance();
$productController = (new ProductControllerFactory())->createInstance();
$imageController = (new ImageControllerFactory())->createInstance(); 
$shippingController = (new ShippingControllerFactory)->createInstance();

        

$f = new FrontController();

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
$f->registerRoute('PUT', '/categories/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})', new UpdateCategoryNameByUuidCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('DELETE', '/categories/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})', new DeleteCategoryByUuidCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('POST', '/categories', new CrateNewCategoryCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('GET', '/categories', new FindAllCategoryCommand($categoryController, new JwtAuthMiddleware()));
$f->registerRoute('GET', '/categories/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})', new FindOneCategoryCommand($categoryController, new JwtAuthMiddleware));
        
//Product Route
$f->registerRoute("GET", '/products/search', new FindProductsBySearchCommand($productController));
$f->registerRoute("GET", "/products", new FindProductByCriteriaCommand($productController));
$f->registerRoute("GET","/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new FindOneProductCommand($productController));
$f->registerRoute("POST", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/subscriber", new CreateNewProductSubscriberCommand($productController, new JwtAuthMiddleware));
$f->registerRoute('POST', '/products', new CreateNewProductCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PATCH", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/stock-quantity",new UpdateProductStockQuantityCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("PUT", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new UpdateProductDetailsCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new DeleteProductCommand($productController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", '/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/subscriber', new DeleteProductSubscriberCommand($productController, new JwtAuthMiddleware));

//Upload Route
$f->registerRoute('POST', '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image', new UploadImageForProductCommand($imageController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/product', new DeleteImageCommand($imageController, new JwtAuthMiddleware));

//Shipping Route
$f->registerRoute("GET", "/shippings", new FindAllShippingMethodsCommand($shippingController, new JwtAuthMiddleware));
$f->registerRoute("GET", "/shippings/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new FindOneShippingMethodCommand($shippingController, new JwtAuthMiddleware));

$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']); 

} catch (\Exception $err) {
    $errorDetails = [
        'message' => $err->getMessage(),
        'code' => $err->getCode(),
        'trace' => $err->getTrace()
    ];
    http_response_code($err->getCode());
    echo json_encode($errorDetails, JSON_PRETTY_PRINT);
}
