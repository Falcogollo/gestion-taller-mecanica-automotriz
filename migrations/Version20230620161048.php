<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620161048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY cliente_ibfk_1');
        $this->addSql('DROP INDEX contacto ON cliente');
        $this->addSql('DROP INDEX nombre ON cliente');
        $this->addSql('ALTER TABLE orden_de_trabajo DROP FOREIGN KEY orden_de_trabajo_ibfk_1');
        $this->addSql('ALTER TABLE orden_de_trabajo DROP FOREIGN KEY orden_de_trabajo_ibfk_2');
        $this->addSql('ALTER TABLE orden_de_trabajo DROP FOREIGN KEY orden_de_trabajo_ibfk_3');
        $this->addSql('DROP INDEX fkid_patente ON orden_de_trabajo');
        $this->addSql('DROP INDEX fkrut ON orden_de_trabajo');
        $this->addSql('DROP INDEX fkid_cliente ON orden_de_trabajo');
        $this->addSql('ALTER TABLE orden_de_trabajo DROP fkid_cliente, DROP fkid_patente, DROP fkrut, CHANGE id_orden_trabajo id_orden_trabajo INT AUTO_INCREMENT NOT NULL, CHANGE fecha_creacion fecha_creacion DATETIME NOT NULL, CHANGE fecha_actual fecha_actual DATETIME NOT NULL, CHANGE fecha_estimada fecha_estimada DATETIME NOT NULL');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY producto_ibfk_1');
        $this->addSql('DROP INDEX fkid_ordendetrabajo ON producto');
        $this->addSql('ALTER TABLE producto DROP fkid_ordendetrabajo, CHANGE id_producto id_producto INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX fkid_cliente ON vehiculo');
        $this->addSql('ALTER TABLE vehiculo DROP fkid_cliente, CHANGE patente patente VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE usuario');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT cliente_ibfk_1 FOREIGN KEY (rut) REFERENCES vehiculo (fkid_cliente)');
        $this->addSql('CREATE INDEX contacto ON cliente (contacto)');
        $this->addSql('CREATE INDEX nombre ON cliente (nombre)');
        $this->addSql('ALTER TABLE orden_de_trabajo ADD fkid_cliente VARCHAR(255) NOT NULL, ADD fkid_patente VARCHAR(255) NOT NULL, ADD fkrut VARCHAR(255) NOT NULL, CHANGE id_orden_trabajo id_orden_trabajo INT NOT NULL, CHANGE fecha_creacion fecha_creacion DATE NOT NULL, CHANGE fecha_actual fecha_actual DATE NOT NULL, CHANGE fecha_estimada fecha_estimada DATE NOT NULL');
        $this->addSql('ALTER TABLE orden_de_trabajo ADD CONSTRAINT orden_de_trabajo_ibfk_1 FOREIGN KEY (fkid_patente) REFERENCES vehiculo (patente)');
        $this->addSql('ALTER TABLE orden_de_trabajo ADD CONSTRAINT orden_de_trabajo_ibfk_2 FOREIGN KEY (fkrut) REFERENCES trabajador (rut)');
        $this->addSql('ALTER TABLE orden_de_trabajo ADD CONSTRAINT orden_de_trabajo_ibfk_3 FOREIGN KEY (fkid_cliente) REFERENCES cliente (rut)');
        $this->addSql('CREATE INDEX fkid_patente ON orden_de_trabajo (fkid_patente)');
        $this->addSql('CREATE INDEX fkrut ON orden_de_trabajo (fkrut)');
        $this->addSql('CREATE INDEX fkid_cliente ON orden_de_trabajo (fkid_cliente)');
        $this->addSql('ALTER TABLE producto ADD fkid_ordendetrabajo INT NOT NULL, CHANGE id_producto id_producto INT NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT producto_ibfk_1 FOREIGN KEY (fkid_ordendetrabajo) REFERENCES orden_de_trabajo (id_orden_trabajo)');
        $this->addSql('CREATE INDEX fkid_ordendetrabajo ON producto (fkid_ordendetrabajo)');
        $this->addSql('ALTER TABLE vehiculo ADD fkid_cliente VARCHAR(255) NOT NULL, CHANGE patente patente VARCHAR(25) NOT NULL');
        $this->addSql('CREATE INDEX fkid_cliente ON vehiculo (fkid_cliente)');
    }
}
