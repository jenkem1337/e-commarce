<?php
require './vendor/autoload.php';
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
        $response->onSucsess(function (CategoryCreatedResponseDto $dto){
            echo json_encode([
                'uuid' => $dto->getUuid(),
                'category_name'=>$dto->getCategoryName(),
                'crated_at' => $dto->getCreatedAt(),
                'updated_at'=>$dto->getUpdatedAt()
            ]);
        })->onError(function(ErrorResponseDto $err) {
            echo json_encode([
                'error_message' => $err->getErrorMessage(),
                'status_code' => $err->getErrorCode()
            ]);
    
        });
    }

    function updateCategoryByUuid($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->categoryService->updateCategoryNameByUuid(
            new UpdateCategoryNameByUuidDto($uuid, $jsonBody->new_category_name)
        )->onSucsess(function (CategoryNameChangedResponseDto $response){
            echo json_encode([
                'success_message' => $response->getSuccessMessage()
            ]);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode([
                'error_message'=>$err->getErrorMessage(),
                'status_code'=> $err->getErrorCode()
            ]);
        });
    }

    function deleteCategoryByUuid($uuid){
        $this->categoryService->deleteCategoryByUuid(
            new DeleteCategoryDto($uuid)
        )->onSucsess(function (CategoryDeletedResponseDto $response){
            echo json_encode([
                'success_message' => $response->getSuccessfullMessage()
            ]);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode([
                'error_message'=>$err->getErrorMessage(),
                'status_code'=> $err->getErrorCode()
            ]);
        });
    }

    function findAllCategory(){
        $this->categoryService->findAllCategory(new FindAllCategoryDto())
                            ->onSucsess(function (AllCategoryResponseDto $response){
                                foreach($response->getCategories() as $category){
                                    echo json_encode( [
                                        'uuid' => $category->getUuid(),
                                        'category_name' => $category->getCategoryName(),
                                        'created_at' => $category->getCreatedAt(),
                                        'updated_at' => $category->getUpdatedAt()
                                    ]);
                                }
                            });
    }

    function findOneCategoryByUuid($uuid){
        $this->categoryService->findOneCategoryByUuid(new FindCategoryByUuidDto($uuid))
                            ->onSucsess(function(OneCategoryFoundedResponseDto $response){
                                echo json_encode([
                                    'uuid'=>$response->getUuid(),
                                    'category_name'=>$response->getCategoryName(),
                                    'created_at'=>$response->getCreatedAt(),
                                    'updated_at'=>$response->getUpdatedAt()
                                ]);
                            })->onError(function(ErrorResponseDto $err){
                                echo json_encode([
                                    'error_message'=>$err->getErrorMessage(),
                                    'status_code'=> $err->getErrorCode()
                                ]);
                            });
    }
}