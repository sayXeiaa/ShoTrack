<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ArrayExport implements FromArray
{
    protected $data;

    /**
     * Constructor to pass data to the export class.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Return the data to be exported.
     */
    public function array(): array
    {
        return $this->data;
    }
}
