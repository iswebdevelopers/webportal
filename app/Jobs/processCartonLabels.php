<?php

namespace App\Jobs;

use App\UserLabelPrint;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;
use View;
use Log;

class processCartonLabels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cartondata;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $cartondata)
    {
        $this->cartondata = $cartondata;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->cartondata as $type => $cartons) {
            if ($cartons) {
                $view = View::make('labels.templates.'.$type, ['data' => $cartons]);
                $raw_data = (string) $view;

                try {
                    //add it to user label print
                    $this->addLabelPrint($cartons, $raw_data, $type);
                } catch (Exception $e) {
                    Log::info('Exception running queue job processCartonLabels '. $e->getMessage());
                }
            }
        }
    }

    public function addLabelPrint($label, $data, $type)
    {
        $request = Request();
        $label_print = new UserLabelPrint();
        $label_print->order_id = $label[0]['order_number'];
        $label_print->user_id = $this->user['id'];
        $label_print->type = $type;
        $label_print->raw_data = $data;
        $label_print->printed = 1;
        $label_print->creator = $this->user['email'];
        $label_print->quantity = array_sum(array_column($label, 'quantity'));
        $label_print->save();
    }
}
