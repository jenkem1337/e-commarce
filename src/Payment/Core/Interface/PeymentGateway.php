<?php

interface PeymentGateway {
    function payWithCreditCart(Peyment $peyment);
}