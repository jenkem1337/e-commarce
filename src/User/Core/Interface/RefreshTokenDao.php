<?php 

interface RefreshTokenDao {
    function persist(RefreshToken $refreshToken);
    function findRefreshTokenDetailByRefreshToken($refreshToken);
}