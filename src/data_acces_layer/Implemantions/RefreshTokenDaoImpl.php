<?php

use Ramsey\Uuid\Nonstandard\Uuid;

require "./vendor/autoload.php";
class RefreshTokenDaoImpl implements RefreshTokenDao {
    private DatabaseConnection $cacheConnection;

    public function __construct(DatabaseConnection $cacheConnection)
    {
        $this->cacheConnection = $cacheConnection;
    }

    function persist(RefreshToken $refreshToken)
    {
        $cacheConn = $this->cacheConnection->getConnection();
        $cacheConn->hset($refreshToken->getRefreshToken(), "uuid", $refreshToken->getUuid());
        $cacheConn->hset($refreshToken->getRefreshToken(), "user_uuid", $refreshToken->getUserUuid());
        $cacheConn->expire($refreshToken->getRefreshToken(), $refreshToken->getExpireTime());
        $cacheConn = null;

    }
    function findRefreshTokenDetailByRefreshToken($refreshToken)
    {
        $cacheConn = $this->cacheConnection->getConnection();
        $refreshTokenCacheArray = $cacheConn->hgetall($refreshToken);
        
        if($refreshTokenCacheArray == null){
            $responseArray = array(Uuid::uuid4()->toString(), Uuid::uuid4()->toString());
            $cacheConn = null;
            return $responseArray;
        }
        $responseArray = array($refreshTokenCacheArray['uuid'], $refreshTokenCacheArray['user_uuid']);
        $cacheConn = null;
        return $responseArray;
    }
}