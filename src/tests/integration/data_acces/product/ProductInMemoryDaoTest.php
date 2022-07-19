<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductInMemoryDaoTest extends TestCase {
    protected ProductInMemoryDaoImpl $dao;
    function setUp():void {
        $this->dao = new ProductInMemoryDaoImpl(new SqliteInMemoryConnection());
    }
    function test_persist_product(){
        $this->dao->persist(
            new ProductConstructorRuleRequiredDecorator(
                Uuid::uuid4(),
                'X Brand',
                'Model YX',
                'X Brand Model XY',
                'Excelent product for developers',
                199.00,
                200,
                date('h'),
                date('h')
            )
        );
        $this->assertEquals(1, count($this->dao->findAll()));
    }
    function test_delete_product(){
        $productUuid = Uuid::uuid4();
        $product = new ProductConstructorRuleRequiredDecorator(
            $productUuid,
            'X Brand',
            'Model YX',
            'X Brand Model XY',
            'Excelent product for developers',
            199.00,
            200,
            date('h'),
            date('h')
        );
        $this->dao->persist($product);
        $this->dao->deleteByUuid($productUuid);
        $this->assertEquals(0, count($this->dao->findAll() ?? []));
    }
    function test_find_all_with_pagination(){
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200, date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model YX','X Brand Model XY','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->assertEquals(5, count($this->dao->findAllWithPagination(0,5)));
    }
    function test_find_one_by_uuid(){
        $productUuid = Uuid::uuid4();
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator($productUuid,'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model PP','X Brand Model PP','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model OO','X Brand Model OO','Excelent product for developers',199.00,200,date('h'),date('h')));
        $productFromDao = $this->dao->findOneByUuid($productUuid);
        $this->assertEquals('X Brand Model ZZ', $productFromDao->header);
    }
    function test_find_by_search(){
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model PP','X Brand Model PP','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model OO','X Brand Model OO','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model PP','X Brand Model PP','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->dao->persist(new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model OO','X Brand Model OO','Excelent product for developers',199.00,200,date('h'),date('h')));
        $this->assertEquals(6, count($this->dao->findBySearching('x brand')));
    }
    function test_update_stockquatity(){
        $product = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($product);
        $product->incrementStockQuantity(26);
        $this->dao->updateStockQuantityByUuid($product);
        $pFromDao = $this->dao->findOneByUuid($product->getUuid());
        $this->assertEquals(226, $pFromDao->stockquantity);
    }
    function test_update_model_name(){
        $p = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($p);
        $p->changeModel('Model OO');
        $this->dao->updateModelNameByUuid($p);
        $this->assertEquals('Model OO', $this->dao->findOneByUuid($p->getUuid())->model);
    }
    function test_update_brand_name_(){
        $p = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($p);
        $p->changeBrand('Honda');
        $this->dao->updateBrandNameByUuid($p);
        $this->assertEquals('Honda', $this->dao->findOneByUuid($p->getUuid())->brand);
    }
    function test_update_price(){
        $p = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($p);
        $p->changePrice(90);
        $this->dao->updatePriceByUuid($p);
        $this->assertEquals(90.00, $this->dao->findOneByUuid($p->getUuid())->price);
        $this->assertEquals(199.00, $this->dao->findOneByUuid($p->getUuid())->prev_price);
    }
    function test_update_description(){
        $p = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($p);

        $p->changeDescription('Very bad design product for developers');
        $this->dao->updateDescriptionByUuid($p);
        $this->assertEquals('Very bad design product for developers', $this->dao->findOneByUuid($p->getUuid())->_description);
    }
    function test_update_header(){
        $p = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($p);
        $p->changeHeader('New Model ZZ');
        $this->dao->updateHeaderByUuid($p);
        $this->assertEquals('New Model ZZ', $this->dao->findOneByUuid($p->getUuid())->header);
    }
    function test_update_rate(){
        $product  = new ProductConstructorRuleRequiredDecorator(Uuid::uuid4(),'X Brand','Model ZZ','X Brand Model ZZ','Excelent product for developers',199.00,200,date('h'),date('h'));
        $this->dao->persist($product);
        $rate = new Rate(Uuid::uuid4(), $product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate->rateIt(4);
        $rate2 = new Rate(Uuid::uuid4(), $product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate2->rateIt(3);
        $rate3 = new Rate(Uuid::uuid4(), $product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate3->rateIt(1);
        $rate4 = new Rate(Uuid::uuid4(), $product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate4->rateIt(2);
        $rate5 = new Rate(Uuid::uuid4(), $product->getUuid(), Uuid::uuid4(), date('h'),date('h'));
        $rate5->rateIt(5);
        $product->addRate($rate);
        $product->addRate($rate2);
        $product->addRate($rate3);
        $product->addRate($rate4);
        $product->addRate($rate5);

        $product->calculateAvarageRate();
        $this->dao->updateAvarageRateByUuid($product);
        $productFromDao = $this->dao->findOneByUuid($product->getUuid());
        $this->assertEquals(3, $productFromDao->rate);

    }
} 