<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230129161411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id UUID NOT NULL, sysname VARCHAR(255) NOT NULL, title TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF34668ADD472C4 ON categories (sysname)');
        $this->addSql('COMMENT ON COLUMN categories.id IS \'(DC2Type:guid)\'');
        $this->addSql('CREATE TABLE category_price_properties (id UUID NOT NULL, category_id UUID DEFAULT NULL, property_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B676874712469DE2 ON category_price_properties (category_id)');
        $this->addSql('CREATE INDEX IDX_B6768747549213EC ON category_price_properties (property_id)');
        $this->addSql('COMMENT ON COLUMN category_price_properties.id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN category_price_properties.category_id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN category_price_properties.property_id IS \'(DC2Type:guid)\'');
        $this->addSql('CREATE TABLE category_product_properties (id UUID NOT NULL, category_id UUID DEFAULT NULL, name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9F6BDB612469DE2 ON category_product_properties (category_id)');
        $this->addSql('COMMENT ON COLUMN category_product_properties.id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN category_product_properties.category_id IS \'(DC2Type:guid)\'');
        $this->addSql('CREATE TABLE product_items (id UUID NOT NULL, product_id UUID DEFAULT NULL, price_value DOUBLE PRECISION NOT NULL, price_currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_404292114584665A ON product_items (product_id)');
        $this->addSql('COMMENT ON COLUMN product_items.id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN product_items.product_id IS \'(DC2Type:guid)\'');
        $this->addSql('CREATE TABLE product_properties (product_item_id UUID NOT NULL, property_option_id UUID NOT NULL, PRIMARY KEY(product_item_id, property_option_id))');
        $this->addSql('CREATE INDEX IDX_14A46EECC3B649EE ON product_properties (product_item_id)');
        $this->addSql('CREATE INDEX IDX_14A46EECD62B1FD2 ON product_properties (property_option_id)');
        $this->addSql('COMMENT ON COLUMN product_properties.product_item_id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN product_properties.property_option_id IS \'(DC2Type:guid)\'');
        $this->addSql('CREATE TABLE product_property_options (id UUID NOT NULL, property_id UUID DEFAULT NULL, value TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_774D403549213EC ON product_property_options (property_id)');
        $this->addSql('COMMENT ON COLUMN product_property_options.id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN product_property_options.property_id IS \'(DC2Type:guid)\'');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, category_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('COMMENT ON COLUMN products.id IS \'(DC2Type:guid)\'');
        $this->addSql('COMMENT ON COLUMN products.category_id IS \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE category_price_properties ADD CONSTRAINT FK_B676874712469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_price_properties ADD CONSTRAINT FK_B6768747549213EC FOREIGN KEY (property_id) REFERENCES category_product_properties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_product_properties ADD CONSTRAINT FK_F9F6BDB612469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_items ADD CONSTRAINT FK_404292114584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_properties ADD CONSTRAINT FK_14A46EECC3B649EE FOREIGN KEY (product_item_id) REFERENCES product_items (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_properties ADD CONSTRAINT FK_14A46EECD62B1FD2 FOREIGN KEY (property_option_id) REFERENCES product_property_options (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_property_options ADD CONSTRAINT FK_774D403549213EC FOREIGN KEY (property_id) REFERENCES category_product_properties (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_price_properties DROP CONSTRAINT FK_B676874712469DE2');
        $this->addSql('ALTER TABLE category_price_properties DROP CONSTRAINT FK_B6768747549213EC');
        $this->addSql('ALTER TABLE category_product_properties DROP CONSTRAINT FK_F9F6BDB612469DE2');
        $this->addSql('ALTER TABLE product_items DROP CONSTRAINT FK_404292114584665A');
        $this->addSql('ALTER TABLE product_properties DROP CONSTRAINT FK_14A46EECC3B649EE');
        $this->addSql('ALTER TABLE product_properties DROP CONSTRAINT FK_14A46EECD62B1FD2');
        $this->addSql('ALTER TABLE product_property_options DROP CONSTRAINT FK_774D403549213EC');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A12469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE category_price_properties');
        $this->addSql('DROP TABLE category_product_properties');
        $this->addSql('DROP TABLE product_items');
        $this->addSql('DROP TABLE product_properties');
        $this->addSql('DROP TABLE product_property_options');
        $this->addSql('DROP TABLE products');
    }
}
