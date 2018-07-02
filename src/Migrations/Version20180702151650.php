<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180702151650 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, root_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(64) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, INDEX IDX_3AF3466879066886 (root_id), INDEX IDX_3AF34668727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466879066886 FOREIGN KEY (root_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX amount ON lot');
        $this->addSql('DROP INDEX name_ru ON lot');
        $this->addSql('DROP INDEX name_ru_description ON lot');
        $this->addSql('ALTER TABLE lot ADD name VARCHAR(255) NOT NULL, DROP name_ru, DROP description, DROP ktru, DROP amount, DROP payment_terms, DROP measure, DROP price_per_unit, DROP count, DROP delivery_place, DROP kato_id, DROP delivery_time, DROP requirements, DROP contract, DROP link, DROP standart, DROP published, DROP created_at, DROP updated_at, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B9245DE54 FOREIGN KEY (tender_id) REFERENCES tender (id)');
        $this->addSql('CREATE INDEX IDX_B81291B9245DE54 ON lot (tender_id)');
        $this->addSql('DROP INDEX method_id ON tender');
        $this->addSql('DROP INDEX open_date ON tender');
        $this->addSql('DROP INDEX close_date ON tender');
        $this->addSql('DROP INDEX type_id ON tender');
        $this->addSql('ALTER TABLE tender DROP user_id, DROP type_id, DROP method_id, DROP full_description, DROP customer, DROP bin_inn, DROP rnn, DROP organizer, DROP location, DROP kato_id, DROP open_date, DROP close_date, DROP app_place_get, DROP app_open_date, DROP app_place_open, DROP agent, DROP link, DROP activity, DROP gzid, DROP published, DROP created_at, DROP updated_at, DROP file_cdocs, DROP file_itogs, CHANGE amount amount INT UNSIGNED NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466879066886');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B9245DE54');
        $this->addSql('DROP INDEX IDX_B81291B9245DE54 ON lot');
        $this->addSql('ALTER TABLE lot ADD description TEXT NOT NULL COLLATE utf8_general_ci, ADD ktru VARCHAR(50) DEFAULT NULL COLLATE utf8_general_ci, ADD amount NUMERIC(12, 2) UNSIGNED DEFAULT NULL, ADD payment_terms VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD measure VARCHAR(100) NOT NULL COLLATE utf8_general_ci, ADD price_per_unit NUMERIC(12, 2) NOT NULL, ADD count INT NOT NULL, ADD delivery_place VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD kato_id INT DEFAULT NULL, ADD delivery_time VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD requirements TEXT NOT NULL COLLATE utf8_general_ci, ADD contract VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD link VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD standart VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD published TINYINT(1) DEFAULT \'0\' NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE name name_ru VARCHAR(255) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('CREATE INDEX amount ON lot (amount)');
        $this->addSql('CREATE FULLTEXT INDEX name_ru ON lot (name_ru)');
        $this->addSql('CREATE FULLTEXT INDEX name_ru_description ON lot (name_ru, description)');
        $this->addSql('ALTER TABLE tender ADD user_id INT UNSIGNED DEFAULT 0 NOT NULL, ADD type_id INT UNSIGNED NOT NULL, ADD method_id INT UNSIGNED NOT NULL, ADD full_description TEXT NOT NULL COLLATE utf8_general_ci, ADD customer VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD bin_inn VARCHAR(25) NOT NULL COLLATE utf8_general_ci, ADD rnn VARCHAR(25) NOT NULL COLLATE utf8_general_ci, ADD organizer VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD location VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD kato_id INT UNSIGNED DEFAULT NULL, ADD open_date DATETIME DEFAULT NULL, ADD close_date DATETIME DEFAULT NULL, ADD app_place_get VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, ADD app_open_date DATETIME DEFAULT NULL, ADD app_place_open VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, ADD agent VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD link VARCHAR(255) NOT NULL COLLATE utf8_general_ci, ADD activity DATETIME DEFAULT NULL, ADD gzid VARCHAR(25) DEFAULT NULL COLLATE utf8_general_ci, ADD published TINYINT(1) DEFAULT \'0\' NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD file_cdocs VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, ADD file_itogs VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, CHANGE amount amount NUMERIC(12, 2) UNSIGNED DEFAULT NULL');
        $this->addSql('CREATE INDEX method_id ON tender (method_id)');
        $this->addSql('CREATE INDEX open_date ON tender (open_date)');
        $this->addSql('CREATE INDEX close_date ON tender (close_date)');
        $this->addSql('CREATE INDEX type_id ON tender (type_id)');
    }
}
