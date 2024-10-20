<?php
class BrandController {
    private BrandService $brandService;

    function __construct(BrandService $brandService) {
        $this->brandService = $brandService;
    }

    function createBrand(){
        $jsonBody = json_decode(file_get_contents('php://input'));
        $response = $this->brandService->createBrand(
            new CreationalBrandDto($jsonBody->name)
        );
        http_response_code(201);
        echo json_encode($response);
    }

    function createBrandModel($brandUuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        $response = $this->brandService->createBrandModel(
            new CreateBrandModelDto($brandUuid, $jsonBody->model_name)
        );
        http_response_code(201);
        echo json_encode($response);
    }

    function changeBrandName($brandUuid) {
        $jsonBody = json_decode(file_get_contents('php://input'));
        $response = $this->brandService->changeBrandName(
            new ChangeBrandNameDto($brandUuid, $jsonBody->new_name)
        );
        http_response_code(200);
        echo json_encode($response);
    }

    function changeBrandModelName($brandUuid, $modelUuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        $response = $this->brandService->changeBrandModelName(
            new ChangeBrandModelNameDto($brandUuid, $modelUuid, $jsonBody->new_name)
        );
        http_response_code(200);
        echo json_encode($response);
    }

    function deleteBrand($brandUuid){
        http_response_code(200);
        echo json_encode(
            $this->brandService->deleteBrand(
                new DeleteBrandDto($brandUuid)
            )
        );
    }

    function findOneBrandWithModels($brandUuid) {
        http_response_code(200);
        echo json_encode(
            $this->brandService->findOneBrandWithModels(
                new FindOneBrandWithModelsDto($brandUuid)
            )
        );
    }

    function findAll(){
        http_response_code(200);
        echo json_encode(
            $this->brandService->findAll()
        );
    }
}