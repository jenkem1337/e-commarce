<?php
class RefreshTokenExpireTimeEndedException extends BaseException {
    function __construct()
    {
        parent::__construct("expire time ended, you have to login again", 401);
    }
}