<?php

namespace App\Imports;

use App\Models\TractorListKyarcom;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TractorKyarcomImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    protected string $date;

    public function __construct(string $timestamp)
    {
        // Accept both ISO timestamps (2026-02-26T10:00:00.000Z) and plain dates
        $this->date = Carbon::parse($timestamp)->format('Y-m-d');
    }

    public function model(array $row)
    {
        // WithHeadingRow automatically lowercases and snake_cases column headers.
        // Template headers: 'No' → 'no', 'Tractor_Name' → 'tractor_name'
        $tractorName = trim((string) ($row['tractor_name'] ?? ''));

        if (empty($tractorName)) {
            return null;
        }

        return new TractorListKyarcom([
            'date' => $this->date,
            'tractor_name' => $tractorName,
            'instruction' => trim((string) ($row['no'] ?? '')),
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
