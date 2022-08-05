<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804182050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A937294869C');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9312469DE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93C4663E4');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A937294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A937294869C');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9312469DE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93C4663E4');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A937294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }
}
