<?php
use Ramsey\Uuid\Uuid;
class CategoryController {
    private CategoryService $categoryService;
    function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    function createNewCategory(){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $response = $this->categoryService->createNewCategory(
            new CategoryCreationalDto(
                Uuid::uuid4(),
                $jsonBody->category_name,
                date ('Y-m-d H:i:s'),
                date ('Y-m-d H:i:s')
            )
        );
        echo json_encode($response);
        http_response_code(201);
    }

    function updateCategoryByUuid($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $response = $this->categoryService->updateCategoryNameByUuid(
            new UpdateCategoryNameByUuidDto($uuid, $jsonBody->new_category_name)
        );
        echo json_encode($response);
        http_response_code(201);

    }

    function deleteCategoryByUuid($uuid){
        $response = $this->categoryService->deleteCategoryByUuid(new DeleteCategoryDto($uuid));
        echo json_encode($response);
        http_response_code(201);

    }

    function findAllCategory(){
        $response = $this->categoryService->findAllCategory(new FindAllCategoryDto());
        echo json_encode($response);
        http_response_code(201);

    }

    function findOneCategoryByUuid($uuid){
        $response = $this->categoryService->findOneCategoryByUuid(new FindCategoryByUuidDto($uuid));
        echo json_encode($response);
        http_response_code(201);

    }
}