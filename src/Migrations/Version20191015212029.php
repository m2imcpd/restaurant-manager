<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191015212029 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE horaire_restaurant (horaire_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_2A6E34AE58C54515 (horaire_id), INDEX IDX_2A6E34AEB1E7706E (restaurant_id), PRIMARY KEY(horaire_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horaire_restaurant ADD CONSTRAINT FK_2A6E34AE58C54515 FOREIGN KEY (horaire_id) REFERENCES horaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE horaire_restaurant ADD CONSTRAINT FK_2A6E34AEB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE horaire_restaurant');
    }
}
