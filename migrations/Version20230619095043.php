<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619095043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote_user DROP CONSTRAINT fk_1f7489c3db805178');
        $this->addSql('ALTER TABLE quote_user DROP CONSTRAINT fk_1f7489c3a76ed395');
        $this->addSql('DROP TABLE quote_user');
        $this->addSql('ALTER TABLE quote ADD owner VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quote ALTER "character" SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE quote_user (quote_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(quote_id, user_id))');
        $this->addSql('CREATE INDEX idx_1f7489c3a76ed395 ON quote_user (user_id)');
        $this->addSql('CREATE INDEX idx_1f7489c3db805178 ON quote_user (quote_id)');
        $this->addSql('ALTER TABLE quote_user ADD CONSTRAINT fk_1f7489c3db805178 FOREIGN KEY (quote_id) REFERENCES quote (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quote_user ADD CONSTRAINT fk_1f7489c3a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quote DROP owner');
        $this->addSql('ALTER TABLE quote ALTER character DROP NOT NULL');
    }
}
