<?php
require "./vendor/autoload.php";

class ProductCategoryCreationalModelFactory implements Factory {
    
	/**
	 */
	function __construct() {
	}
	function createInstance($isMustBeConcreteObjcet = false ,...$params ) {
        return new ProductCategoryCreationalModel(...$params);
	}
}