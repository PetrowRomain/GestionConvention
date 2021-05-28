<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223150257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP CONSTRAINT fk_c27c93698b39e1ff');
        $this->addSql('ALTER TABLE stage DROP CONSTRAINT fk_c27c9369f0a8bd04');
        $this->addSql('DROP INDEX uniq_c27c93698b39e1ff');
        $this->addSql('DROP INDEX idx_c27c9369f0a8bd04');
        $this->addSql('ALTER TABLE stage ADD lien_e_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD lien_ms_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage DROP lien_etu_id');
        $this->addSql('ALTER TABLE stage DROP lien_maitre_s_id');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369573193EF FOREIGN KEY (lien_e_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369E7E3389E FOREIGN KEY (lien_ms_id) REFERENCES maitre_stage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C27C9369573193EF ON stage (lien_e_id)');
        $this->addSql('CREATE INDEX IDX_C27C9369E7E3389E ON stage (lien_ms_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE stage DROP CONSTRAINT FK_C27C9369573193EF');
        $this->addSql('ALTER TABLE stage DROP CONSTRAINT FK_C27C9369E7E3389E');
        $this->addSql('DROP INDEX UNIQ_C27C9369573193EF');
        $this->addSql('DROP INDEX IDX_C27C9369E7E3389E');
        $this->addSql('ALTER TABLE stage ADD lien_etu_id INT NOT NULL');
        $this->addSql('ALTER TABLE stage ADD lien_maitre_s_id INT NOT NULL');
        $this->addSql('ALTER TABLE stage DROP lien_e_id');
        $this->addSql('ALTER TABLE stage DROP lien_ms_id');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT fk_c27c93698b39e1ff FOREIGN KEY (lien_etu_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT fk_c27c9369f0a8bd04 FOREIGN KEY (lien_maitre_s_id) REFERENCES maitre_stage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c27c93698b39e1ff ON stage (lien_etu_id)');
        $this->addSql('CREATE INDEX idx_c27c9369f0a8bd04 ON stage (lien_maitre_s_id)');
    }
}
