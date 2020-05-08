<?php

use App\Models\RandomData;
use Base\Facades\DB;

/**
 * create_random_data_table.php
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see RandomData
 */
$tableName = RandomData::TABLE_NAME;
$primaryKey = RandomData::PRIMARY_KEY;
DB::executeRaw("
CREATE TABLE IF NOT EXISTS `$tableName`(
    `$primaryKey` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `value` TEXT NULL,
    PRIMARY KEY(`$primaryKey`)
);
");