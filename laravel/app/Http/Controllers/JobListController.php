<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobList;
use App\Jobs\TestJob;

class JobListController extends Controller {
    
    public function getJobList() {
        return response()->json( ['jobList' => $this->_getJobList()] );
    }

    public function addJob() {
        $job = new JobList();
        $job->name = uniqid();
        $job->save();

        $job->name = \Queue::push( new TestJob( $job->id ) );
        $job->update();

        return response()->json( ['jobList' => $this->_getJobList()] );
    }

    public function resetJobs() {
        \DB::table( "job_lists" )->truncate();

        return response()->json( ['jobList' => []] );

    }

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
