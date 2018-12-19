<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181219110454 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE support (id INT AUTO_INCREMENT NOT NULL, media VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, tag_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, localisation_id INT NOT NULL, support_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATE NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_BFDD3168C68BE09C (localisation_id), INDEX IDX_BFDD3168315B405 (support_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_user (articles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D76F110E1EBAF6CC (articles_id), INDEX IDX_D76F110EA76ED395 (user_id), PRIMARY KEY(articles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_theme (articles_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_7F97CFFC1EBAF6CC (articles_id), INDEX IDX_7F97CFFC59027487 (theme_id), PRIMARY KEY(articles_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_tag (articles_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_FA91EB7D1EBAF6CC (articles_id), INDEX IDX_FA91EB7DBAD26311 (tag_id), PRIMARY KEY(articles_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, twitter VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, location_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, theme_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168315B405 FOREIGN KEY (support_id) REFERENCES support (id)');
        $this->addSql('ALTER TABLE articles_user ADD CONSTRAINT FK_D76F110E1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_user ADD CONSTRAINT FK_D76F110EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_theme ADD CONSTRAINT FK_7F97CFFC1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_theme ADD CONSTRAINT FK_7F97CFFC59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_tag ADD CONSTRAINT FK_FA91EB7D1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_tag ADD CONSTRAINT FK_FA91EB7DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168315B405');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('ALTER TABLE articles_tag DROP FOREIGN KEY FK_FA91EB7DBAD26311');
        $this->addSql('ALTER TABLE articles_user DROP FOREIGN KEY FK_D76F110E1EBAF6CC');
        $this->addSql('ALTER TABLE articles_theme DROP FOREIGN KEY FK_7F97CFFC1EBAF6CC');
        $this->addSql('ALTER TABLE articles_tag DROP FOREIGN KEY FK_FA91EB7D1EBAF6CC');
        $this->addSql('ALTER TABLE articles_user DROP FOREIGN KEY FK_D76F110EA76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168C68BE09C');
        $this->addSql('ALTER TABLE articles_theme DROP FOREIGN KEY FK_7F97CFFC59027487');
        $this->addSql('DROP TABLE support');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE articles_user');
        $this->addSql('DROP TABLE articles_theme');
        $this->addSql('DROP TABLE articles_tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE theme');
    }
}
