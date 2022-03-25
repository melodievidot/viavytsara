<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311100441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservationy_soin DROP FOREIGN KEY FK_CADF8655B61A180D');
        $this->addSql('CREATE TABLE reservation_soin (reservation_id INT NOT NULL, soin_id INT NOT NULL, INDEX IDX_13490DAAB83297E7 (reservation_id), INDEX IDX_13490DAA6F952169 (soin_id), PRIMARY KEY(reservation_id, soin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_soin ADD CONSTRAINT FK_13490DAAB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_soin ADD CONSTRAINT FK_13490DAA6F952169 FOREIGN KEY (soin_id) REFERENCES soin (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reservationy');
        $this->addSql('DROP TABLE reservationy_soin');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservationy (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservationy_soin (reservationy_id INT NOT NULL, soin_id INT NOT NULL, INDEX IDX_CADF8655B61A180D (reservationy_id), INDEX IDX_CADF86556F952169 (soin_id), PRIMARY KEY(reservationy_id, soin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservationy_soin ADD CONSTRAINT FK_CADF86556F952169 FOREIGN KEY (soin_id) REFERENCES soin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservationy_soin ADD CONSTRAINT FK_CADF8655B61A180D FOREIGN KEY (reservationy_id) REFERENCES reservationy (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reservation_soin');
    }
}
