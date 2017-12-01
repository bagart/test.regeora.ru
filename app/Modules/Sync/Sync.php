<?php

namespace App\Modules\Sync;

use App\Modules\Sync\Exceptions\SyncLogicException;
use App\Modules\Sync\Interfaces\SyncSourceInterface;
use App\Modules\Sync\Transport\Raspvariant\RaspvariantXML;

class Sync
{
    /**
     * @var SyncSourceInterface
     */
    private $sync_source;
    private $source_name;

    public function __construct(string $source_name)
    {
        $this->source_name = $source_name;
        switch ($this->source_name) {
            /**
             * @note ready for move to DB with modules
             */
            case RaspvariantXML::SOURCE_NAME:
                $this->sync_source = new RaspvariantXML();
                break;
            default:
                throw new SyncLogicException("Type not supported: {$this->source_name}");
        }
    }

    public function getSyncSource() : syncSourceInterface
    {
        return $this->sync_source;
    }

    public function importFile(string $import_file) : void
    {
        $this->getSyncSource()->setImportFile($import_file);
        $this->getSyncSource()->import();
    }

    public function importString(string $data) : void
    {
        $this->getSyncSource()->setImportString($data);
        $this->getSyncSource()->import();
    }
}
