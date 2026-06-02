<?php

namespace App\Jobs;

use App\Http\Controllers\AttainmentController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAssessmentLock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        app(AttainmentController::class)->calculateAndStoreQuestionAttainment($this->id);
        app(AttainmentController::class)->calculateAndStoreCloAttainment($this->id);
        app(AttainmentController::class)->calculateAndStorePloQuestionAttainment($this->id);
        app(AttainmentController::class)->calculateAndStorePloAttainment($this->id);
    }
}
