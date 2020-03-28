<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `families` (
                `id` int(10) unsigned NOT NULL COMMENT \'科ID\',
                `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'科名\',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('flowers', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `flowers` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'花ID\',
                `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'花名\',
                `family_id` int(10) unsigned NOT NULL DEFAULT 1 COMMENT \'科ID\',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `flowers_FK` (`family_id`),
                CONSTRAINT `flowers_FK` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('prefectures', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `prefectures` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'都道府県ID\',
                `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'都道府県名\',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('cities', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `cities` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'市区町村ID\',
                `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'市区町村名\',
                `prefecture_id` int(10) unsigned NOT NULL COMMENT \'都道府県ID\',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `cities_FK` (`prefecture_id`),
                CONSTRAINT `cities_FK` FOREIGN KEY (`prefecture_id`) REFERENCES `prefectures` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('users', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `users` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `provider` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `provider_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
                `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('addresses', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `addresses` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'所在地ID\',
                `prefecture_id` int(10) unsigned NOT NULL COMMENT \'都道府県ID\',
                `city_id` int(10) unsigned DEFAULT NULL COMMENT \'市区町村ID\',
                PRIMARY KEY (`id`),
                KEY `addresses_FK_1` (`prefecture_id`),
                KEY `addresses_FK_2` (`city_id`),
                CONSTRAINT `addresses_FK_1` FOREIGN KEY (`prefecture_id`) REFERENCES `prefectures` (`id`),
                CONSTRAINT `addresses_FK_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('latlngs', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `latlngs` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'地理座標ID\',
                `latlng` geometry NOT NULL COMMENT \'地理座標\',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('images', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `images` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'画像ID\',
                `file` mediumblob NOT NULL COMMENT \'画像ファイル\',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
        Schema::table('discoveries', function (Blueprint $table) {
            $sql = '
            CREATE TABLE `discoveries` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'発見ID\',
                `user_id` bigint(20) unsigned NOT NULL COMMENT \'ユーザID\',
                `flower_id` int(10) unsigned NOT NULL DEFAULT 1 COMMENT \'花ID\',
                `address_id` int(10) unsigned DEFAULT NULL COMMENT \'所在地ID\',
                `image_id` int(10) unsigned DEFAULT NULL COMMENT \'画像ID\',
                `latlng_id` int(10) unsigned DEFAULT NULL COMMENT \'地理座標ID\',
                `discovered_at` datetime DEFAULT NULL COMMENT \'発見日時\',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `discoveries_FK` (`user_id`),
                KEY `discoveries_FK_1` (`flower_id`),
                KEY `discoveries_FK_2` (`address_id`),
                KEY `discoveries_FK_3` (`image_id`),
                KEY `discoveries_FK_4` (`latlng_id`),
                CONSTRAINT `discoveries_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
                CONSTRAINT `discoveries_FK_1` FOREIGN KEY (`flower_id`) REFERENCES `flowers` (`id`),
                CONSTRAINT `discoveries_FK_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
                CONSTRAINT `discoveries_FK_3` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
                CONSTRAINT `discoveries_FK_4` FOREIGN KEY (`latlng_id`) REFERENCES `latlngs` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ';
            DB::connection()->getPdo()->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
}
