<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124170137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract ADD factory_id INT DEFAULT NULL, ADD position_id INT DEFAULT NULL, ADD contract_type_id INT DEFAULT NULL, ADD employee_id INT DEFAULT NULL, DROP factory, DROP position, DROP contract_type, DROP employee');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859C7AF27D2 FOREIGN KEY (factory_id) REFERENCES factory (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859CD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contract_type (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28598C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_E98F2859C7AF27D2 ON contract (factory_id)');
        $this->addSql('CREATE INDEX IDX_E98F2859DD842E46 ON contract (position_id)');
        $this->addSql('CREATE INDEX IDX_E98F2859CD1DF15B ON contract (contract_type_id)');
        $this->addSql('CREATE INDEX IDX_E98F28598C03F15C ON contract (employee_id)');
        $this->addSql('ALTER TABLE employee DROP contracts');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859C7AF27D2');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859DD842E46');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859CD1DF15B');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28598C03F15C');
        $this->addSql('DROP INDEX IDX_E98F2859C7AF27D2 ON contract');
        $this->addSql('DROP INDEX IDX_E98F2859DD842E46 ON contract');
        $this->addSql('DROP INDEX IDX_E98F2859CD1DF15B ON contract');
        $this->addSql('DROP INDEX IDX_E98F28598C03F15C ON contract');
        $this->addSql('ALTER TABLE contract ADD factory VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD position VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD contract_type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD employee VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP factory_id, DROP position_id, DROP contract_type_id, DROP employee_id');
        $this->addSql('ALTER TABLE employee ADD contracts VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
