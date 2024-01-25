<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123101236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url (id BIGSERIAL NOT NULL, user_id BIGINT NOT NULL, original_url VARCHAR(128) NOT NULL, minified_url VARCHAR(128) NOT NULL, count_click INT DEFAULT 0, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX url__user_id__idx ON url (user_id)');
        $this->addSql('CREATE TABLE "user" (id BIGSERIAL NOT NULL, login VARCHAR(32) NOT NULL, password VARCHAR(128) NOT NULL, email VARCHAR(128) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX users__email__uidx ON "user" (email)');
        $this->addSql('ALTER TABLE url ADD CONSTRAINT url__user_id__fk FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url DROP CONSTRAINT url__user_id__fk');
        $this->addSql('DROP TABLE url');
        $this->addSql('DROP TABLE "user"');
    }
}
