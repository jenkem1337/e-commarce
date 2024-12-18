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
$brandController = (new BrandControllerFactory)->createInstance();
$orderController = (new OrderControllerFactory)->createInstance();

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

//Brand Route
$f->registerRoute("GET", '/brands', new FindAllBrandCommand($brandController));
$f->registerRoute("GET", "/brands/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new FindOneBrandWithModelsCommand($brandController));
$f->registerRoute("POST", "/brands", new CreateBrandCommand($brandController));
$f->registerRoute("POST", "/brands/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/model", new CreateBrandModelCommand($brandController));
$f->registerRoute("PATCH", "/brands/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new ChangeBrandNameCommand($brandController));
$f->registerRoute("PATCH", "/brands/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/model/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new ChangeBrandModelNameCommand($brandController));
$f->registerRoute("DELETE", "/brands/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new DeleteBrandCommand($brandController));

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
$f->registerRoute("POST", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/review", new ReviewProductCommand($productController));
$f->registerRoute("PATCH", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/comment", new UpdateProductCommentCommand($productController));
$f->registerRoute("PATCH", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/rate", new UpdateProductRateCommand($productController));
$f->registerRoute("DELETE", "/products/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/review", new DeleteProductReviewCommand($productController));

//Upload Route
$f->registerRoute('POST', '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image', new UploadImageForProductCommand($imageController, new JwtAuthMiddleware));
$f->registerRoute("DELETE", '/uploads/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/image/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/product', new DeleteImageCommand($imageController, new JwtAuthMiddleware));

//Order Route
$f->registerRoute("POST", "/orders", new PlaceOrderCommand($orderController));
$f->registerRoute("POST", "/orders/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/dispatch", new DispatchOrderCommand($orderController));
$f->registerRoute("POST", "/orders/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/complete", new CompleteOrderCommand($orderController));
$f->registerRoute("POST", "/orders/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/cancel", new CancelOrderCommand($orderController));
$f->registerRoute("POST", "/orders/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/return-request", new SendReturnRequestCommand($orderController));
$f->registerRoute("POST", "/orders/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/return", new ReturnOrderCommand($orderController));
$f->registerRoute("GET", "/orders/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/user", new FindAllOrderWithItemsByUserUuidCommand($orderController));

//Shipping Route
$f->registerRoute("GET", "/shippings", new FindAllShippingMethodsCommand($shippingController, new JwtAuthMiddleware));
$f->registerRoute("GET", "/shippings/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})", new FindOneShippingMethodCommand($shippingController, new JwtAuthMiddleware));
$f->registerRoute("POST", "/shippings/([0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12})/deliver", new ShippingDeliveredCommand($shippingController));

$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']); 

} catch (\Exception $err) {
    $errorDetails = [
        'message' => $err->getMessage(),
        'code' => $err->getCode(),
        'trace' => $err->getTrace()
    ];
    http_response_code( (int)$err->getCode());
    echo json_encode($errorDetails, JSON_PRETTY_PRINT);
}
