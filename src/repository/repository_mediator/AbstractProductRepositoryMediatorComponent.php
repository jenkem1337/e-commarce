<?php
abstract class AbstractProductRepositoryMediatorComponent {
    protected CategoryRepository $categoryRepository;

    function setCategoryRepository(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
} 