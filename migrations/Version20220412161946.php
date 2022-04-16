<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412161946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD produitboutique_id INT NOT NULL, ADD parent_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD pseudo VARCHAR(255) NOT NULL, ADD rgpd TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF06114B293 FOREIGN KEY (produitboutique_id) REFERENCES produit_boutique (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0727ACA70 FOREIGN KEY (parent_id) REFERENCES avis (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF06114B293 ON avis (produitboutique_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0727ACA70 ON avis (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF06114B293');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0727ACA70');
        $this->addSql('DROP INDEX IDX_8F91ABF06114B293 ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF0727ACA70 ON avis');
        $this->addSql('ALTER TABLE avis DROP produitboutique_id, DROP parent_id, DROP active, DROP email, DROP pseudo, DROP rgpd');
    }
}
