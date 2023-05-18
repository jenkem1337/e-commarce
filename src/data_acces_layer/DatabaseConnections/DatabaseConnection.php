<?php
interface DatabaseConnection {
    function getConnection();
    function closeConnection();
} 