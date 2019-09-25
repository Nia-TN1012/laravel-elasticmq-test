<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/** ジョブモデル */
class JobList extends Model {
    
    /** ステータス: ジョブを登録しました。*/
    const STATUS_REGISTERED = 0;
    /** ステータス: ジョブを実行中です。*/
    const STATUS_JOB_RUNNING = 1;
    /** ステータス: ジョブは失敗しました。 */
    const STATUS_JOB_FAILED = 2;
    /** ステータス: ジョブは成功しました。 */
    const STATUS_JOB_SUCCESS = 3;

    protected $fillable = [
        'name', 'status', 'created_at', 'job_started_at', 'job_completed_at'
    ];
}
