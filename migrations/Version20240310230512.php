<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310230512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clientes (dni VARCHAR(45) NOT NULL, nombre VARCHAR(45) NOT NULL, apellido VARCHAR(45) NOT NULL, telefono INT NOT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitaciones (numero INT NOT NULL, precio_noche NUMERIC(8, 2) NOT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(numero)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservas (id INT AUTO_INCREMENT NOT NULL, habitacion_numero INT DEFAULT NULL, cliente_id VARCHAR(45) NOT NULL, fecha_inicio DATETIME NOT NULL, fecha_fin DATETIME NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_AA1DAB01F9C0BD49 (habitacion_numero), INDEX IDX_AA1DAB01DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservas ADD CONSTRAINT FK_AA1DAB01F9C0BD49 FOREIGN KEY (habitacion_numero) REFERENCES habitaciones (numero)');
        $this->addSql('ALTER TABLE reservas ADD CONSTRAINT FK_AA1DAB01DE734E51 FOREIGN KEY (cliente_id) REFERENCES clientes (dni)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservas DROP FOREIGN KEY FK_AA1DAB01F9C0BD49');
        $this->addSql('ALTER TABLE reservas DROP FOREIGN KEY FK_AA1DAB01DE734E51');
        $this->addSql('DROP TABLE clientes');
        $this->addSql('DROP TABLE habitaciones');
        $this->addSql('DROP TABLE reservas');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
