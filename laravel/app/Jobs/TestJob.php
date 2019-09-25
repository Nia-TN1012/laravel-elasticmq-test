<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\JobList;

/** ジョブ */
class TestJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** ジョブID */
    protected $job_id;

    /** ジョブのインスタンスを新規作成します。 */
    public function __construct( $job_id ) {
        $this->job_id = $job_id;
    }

    /** ジョブを実行する時に呼び出されます。 */
    public function handle() {
        $job = JobList::find( $this->job_id );
        try {
            // ジョブ実行開始日時を保存します。
            $job->job_started_at = ( new \DateTime() )->format( "Y-m-d H:i:s" );
            $job->status = JobList::STATUS_JOB_RUNNING;
            $job->update();
            \Log::info( "Job:{$this->job_id} started." );

            // --- ここから、ジョブ本体 ---

            sleep( 5 );

            // Job IDが4以上の時、10%の確率でわざとジョブ失敗にします。
            if( $this->job_id >= 4 && \rand( 0, 9 ) <= 0 ) {
                throw new \Exception( "Failed" );
            }

            sleep( 5 );

            // --- ここまで、ジョブ本体 ---

            // ジョブ実行完了時刻を保存します。
            $job->job_completed_at = ( new \DateTime() )->format( "Y-m-d H:i:s" );
            $job->status = JobList::STATUS_JOB_SUCCESS;
            $job->update();
            \Log::info( "Job:{$this->job_id} finished." );
        }
        catch( \Exception $e ) {
            // ジョブ実行完了時刻を保存します。
            $job->job_completed_at = ( new \DateTime() )->format( "Y-m-d H:i:s" );
            $job->status = JobList::STATUS_JOB_FAILED;
            $job->update();
            \Log::error( "Job:{$this->job_id} failed." );
        }
    }
}
