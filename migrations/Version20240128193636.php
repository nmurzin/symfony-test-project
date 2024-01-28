<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128193636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE division_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT FK_59CD206641859289');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT FK_59CD2066296CD8AE');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT division_team_pkey');
        $this->addSql('ALTER TABLE division_team ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE division_team ADD points INT NOT NULL');
        $this->addSql('ALTER TABLE division_team ADD CONSTRAINT FK_59CD206641859289 FOREIGN KEY (division_id) REFERENCES division (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE division_team ADD CONSTRAINT FK_59CD2066296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE division_team ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE division_team_id_seq CASCADE');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT fk_59cd206641859289');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT fk_59cd2066296cd8ae');
        $this->addSql('DROP INDEX division_team_pkey');
        $this->addSql('ALTER TABLE division_team DROP id');
        $this->addSql('ALTER TABLE division_team DROP points');
        $this->addSql('ALTER TABLE division_team ADD CONSTRAINT fk_59cd206641859289 FOREIGN KEY (division_id) REFERENCES division (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE division_team ADD CONSTRAINT fk_59cd2066296cd8ae FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE division_team ADD PRIMARY KEY (division_id, team_id)');
    }
}
