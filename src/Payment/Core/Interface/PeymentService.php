<?php

interface PeymentService {
    function createPeyment(CreationalPaymentDto $dto);
}