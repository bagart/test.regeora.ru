<?php

namespace App\Modules\Sync\Interfaces;

interface SyncSourceInterface
{
    public function setImportFile(string $import_file): void;

    public function setImportString(string $xml): void;

    public function import(): void;
}