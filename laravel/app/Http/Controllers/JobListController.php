<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobList;
use App\Jobs\TestJob;

/** ジョブ一覧を操作するコントローラー */
class JobListController extends Controller {
    
    /** ジョブ一覧を取得します。 */
    public function getJobList() {
        return response()->json( ['jobList' => $this->_getJobList()] );
    }

    /** ジョブを新規追加します。 */
    public function addJob() {
        $job = new JobList();
        $job->name = uniqid();
        $job->save();

        $job->name = \Queue::push( new TestJob( $job->id ) );
        $job->update();

        return response()->json( ['jobList' => $this->_getJobList()] );
    }

    /** ジョブ一覧をリセットします。 */
    public function resetJobs() {
        \DB::table( "job_lists" )->truncate();

        return response()->json( ['jobList' => []] );
    }

    /** ジョブ一覧を取得します。 */
    private function _getJobList() {
        $jobList = [];
        foreach( JobList::all() as $job ) {
            $jobList[] = [
                'id' => $job->id,
                'name' => $job->name,
                'status' => $job->status,
                'created_at' => ( new \DateTime( $job->created_at ) )->format( "Y/m/d H:i:s" ),
                'job_started_at' => ( new \DateTime( $job->job_started_at ) )->format( "Y/m/d H:i:s" ),
                'job_completed_at' => ( new \DateTime( $job->job_completed_at ) )->format( "Y/m/d H:i:s" )
            ];
        }

        return $jobList;
    }
}
