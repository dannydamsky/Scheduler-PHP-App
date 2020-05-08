<?php

use App\Models\Operation;
use Base\Facades\DB;

/**
 * create_operations_table.php
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see Operation
 */

$tableName = Operation::TABLE_NAME;
$primaryKey = Operation::PRIMARY_KEY;
DB::executeRaw("
CREATE TABLE IF NOT EXISTS `$tableName`(
    `$primaryKey` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `model` VARCHAR(255) NOT NULL,
    `type` TINYINT UNSIGNED NOT NULL,
    `data` TEXT NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`$primaryKey`),
    INDEX(`createdAt`),
    INDEX(`type`),
    INDEX(`model`) 
);
");