<?php

// namespace App\Console\Commands;

// use Illuminate\Console\Command;

// class ImportGeneData extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'app:import-gene-data';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Command description';

//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         //
//     }
// }




namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportGeneData extends Command
{
    protected $signature = 'import:gene-data';
    protected $description = 'Import gene data from a text file';

    public function handle()
    {
        $file = 'C:\Users\HP\OneDrive\Desktop\test_data.txt'; // Path to text file
        $rows = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($rows === false) {
            $this->error('Failed to read the file.');
            return 1;
        }

        foreach ($rows as $row) {
            $data = explode("\t", $row);
            // dd($data);

        $value = intval($data[2]);

        // Assuming the columns in your text file match the database table columns
        // Ignore the 'id' column (data[0]) and insert the rest of the row data
        DB::table('gene_data')->insert([
            'gene_id' => $data[1],
            'value' => $value,
            'SRA' => $data[3],
            'Abbreviation' => $data[4],
            'Expriment' => $data[5],
            'Disease' => $data[6],
        ]);
        }

        $this->info('Gene data imported successfully.');
    }
}

