<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\JobList;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $job_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $job_id )
    {
        $this->job_id = $job_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $job = JobList::find( $this->job_id );
        try {
            $job->job_started_at = ( new \DateTime() )->format( "Y-m-d H:i:s" );
            $job->status = JobList::STATUS_JOB_RUNNING;
            $job->update();
            \Log::info( "Job:{$this->job_id} started." );
            sleep( 5 );

            if( $this->job_id >= 4 && \rand( 0, 9 ) <= 0 ) {
                throw new \Exception( "Failed" );
            }

            sleep( 5 );
            $job->job_completed_at = ( new \DateTime() )->format( "Y-m-d H:i:s" );
            $job->status = JobList::STATUS_JOB_SUCCESS;
            $job->update();
            \Log::info( "Job:{$this->job_id} finished." );
        }
        catch( \Exception $e ) {
            $job->job_completed_at = ( new \DateTime() )->format( "Y-m-d H:i:s" );
            $job->status = JobList::STATUS_JOB_FAILED;
            $job->update();
            \Log::error( "Job:{$this->job_id} failed." );
        }
    }
}
