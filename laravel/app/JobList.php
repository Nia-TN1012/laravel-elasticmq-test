<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobList extends Model {
    
    const STATUS_REGISTERED = 0;
    const STATUS_JOB_RUNNING = 1;
    const STATUS_JOB_FAILED = 2;
    const STATUS_JOB_SUCCESS = 3;

    protected $fillable = [
        'name', 'status', 'created_at', 'job_started_at', 'job_completed_at'
    ];
}
