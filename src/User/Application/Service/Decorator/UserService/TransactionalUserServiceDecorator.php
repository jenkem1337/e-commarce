<?php
class TransactionalUserServiceDecorator extends UserServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(UserService $service, TransactionalRepository $transactionalRepository)
    {
        $this->transactionalRepository = $transactionalRepository;
        parent::__construct($service);
    }
    function changePassword(ChangePasswordDto $dto):ResponseViewModel {
        try {

            $this->transactionalRepository->beginTransaction();
            
            $response = parent::changePassword($dto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (\Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        }
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto):ResponseViewModel{
        try {

            $this->transactionalRepository->beginTransaction();
            
            $response = parent::changeForgettenPassword($forgettenPasswordDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (\Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        }

    }
    function listAllUser(ListAllUserDto $listAllUserDto):ResponseViewModel {
        $response =  parent::listAllUser($listAllUserDto);
        return $response;
    }
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):ResponseViewModel{
            $response = parent::findOneUserByUuid($userUuidDto);
            return $response;
    }
    function changeFullName(ChangeFullNameDto $changeFullNameDto):ResponseViewModel{
        try {

            $this->transactionalRepository->beginTransaction();
            
            $response = parent::changeFullName($changeFullNameDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (\Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        }

    }

}