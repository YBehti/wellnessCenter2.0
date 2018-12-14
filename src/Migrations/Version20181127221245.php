<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181127221245 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, locality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_code (id INT AUTO_INCREMENT NOT NULL, post_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, post_code_id INT NOT NULL, locality_id INT NOT NULL, adress_num VARCHAR(255) NOT NULL, adress_street VARCHAR(255) NOT NULL, banned TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, register_confirmation TINYINT(1) NOT NULL, registration_date DATE NOT NULL, password VARCHAR(255) NOT NULL, connection_failed INT NOT NULL, user_type VARCHAR(255) NOT NULL, INDEX IDX_8D93D6491A324924 (post_code_id), INDEX IDX_8D93D64988823A92 (locality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT NOT NULL, email_pro VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, vat_number VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider_service (provider_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_11C53875A53A8AA (provider_id), INDEX IDX_11C53875ED5CA9E6 (service_id), PRIMARY KEY(provider_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, highlight TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, validated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491A324924 FOREIGN KEY (post_code_id) REFERENCES post_code (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64988823A92 FOREIGN KEY (locality_id) REFERENCES locality (id)');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE provider_service ADD CONSTRAINT FK_11C53875A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE provider_service ADD CONSTRAINT FK_11C53875ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64988823A92');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491A324924');
        $this->addSql('ALTER TABLE provider DROP FOREIGN KEY FK_92C4739CBF396750');
        $this->addSql('ALTER TABLE provider_service DROP FOREIGN KEY FK_11C53875A53A8AA');
        $this->addSql('ALTER TABLE provider_service DROP FOREIGN KEY FK_11C53875ED5CA9E6');
        $this->addSql('DROP TABLE locality');
        $this->addSql('DROP TABLE post_code');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE provider_service');
        $this->addSql('DROP TABLE service');
    }
}
