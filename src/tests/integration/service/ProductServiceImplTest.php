<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductServiceImplTest extends TestCase {
    protected ProductService $productService;
    function setUp():void {
        $sqlite = SqliteInMemoryConnection::getInstance();
        $sqlite->createDatabaseConnection();
        $categoryDao = new CategoryInMemoryDaoImpl($sqlite);
        $productRepository = new ProductRepositoryImpl(
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()    
            ]),new ProductDaoImpl(MySqlPDOConnection::getInsatace())
        );
        $categoryRepository = new CategoryRepositoryImpl($categoryDao, new ConcreteCategoryFactory());
        $categoryRepository->setProductMediator($productRepository);
        $this->productService = new TransactionalProductServiceDecorator(new ProductServiceImpl(
            $productRepository,
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()    
            ]),
            new ConcreteCategoryFactory(),
            new  ConcreteImageFactory(),
            new UploadServiceImpl()
        ), $sqlite);
    }

    function test_create_new_category(){
        $date = date ('Y-m-d H:i:s');
        $cUuid = uuid::uuid4();
        $response = $this->productService->createNewCategory(
            new CategoryCreationalDto($cUuid, 'Motorsiklet', $date, $date)
        );

        $response->onSucsess(function(CategoryCreatedResponseDto $res){
            $this->assertEquals('Motorsiklet', $res->getCategoryName());
        });
    }
    function test_create_new_category_and_find_duplicated_category(){
            $date = date ('Y-m-d H:i:s');
            $this->productService->createNewCategory(
                new CategoryCreationalDto(uuid::uuid4(), 'Motorsiklet', $date, $date)
            );

            $response = $this->productService->createNewCategory(
                new CategoryCreationalDto(uuid::uuid4(), 'Motorsiklet', $date, $date)
            );
            $response->onError(function (ErrorResponseDto $e){
                $this->assertEquals('category already exist', $e->getErrorMessage());
            });

    }
    function test_find_one_category_uuid(){
        $date = date ('Y-m-d H:i:s');
        $cUuid = uuid::uuid4();
        $this->productService->createNewCategory(
            new CategoryCreationalDto($cUuid, 'Motorsiklet', $date, $date)
        );

        $response = $this->productService->findOneCategoryByUuid(
            new FindCategoryByUuidDto($cUuid)
        );
        $response->onSucsess(function(OneCategoryFoundedResponseDto $res){
            $this->assertEquals('Motorsiklet', $res->getCategoryName());
        });

    }
    function test_find_does_not_exists_category(){
        $date = date ('Y-m-d H:i:s');
        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Motorsiklet', $date, $date)
        );

        $response = $this->productService->findOneCategoryByUuid(
            new FindCategoryByUuidDto(uuid::uuid4())
        );
        $response->onError(function(ErrorResponseDto $e){
            $this->assertEquals('category doesnt exist', $e->getErrorMessage());
        });

    }
    function test_find_all_category(){
        $date = date ('Y-m-d H:i:s');

        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Motorsiklet', $date, $date)
        );
        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Elektronik', $date, $date)
        );
        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Otomobil', $date, $date)
        );
        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Kitap', $date, $date)
        );
        $response = $this->productService->findAllCategory(new FindAllCategoryDto());
        $response->onSucsess(function(AllCategoryResponseDto $res){
            $this->assertEquals(4, $res->getCategories()->count());
        });
    }
    function test_find_empty_category_database(){
        $response = $this->productService->findAllCategory(new FindAllCategoryDto());
        $response->onSucsess(function(AllCategoryResponseDto $res){
            $this->assertEquals(0, $res->getCategories()->count());
        });
    }

    function test_update_category_name_by_uuid(){
        $date = date ('Y-m-d H:i:s');
        $uuid = uuid::uuid4();
        $this->productService->createNewCategory(
            new CategoryCreationalDto($uuid, 'Kitap', $date, $date)
        );

        $response = $this->productService->updateCategoryNameByUuid(
            new UpdateCategoryNameByUuidDto($uuid, 'Motorsiklet')
        );
        $response2 = $this->productService->findOneCategoryByUuid(new FindCategoryByUuidDto($uuid));

        $response->onSucsess(function(CategoryNameChangedResponseDto $res){
            $this->assertEquals('Category name changed successfuly', $res->getSuccessMessage());
        });

        $response2->onSucsess(function(OneCategoryFoundedResponseDto $res){
            $this->assertEquals('Motorsiklet', $res->getCategoryName());
        });
    }


    function test_update_doesnt_exist_category(){
        $date = date ('Y-m-d H:i:s');
        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Kitap', $date, $date)
        );

        $response = $this->productService->updateCategoryNameByUuid(
            new UpdateCategoryNameByUuidDto(uuid::uuid4(), 'Motorsiklet')
        );
        $response->onError(function(ErrorResponseDto $e){
            $this->assertEquals('category doesnt exist', $e->getErrorMessage());
        });
    }

    function test_delete_category(){
        $date = date ('Y-m-d H:i:s');
        $uuid = uuid::uuid4();
        $this->productService->createNewCategory(
            new CategoryCreationalDto(uuid::uuid4(), 'Kitap', $date, $date)
        );
        $this->productService->createNewCategory(
            new CategoryCreationalDto($uuid, 'Motorsiklet', $date, $date)
        );

        $response = $this->productService->deleteCategoryByUuid(new DeleteCategoryDto($uuid));
        $response->onSucsess(function(CategoryDeletedResponseDto $res){
            $this->assertEquals('Category deleted successfuly', $res->getSuccessfullMessage());
        });

        $this->productService->findAllCategory(new FindAllCategoryDto)->onSucsess(function(AllCategoryResponseDto $res){
            $this->assertEquals(1, $res->getCategories()->count());
        });
    }

    function test_delete_doesnt_exist_category(){
        $response = $this->productService->deleteCategoryByUuid(new DeleteCategoryDto(uuid::uuid4()));
        $response->onError(function(ErrorResponseDto $e){
            $this->assertEquals('category doesnt exist', $e->getErrorMessage());
        });

    }
}