<?php
require './vendor/autoload.php';

class ProductDaoImpl extends AbstractDataAccessObject implements ProductDao {
    protected DatabaseConnection $dbConnection;
	function __construct(DatabaseConnection $dbConnection) {
        $this->dbConnection = $dbConnection;
        parent::__construct($this->dbConnection);

	}
    function deleteSubscriberByProductUuid($pUuid)
    {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM product_subscriber WHERE product_uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$pUuid
        ]);
        $conn = null;

    }
	function deleteByUuid($uuid) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "DELETE FROM products WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $conn = null;
	}
	function findProductsByCriteria(FindProductsByCriteriaDto $findProductsByCriteriaDto){
        
        $selectQuery = "SELECT product.uuid, product.brand_uuid, product.model_uuid, product.header, product._description, product.price, product.stockquantity, product.created_at, product.updated_at ";
        
        $categoriesJoinQuery = "";
        
        $whereQuery = " WHERE ";
        $isWhereConditionSetted = false;
        
        if($findProductsByCriteriaDto->getPriceLowerBound()){
            if(!$isWhereConditionSetted){
                $whereQuery .= " product.price >= :price_lower_bound";
                $isWhereConditionSetted = true;
            } else {
                $whereQuery .= " AND product.price >= :price_lower_bound";
            }
        }
        if ($findProductsByCriteriaDto->getPriceUpperBound()){
            if(!$isWhereConditionSetted){
                $whereQuery .= "product.price <= :price_upper_bound";
                $isWhereConditionSetted = true;
            } 
            else {
                $whereQuery .= " AND product.price <= :price_upper_bound";
            }
        }
        if(count($findProductsByCriteriaDto->getSpesificCategories()) > 0) {
            $placeholders = [];
            foreach ($findProductsByCriteriaDto->getSpesificCategories() as $index => $uuid) {
                $placeholders[] = ":category_uuid_$index";
            }

            $categoriesJoinQuery .= " JOIN product_category as pc ON pc.product_uuid = product.uuid";
            
            if(!$isWhereConditionSetted){
                $whereQuery .= " pc.category_uuid IN (".implode(',', $placeholders).")";
                $isWhereConditionSetted = true;
            } 
            else {
                $whereQuery .= " AND pc.category_uuid IN (".implode(',', $placeholders).")";
            }
        }
        
        $startLimit = (int) $findProductsByCriteriaDto->getStartingLimit(); 
        $perPage = (int) $findProductsByCriteriaDto->getPerPageForProduct();

        $whereQuery .= " LIMIT $startLimit, $perPage" ;
        
        $selectQuery .= " FROM products as product";
        
        $sql = $selectQuery . "" . $categoriesJoinQuery . "" . $whereQuery;
        
        $conn =  $this->dbConnection->getConnection();
        
        $stmt = $conn->prepare($sql);
        
        if(count(value: $findProductsByCriteriaDto->getSpesificCategories()) == 0){
            $stmt->bindValue("price_lower_bound",  $findProductsByCriteriaDto->getPriceLowerBound());
            $stmt->bindValue("price_upper_bound",  $findProductsByCriteriaDto->getPriceUpperBound());    
        
        } else {
            
            $stmt->bindValue("price_lower_bound",  $findProductsByCriteriaDto->getPriceLowerBound());
            $stmt->bindValue("price_upper_bound",  $findProductsByCriteriaDto->getPriceUpperBound());    

            foreach ($findProductsByCriteriaDto->getSpesificCategories() as $index => $uuid) {
                $stmt->bindValue(":category_uuid_$index", $uuid);
            }    
        }
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);    
        $conn = null;
        if($products == null) return $this->returnManyNullStatement();

        return $products; 

    }
    function findAllProductSubscriberByProductUuid($uuid)
    {
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT ps.uuid, ps.user_uuid, ps.product_uuid ,ps.created_at, ps.updated_at, u.full_name as user_full_name, u.email as user_email
            FROM product_subscriber as ps, users as u
            WHERE ps.product_uuid = :uuid AND ps.user_uuid = u.uuid"
        );
        $stmt->execute([
            "uuid"=>$uuid
        ]);
        $productSubscriber = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($productSubscriber == null) return $this->returnManyNullForSubscriberStatement();
        return $productSubscriber;

    }
    function findSubscriberByUserUuid($uuid)
    {
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM product_subscriber WHERE user_uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $product = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($product == null) return $this->returnNullStatment();
        return $product;

    }
	function findAllWithPagination($startingLimit, $perPageForUsers) {
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT $startingLimit, $perPageForUsers");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($products == null) return $this->returnManyNullStatement();

        return $products; 

	}
	
	
	function findOneByUuid($uuid) {
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM products WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([
            'uuid'=>$uuid
        ]);
        $product = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($product == null) return $this->returnNullStatment();
        return $product;
	}
	
	function findBySearching($value, $startingLimit, $perPageForUsers) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM products
            WHERE uuid IN (
                SELECT product_uuid FROM product_search WHERE 
                    MATCH(brand, model, header, description ) AGAINST(:value IN NATURAL LANGUAGE MODE)
            )
            ORDER BY created_at DESC 
            LIMIT $startingLimit, $perPageForUsers" 
            
        );
        $stmt->execute([
            'value'=> $value
        ]);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($products == null) return $this->returnManyNullStatement();
        return $products;
	}
	function findByPriceRange($from, $to){
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT * FROM products 
            WHERE price BETWEEN :_from AND :_to" 
            
        );
        $stmt->execute([
            '_from' => (int)$from,
            '_to' => (int)$to
        ]);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($products == null) return $this->returnManyNullStatement();
        return $products;
    }
	
    function findManyByUuids($uuids) {
        $conn = $this->dbConnection->getConnection();
        $placeholders = [];
        foreach ($uuids as $index => $uuid) {
            $placeholders[] = ":product_uuid_$index";
        }

        $limit = count($uuids);
        $stmt = $conn->prepare(
            "SELECT * FROM products 
             WHERE uuid IN (".implode(',', $placeholders).") LIMIT $limit" 
        );
        foreach($uuids as $index => $uuid) {
            $stmt->bindValue("product_uuid_$index", $uuid);
        }
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        if($products == null) return $this->returnManyNullStatement();
        return $products;
    }
    function returnNullStatment() {
        $arr = [
            "isNull" => true,
            'uuid'=>null,
            'brand' => null,
            'model'=>null, 
            'header'=>null,
            '_description'=>null,
            'price'=>null,
            'prev_price'=>null,
            'rate'=>null,
            'stockquantity'=>null,
            'created_at'=>null,
            'updated_at'=>null,
        ];
        return json_decode(json_encode($arr),false);
    } 

    function findOneOrEmptySubscriberByUuid($uuid, $userUuid){
        $conn= $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "SELECT ps.uuid, ps.user_uuid, ps.product_uuid ,ps.created_at, ps.updated_at, u.full_name , u.email
            FROM product_subscriber as ps
            JOIN users as u ON ps.user_uuid = u.uuid
            WHERE ps.product_uuid = :uuid and ps.user_uuid = :user_uuid LIMIT 1");
        $stmt->execute([
            "uuid"=>$uuid,
            "user_uuid"=> $userUuid
        ]);
        $productSubscriber = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        if($productSubscriber == null) return $this->returnNullForSubscriberStatement();
        return $productSubscriber;

    }
     function returnManyNullStatement(){
        $productArr = array();
        $product = new stdClass();
        $product->uuid = null;
        $product->brand = null;
        $product->model = null;
        $product->header = null;
        $product->_description =null;
        $product->price = null;
        $product->prev_price = null;
        $product->rate = null;
        $product->stockquantity = null;
        $product->created_at= null;
        $product->updated_at = null;
        $productArr[] = $product;
        return $productArr;
    }
    function returnManyNullForSubscriberStatement(){
        $productArr = array();
        $product_subscriber = new stdClass();
        $product_subscriber->uuid = null;
        $product_subscriber->product_uuid = null;
        $product_subscriber->user_uuid = null;
        $product_subscriber->created_at= null;
        $product_subscriber->updated_at = null;
        $product_subscriber->user_full_name = null;
        $product_subscriber->user_email = null;
        $productArr[] = $product_subscriber;
        return $productArr;
    }
     function returnNullForSubscriberStatement(){
        $product_subscriber = new stdClass();
        $product_subscriber->uuid = null;
        $product_subscriber->product_uuid = null;
        $product_subscriber->user_uuid = null;
        $product_subscriber->created_at= null;
        $product_subscriber->updated_at = null;
        $product_subscriber->user_full_name = null;
        $product_subscriber->user_email = null;
        return $product_subscriber;
    }
}