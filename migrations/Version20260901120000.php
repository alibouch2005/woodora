<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260901120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix schema synchronization';
    }

    public function up(Schema $schema): void
    {
        // No changes needed - this migration synchronizes metadata
    }

    public function down(Schema $schema): void
    {
        // No changes needed
    }
}
