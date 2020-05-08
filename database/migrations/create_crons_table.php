<?php

/**
 * create_crons_table.php
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see Cron
 */

use App\Models\Cron;
use Base\Facades\DB;

$tableName = Cron::TABLE_NAME;
$primaryKey = Cron::PRIMARY_KEY;
DB::executeRaw("
CREATE TABLE IF NOT EXISTS `$tableName`(
    `$primaryKey` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `command` VARCHAR(255) NOT NULL,
    `scheduledAt` TIMESTAMP NOT NULL,
    `executedFrom` TIMESTAMP NULL DEFAULT NULL,
    `executedTo` TIMESTAMP NULL DEFAULT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(`$primaryKey`),
    INDEX(`executedFrom`),
    INDEX(`scheduledAt`)
);
");