<?php

interface EmailService {
    function sendVerificationCode(User $user);
    function sendChangeForgettenPasswordEmail(User $user);
    function notifyProductSubscribersForPriceChanged(SendPriceReducedEmailDto $priceReducedEmailDto);
}