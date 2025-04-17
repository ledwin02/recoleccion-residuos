<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class UserCollectionsExport implements FromCollection
{
    protected $collections;

    public function __construct($collections)
    {
        $this->collections = $collections;
    }

    public function collection()
    {
        return $this->collections;
    }
}
