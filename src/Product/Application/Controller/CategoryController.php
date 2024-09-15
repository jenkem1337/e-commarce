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
        $response->onSucsess(function (CategoryCreatedResponseDto $response){
            echo json_encode($response);
        })->onError(function(ErrorResponseDto $err) {
            echo json_encode($err);    
            http_response_code($err->getErrorCode());
    
        });
    }

    function updateCategoryByUuid($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->categoryService->updateCategoryNameByUuid(
            new UpdateCategoryNameByUuidDto($uuid, $jsonBody->new_category_name)
        )->onSucsess(function (CategoryNameChangedResponseDto $response){
            echo json_encode($response);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());
        });
    }

    function deleteCategoryByUuid($uuid){
        $this->categoryService->deleteCategoryByUuid(
            new DeleteCategoryDto($uuid)
        )->onSucsess(function (CategoryDeletedResponseDto $response){
            echo json_encode($response);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());
        });
    }

    function findAllCategory(){
        $this->categoryService->findAllCategory(new FindAllCategoryDto())
                            ->onSucsess(function(AllCategoryResponseDto $res){
                                echo json_encode($res);
                            });
    }

    function findOneCategoryByUuid($uuid){
        $this->categoryService->findOneCategoryByUuid(new FindCategoryByUuidDto($uuid))
                            ->onSucsess(function(OneCategoryFoundedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function(ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());
                            });
    }
}