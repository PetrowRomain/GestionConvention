<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223101437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE entreprise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etudiant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE maitre_stage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE representant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE entreprise (id INT NOT NULL, raison_ent VARCHAR(255) NOT NULL, num_rue_ent VARCHAR(255) NOT NULL, nom_rue_ent VARCHAR(255) NOT NULL, ville_ent VARCHAR(255) NOT NULL, code_postal_ent VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, nom_e VARCHAR(255) NOT NULL, prenom_e VARCHAR(255) NOT NULL, num_rue_e VARCHAR(255) NOT NULL, nom_rue_e VARCHAR(255) NOT NULL, code_postal_e VARCHAR(5) NOT NULL, tel_e VARCHAR(10) NOT NULL, email_e VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE maitre_stage (id INT NOT NULL, lien_ent_id INT NOT NULL, nom_ms VARCHAR(255) NOT NULL, prenom_ms VARCHAR(255) NOT NULL, tel_ms VARCHAR(10) NOT NULL, fonction_ms VARCHAR(255) NOT NULL, email_ms VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_12B274EB19D509B9 ON maitre_stage (lien_ent_id)');
        $this->addSql('CREATE TABLE representant (id INT NOT NULL, lien_ent_id INT NOT NULL, nom_r VARCHAR(255) NOT NULL, prenom_r VARCHAR(255) NOT NULL, tel_r VARCHAR(10) NOT NULL, fonction VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_80D5DBC919D509B9 ON representant (lien_ent_id)');
        $this->addSql('CREATE TABLE stage (id INT NOT NULL, lien_etu_id INT NOT NULL, lien_maitre_s_id INT NOT NULL, date_d DATE NOT NULL, date_f DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C27C93698B39E1FF ON stage (lien_etu_id)');
        $this->addSql('CREATE INDEX IDX_C27C9369F0A8BD04 ON stage (lien_maitre_s_id)');
        $this->addSql('ALTER TABLE maitre_stage ADD CONSTRAINT FK_12B274EB19D509B9 FOREIGN KEY (lien_ent_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representant ADD CONSTRAINT FK_80D5DBC919D509B9 FOREIGN KEY (lien_ent_id) REFERENCES entreprise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93698B39E1FF FOREIGN KEY (lien_etu_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369F0A8BD04 FOREIGN KEY (lien_maitre_s_id) REFERENCES maitre_stage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE maitre_stage DROP CONSTRAINT FK_12B274EB19D509B9');
        $this->addSql('ALTER TABLE representant DROP CONSTRAINT FK_80D5DBC919D509B9');
        $this->addSql('ALTER TABLE stage DROP CONSTRAINT FK_C27C93698B39E1FF');
        $this->addSql('ALTER TABLE stage DROP CONSTRAINT FK_C27C9369F0A8BD04');
        $this->addSql('DROP SEQUENCE entreprise_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etudiant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE maitre_stage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE representant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stage_id_seq CASCADE');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE maitre_stage');
        $this->addSql('DROP TABLE representant');
        $this->addSql('DROP TABLE stage');
    }
}
