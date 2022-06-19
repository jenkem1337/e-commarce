<?php

interface CategoryInterface {
        function changeCategoryName($categoryName);

        public function getCategoryName();
    
        public function getProductUuid();
        
        public function getUuid();

        public function getCreatedAt();

        public function getUpdatedAt();

        function isNull();

}