<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiImport implements WithMultipleSheets
{
    private int $rowCount = 0;

    public function sheets(): array
    {
        return [
            new TokpedImport('tokped'),
        ];
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
