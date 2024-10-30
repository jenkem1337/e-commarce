<?php

class PeymentServiceImpl implements PeymentService {
    function __construct(
        private PeymentRepository $peymentRepository,
        private PeymentGateway $peymentGateway
    ){}
    function createPeyment(CreationalPaymentDto $dto){
        
    }
}