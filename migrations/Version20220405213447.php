<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405213447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation_soin');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_soin (reservation_id INT NOT NULL, soin_id INT NOT NULL, INDEX IDX_13490DAAB83297E7 (reservation_id), INDEX IDX_13490DAA6F952169 (soin_id), PRIMARY KEY(reservation_id, soin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation_soin ADD CONSTRAINT FK_13490DAA6F952169 FOREIGN KEY (soin_id) REFERENCES soin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_soin ADD CONSTRAINT FK_13490DAAB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
    }
}
