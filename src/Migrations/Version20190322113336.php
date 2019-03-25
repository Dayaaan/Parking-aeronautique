<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190322113336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_option DROP FOREIGN KEY FK_E11C3B4EA7C41D6F');
        $this->addSql('CREATE TABLE booking_advantage (booking_id INT NOT NULL, advantage_id INT NOT NULL, INDEX IDX_BABCEAA23301C60 (booking_id), INDEX IDX_BABCEAA23864498A (advantage_id), PRIMARY KEY(booking_id, advantage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advantage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_advantage ADD CONSTRAINT FK_BABCEAA23301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_advantage ADD CONSTRAINT FK_BABCEAA23864498A FOREIGN KEY (advantage_id) REFERENCES advantage (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE booking_option');
        $this->addSql('DROP TABLE `option`');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_advantage DROP FOREIGN KEY FK_BABCEAA23864498A');
        $this->addSql('CREATE TABLE booking_option (booking_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_E11C3B4E3301C60 (booking_id), INDEX IDX_E11C3B4EA7C41D6F (option_id), PRIMARY KEY(booking_id, option_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE booking_option ADD CONSTRAINT FK_E11C3B4E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_option ADD CONSTRAINT FK_E11C3B4EA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE booking_advantage');
        $this->addSql('DROP TABLE advantage');
    }
}
