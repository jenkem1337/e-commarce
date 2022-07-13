<?php
require "./vendor/autoload.php";

abstract class ProductCategoryCreationalModelFactory implements Factory {
    
	/**
	 */
	function __construct() {
	}
	function createInstance($isMustBeConcreteObjcet = false ,...$params ):ProductInterface {
        return new ProductForCreatingCategoryDecorator();
	}
}