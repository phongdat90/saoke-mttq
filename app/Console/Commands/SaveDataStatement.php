<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaveDataStatement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:save-data {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get data file csv save db';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->argument('fileName');

        try {

            Log::info("Start get data from file $fileName");

            DB::beginTransaction();

            $stream = fopen(storage_path('app/mttq/' . $fileName), 'rb');
            $rows   = [];
            $keys   = fgetcsv($stream);
            $count  = 0;

            while (is_array($line = fgetcsv($stream))) {
                $count++;
                $row = array_combine($keys, $line);
                $data = [];
                $data['send_at'] = date('Y-m-d H:i:s', strtotime($row['send_at']));
                $data['amount'] = $this->unFormatNumber(str_replace(['₫', ' ', '.'], ['', '', ','], $row['amount']));
                $data['description'] = $row['description'];

                if(isset($row['send_by'])) {
                    $data['send_by'] = str_replace(' – A/C', '', $row['send_by']);
                }

                if(isset($row['transaction_id'])) {
                    $data['transaction_id'] = $row['transaction_id'];
                }

                if(!empty($row['amount'])) {
                    $rows[] = $data;
                }

                if($count >= 200) {
                    DB::table('statements')->insert($rows);
                    $rows   = [];
                    $count  = 0;
                }

            }

            fclose($stream);

            if(count($rows)) {
                DB::table('statements')->insert($rows);
            }

            DB::commit();
            Log::info("Get data from file $fileName Successfully!");

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
        }



    }

    protected function unFormatNumber($number): float
    {
        return (float) filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
