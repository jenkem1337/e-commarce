<?php

interface EmailService {
    function sendVerificationCode(VerficationCodeEmailDto $user);
    function sendChangeForgettenPasswordEmail(ForgottenPasswordEmailDto $user);
    function notifyProductSubscribersForPriceChanged(SendPriceReducedEmailDto $priceReducedEmailDto);
    function notifyUserForOrderCreated(OrderCreatedEmailDto $placeOrderDto);
}