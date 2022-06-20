<?php

interface CategoryInterface {
        function changeCategoryName($categoryName);

        public function getCategoryName();
    
        public function getProductUuid();
        function setProductUuid($productUuid): void;
        
        public function getUuid();

        public function getCreatedAt();

        public function getUpdatedAt();

        function isNull();

}