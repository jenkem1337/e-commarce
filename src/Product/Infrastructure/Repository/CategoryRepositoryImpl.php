<?php

class CategoryRepositoryImpl implements CategoryRepository {
    private CategoryDao $categoryDao;
    private CategoryFactory $categoryFactory;
	function __construct(CategoryDao $categoryDao, Factory $categoryFactory) {
	    $this->categoryDao = $categoryDao;
        $this->categoryFactory = $categoryFactory;
	}
    
	function persist(CategoryInterface $c) {
        $this->categoryDao->persist($c);
    }
	function deleteCategoryByProductUuid($uuid)
    {
        $this->categoryDao->deleteCategoryByProductUuid($uuid);
    }
	function deleteByUuid($uuid) {
        $this->categoryDao->deleteByUuid($uuid);
	}
    function findAllByProductAggregateUuid($productUuid): IteratorAggregate
    {
        $categories =  $this->categoryDao->findAllByProductUuid($productUuid);
        $categoryArray = new CategoryCollection();
        foreach($categories as $category){
            $categoryDomainObject = $this->categoryFactory->createInstance(
                false,
                $category->uuid,
                $category->category_name,
                $category->created_at,
                $category->updated_at
            );
            if(!$categoryDomainObject->isNull()){   
                $categoryArray->add($categoryDomainObject);
            }
        }
        return $categoryArray;
    }
    function findAllByProductUuid($productUuid) {
        return $this->categoryDao->findAllByProductUuid($productUuid);
    }
	function findByUuid($uuid):CategoryInterface {
        $category = $this->categoryDao->findByUuid($uuid);
        return $this->categoryFactory->createInstance(
            false,
            $category->uuid,
            $category->category_name,
            $category->created_at,
            $category->updated_at
        );
	}

    function findASetOfByUuids($uuids):CategoryCollection {
        $categories = $this->categoryDao->findASetOfByUuids($uuids);
        $categoryCollection = new CategoryCollection();
        foreach($categories as $category){
            $categoryDomainObject = $this->categoryFactory->createInstance(
                false,
                $category->uuid,
                $category->category_name,
                $category->created_at,
                $category->updated_at
            );
            if(!$categoryDomainObject->isNull()) {
                $categoryCollection->add($categoryDomainObject);
            }
        }
        return $categoryCollection;

    }
    
	
	function updateNameByUuid(CategoryInterface $c) {
        $this->categoryDao->updateNameByUuid($c);
	}
    function findOneByName($categoryName):CategoryInterface{
        $category = $this->categoryDao->findOneByName($categoryName);
        return $this->categoryFactory->createInstance(
            false,
            $category->uuid,
            $category->category_name,
            $category->created_at,
            $category->updated_at
        );
    }
	function findAll():mixed {
        //$categoryCollection = new CategoryCollection();
        $categories = $this->categoryDao->findAll();
        /*foreach ($categories as $category) {
            $categoryDomainObect = $this->categoryFactory->createInstance(
                false,
                $category->uuid,
                $category->category_name,
                $category->created_at,
                $category->updated_at
            );
            if(!$categoryDomainObect->isNull()) {
                $categoryCollection->add($categoryDomainObect);
            }
        }*/
        return $categories;
	}
	
	/**
	 *
	 * @param mixed $productUuid
	 *
	 * @return mixed
	 */
	function addCategoryUuidToProduct($productUuid) {
        $this->categoryDao->addCategoryUuidToProduct($productUuid);
	}
    function setProductMediator(AbstractProductRepositoryMediatorComponent $m)
    {
        $m->setCategoryRepository($this);
    }
}