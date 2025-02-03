<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExportBookingsJob implements ShouldQueue
{
    use Queueable;

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function handle(): void
    {
        Excel::store(new BookingsExport, 'exports/' . $this->filename, 'public');
    }
}
