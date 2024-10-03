<?php



class TransactionalAuthServiceDecorator extends AuthServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(AuthService $service, TransactionalRepository $transactionalRepository)
    {
        $this->transactionalRepository = $transactionalRepository;
        parent::__construct($service);
    }
    function login(UserLoginDto $userLoginDto): ResponseViewModel
    {                                                   
        try {
            
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::login($userLoginDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }
    function register(UserCreationalDto $userCreationalDto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::register($userCreationalDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        }
    }
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto): ResponseViewModel
    {
        try {
            
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::verifyUserAccount($emailVerificationDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }
    function refreshToken(RefreshTokenDto $refDto): ResponseViewModel
    {
        try {
            
            
            $this->transactionalRepository->beginTransaction();
            $response= parent::refreshToken($refDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }
    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto): ResponseViewModel
    {
        try {
            
            
            $this->transactionalRepository->beginTransaction();
            $response= parent::sendChangeForgettenPasswordEmail($forgettenPasswordMailDto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (\Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }
}