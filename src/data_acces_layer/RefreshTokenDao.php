<?php 

interface RefreshTokenDao {
    function save(RefreshToken $refreshToken);
    function findRefreshTokenDetailByRefreshToken($refreshToken);
}