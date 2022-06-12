<?php 

interface RefreshTokenDao {
    function save(RefreshToken $refreshToken);
    function findRefreshTokenByRefreshToken($refreshToken);
}