<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190221183345 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, provider_id INT DEFAULT NULL, surfer_id INT DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, evaluation INT DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_9474526CA53A8AA (provider_id), INDEX IDX_9474526C6729D507 (surfer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6729D507 FOREIGN KEY (surfer_id) REFERENCES surfer (id)');
        $this->addSql('ALTER TABLE locality CHANGE locality locality VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE locality CHANGE locality locality VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
