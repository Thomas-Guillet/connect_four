<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180419171444 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game ADD owner_id INT NOT NULL, ADD player_id INT NOT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C99E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_232B318C7E3C61F9 ON game (owner_id)');
        $this->addSql('CREATE INDEX IDX_232B318C99E6F5DF ON game (player_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C7E3C61F9');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C99E6F5DF');
        $this->addSql('DROP INDEX IDX_232B318C7E3C61F9 ON game');
        $this->addSql('DROP INDEX IDX_232B318C99E6F5DF ON game');
        $this->addSql('ALTER TABLE game DROP owner_id, DROP player_id');
    }
}
