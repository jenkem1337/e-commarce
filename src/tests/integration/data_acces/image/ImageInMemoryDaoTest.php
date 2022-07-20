<?php
declare(strict_types=1);
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ImageInMemoryDaoTest extends TestCase {
    protected ImageInMemoryDaoImpl $dao;
    
    function setUp():void {
        $this->dao = new ImageInMemoryDaoImpl(new SqliteInMemoryConnection());
    }
}