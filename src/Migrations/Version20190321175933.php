<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321175933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, parking_id INT DEFAULT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, reference DATETIME NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, plaque VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, number_vol_aller VARCHAR(255) NOT NULL, number_vol_retour VARCHAR(255) NOT NULL, INDEX IDX_E00CEDDEF17B2DD (parking_id), INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_option (booking_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_E11C3B4E3301C60 (booking_id), INDEX IDX_E11C3B4EA7C41D6F (option_id), PRIMARY KEY(booking_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking_option ADD CONSTRAINT FK_E11C3B4E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_option ADD CONSTRAINT FK_E11C3B4EA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_option DROP FOREIGN KEY FK_E11C3B4E3301C60');
        $this->addSql('ALTER TABLE booking_option DROP FOREIGN KEY FK_E11C3B4EA7C41D6F');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_option');
        $this->addSql('DROP TABLE `option`');
    }
}
