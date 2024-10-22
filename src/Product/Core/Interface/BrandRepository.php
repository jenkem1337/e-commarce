<?php
interface BrandRepository {
    function saveChanges(Brand $brand);
    function findOneAggregateByUuid($uuid):BrandInterface;
    function findOneOnlyWithSingleModelByUuidAndModelUuid($brandUuid,$modelUuid):BrandInterface;
    function findOneWithModels($uuid);
    function deleteBrand(Brand $brand);
    function findAll();
    function findOneWithSingleModel($brandUuid, $modelUuid);

}