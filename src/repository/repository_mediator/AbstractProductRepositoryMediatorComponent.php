<?php
abstract class AbstractProductRepositoryMediatorComponent {
    protected CategoryRepository $categoryRepository;
    protected ImageRepository $imageRepository;
    protected CommentRepository $commentRepository;

    function setCategoryRepository(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    function setImageRepository(ImageRepository $imgRepo){
        $this->imageRepository = $imgRepo;
    }
    function setCommentRepository(CommentRepository $commentRepository){
        $this->categoryRepository = $commentRepository;
    }
} 