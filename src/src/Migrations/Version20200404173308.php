<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200404173308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $sql = '
        CREATE TABLE `families` (
            `id` int(10) unsigned NOT NULL COMMENT \'科ID\',
            `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'科名\',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $this->addSql($sql);

    
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
        $this->addSql($sql);

    
        $sql = '
        CREATE TABLE `prefectures` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'都道府県ID\',
            `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT \'都道府県名\',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $this->addSql($sql);

    
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
        $this->addSql($sql);

    
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
        $this->addSql($sql);

    
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
        $this->addSql($sql);

    
        $sql = '
        CREATE TABLE `latlngs` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'地理座標ID\',
            `latlng` geometry NOT NULL COMMENT \'地理座標\',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $this->addSql($sql);

    
        $sql = '
        CREATE TABLE `images` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'画像ID\',
            `file` mediumblob NOT NULL COMMENT \'画像ファイル\',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ';
        $this->addSql($sql);

    
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
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `discoveries`');
        $this->addSql('DROP TABLE `images`');
        $this->addSql('DROP TABLE `latlngs`');
        $this->addSql('DROP TABLE `addresses`');
        $this->addSql('DROP TABLE `users`');
        $this->addSql('DROP TABLE `cities`');
        $this->addSql('DROP TABLE `prefectures`');
        $this->addSql('DROP TABLE `flowers`');
        $this->addSql('DROP TABLE `families`');
    }
}
