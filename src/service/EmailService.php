<?php

interface EmailService {
    function sendVerificationCode(User $user);
}