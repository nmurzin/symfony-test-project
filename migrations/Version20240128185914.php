<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128185914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE division_team (division_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(division_id, team_id))');
        $this->addSql('CREATE INDEX IDX_59CD206641859289 ON division_team (division_id)');
        $this->addSql('CREATE INDEX IDX_59CD2066296CD8AE ON division_team (team_id)');
        $this->addSql('ALTER TABLE division_team ADD CONSTRAINT FK_59CD206641859289 FOREIGN KEY (division_id) REFERENCES division (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE division_team ADD CONSTRAINT FK_59CD2066296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD tournament_id INT NOT NULL');
        $this->addSql('ALTER TABLE game ADD played TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD round VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE game ALTER team_1_id DROP NOT NULL');
        $this->addSql('ALTER TABLE game ALTER team_2_id DROP NOT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_232B318C33D1A3E7 ON game (tournament_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT FK_59CD206641859289');
        $this->addSql('ALTER TABLE division_team DROP CONSTRAINT FK_59CD2066296CD8AE');
        $this->addSql('DROP TABLE division_team');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318C33D1A3E7');
        $this->addSql('DROP INDEX IDX_232B318C33D1A3E7');
        $this->addSql('ALTER TABLE game DROP tournament_id');
        $this->addSql('ALTER TABLE game DROP played');
        $this->addSql('ALTER TABLE game DROP round');
        $this->addSql('ALTER TABLE game ALTER team_1_id SET NOT NULL');
        $this->addSql('ALTER TABLE game ALTER team_2_id SET NOT NULL');
    }
}
