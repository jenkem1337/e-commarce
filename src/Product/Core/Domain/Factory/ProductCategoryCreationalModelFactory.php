<?php

abstract class ProductCategoryCreationalModelFactory implements Factory {
    
	/**
	 */
	function __construct() {
	}
	function createInstance($isMustBeConcreteObjcet = false ,...$params ):ProductInterface {
		if($isMustBeConcreteObjcet){
			return new ProductForCreatingCategoryDecorator();
		}
		try {
			return new ProductForCreatingCategoryDecorator();

		} catch (\Throwable $th) {
			return new NullProduct();
		}
	}
}