<?php
abstract class AbstractProductRepositoryMediatorComponent {
    protected CategoryRepository $categoryRepository;
    protected ImageRepository $imageRepository;
    protected CommentRepository $commentRepository;
    protected RateRepository $rateRepository;
    protected ProductSubscriberRepository $productSubscriberRepository;
    function setRateRepository(RateRepository $rateRepo){
        $this->rateRepository = $rateRepo;
    }
    function setCategoryRepository(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    function setImageRepository(ImageRepository $imgRepo){
        $this->imageRepository = $imgRepo;
    }
    function setCommentRepository(CommentRepository $commentRepository){
        $this->commentRepository = $commentRepository;
    }
    function setProductSubscriberRepository(ProductSubscriberRepository $productSubscriberRepository){
        $this->productSubscriberRepository = $productSubscriberRepository;
    }
} 