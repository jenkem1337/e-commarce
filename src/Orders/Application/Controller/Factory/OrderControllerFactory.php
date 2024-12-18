<?php
use PHPMailer\PHPMailer\PHPMailer;
class OrderControllerFactory implements Factory{
    function createInstance($isMustBeConcreteObjcet = false, ...$params)
    {
        $orderDao = new OrderDaoImpl(MySqlPDOConnection::getInstance());
        $orderRepo = new OrderRepositoryImpl($orderDao);
        $productDao = new ProductDaoImpl(MySqlPDOConnection::getInstance());
        $mailService = new EmailServiceImpl(new PHPMailer(true));
        $orderService = new OrderServiceImpl(
            $orderRepo,
            new PaymentServiceImpl(
                new PaymentRepositoryImpl(
                    new PaymentDaoImpl(
                        MySqlPDOConnection::getInstance()
                    )
                ),
                new FakePaymentGatewayImpl()
            ),
            new ShippingServiceImpl(
                new ShippingRepositoryImpl(
                    new ShippingDaoImpl(MySqlPDOConnection::getInstance())
                ),
                
            ),
            new ProductServiceImpl(
                new ProductRepositoryAggregateRootDecorator(
                    new ProductRepositoryImpl(
                        $productDao,
                        new ProductSubscriberRepositoryImpl(
                            $productDao
                        ),
                        new CommentRepositoryImpl(
                            new CommentDaoImpl(MySqlPDOConnection::getInstance())
                        ),
                        new RateRepositoryImpl(
                            new RateDaoImpl(MySqlPDOConnection::getInstance())
                        ),
                        new ImageRepositoryImpl(
                            new ImageDaoImpl(MySqlPDOConnection::getInstance())
                        )
                    )
                ),
                new CategoryRepositoryImpl(
                    new CategoryDaoImpl(MySqlPDOConnection::getInstance())
                ),
                new BrandRepositoryImpl(
                    new BrandDaoImpl(MySqlPDOConnection::getInstance()),
                    new ModelRepositoryImpl(new ModelDaoImpl(MySqlPDOConnection::getInstance()))
                ),
                new UploadServiceImpl(
                    MinIOConnection::getInstance()
                ),
                $mailService,
                null
            ),
            $mailService
        );
        return new OrderController(new TransactionalOrderService($orderService, $orderRepo),  new RemoteCheckoutServiceImpl(new HttpCheckoutServiceDataSource()));
    }
}