<?php

namespace App\Http\Services;

use App\Models\Job;
use Illuminate\Support\Facades\DB;


class JobService
{

  /**
   * creates a job
   * 
   * @param  userName $userName
   * @param email $email
   * @param password $passwword
   * @return mixed
   */
  public function create($job)
  {
    return Job::create([
      'title' => $job['title'],
      'user_id' => $job['userId'],
      'summary' => $job['summary'],
      'description' => $job['description'],
      'responsibilities' => $job[ 'responsibilities'],
      'experience' => $job[ 'experience'],
      'additionalCompetencies' => $job[ 'additionalCompetencies'],
      'guideline' => $job[ 'guideline'],
      'expiryDate' => $job[ 'expiryDate'],
      'published' => $job['published'],
      'salary' => $job['salary'],
      'location' => $job['location'],
      'spec_id' => $job['specId'],
      'jobType_id' => $job['jobTypeId'],

    ]);
  }

  /**
   * get job by Id
   * 
   */
  public function getById($jobId)
  {
    if($jobId) {
      return Job::with('specs', 'jobTypes')->where('id', $jobId)->first();
    }
    return false;
  }

    /**
   * get job by Id
   * 
   */
  public function getByUserId($userId)
  {
    if($userId) {
      return Job::with('specs', 'jobTypes')->where([
        'user_id' => $userId,
        'published' => true
      ])->get();
    }
    return false;
  }


  /**
   * get jobs
   * 
   */
  public function getJobs($page, $pageSize, $search, $sortBy, $filter)
  {
    $published = true;
    $loc = $filter['location'];
    $spec = $filter['spec'];
    $jobType = $filter['jobType'];
    return DB::table('jobs')->select('jobs.*', 'specs.name as specialization', 'jobTypes.name as jobType')
      ->join('jobTypes', 'jobs.jobType_id', '=', 'jobTypes.id')
      ->join('specs', 'jobs.spec_id', '=', 'specs.id')
      ->when($filter['location'], function($query, $loc) {
        return $query->where('location', '=', ucwords($loc));
      })
      ->when($filter['spec'], function($query, $spec) {
        return $query->where('specs.name', '=', ucwords($spec));
      })
      ->when($filter['jobType'], function($query, $jobType) {
        return $query->where('jobTypes.name', '=', ucwords($jobType));
      })
      ->when($published, function($query, $published){
        return $query->where('jobs.deleted_at', '=', NULL)
        ->where('published', $published);
      })
      ->when($search, function ($query, $search) {
        return $query->where('title', 'ilike', '%' . $search . '%')
          ->orWhere('additionalCompetences', 'ilike', '%' . $search . '%')
          ->orWhere('summary', 'ilike', '%' . $search . '%');
      })->when($sortBy, function ($query, $sortBy) {
        return $query->orderBy($sortBy['column'], $sortBy['order']);
      }, function ($query) {
        return $query->orderBy('title');
      })
      ->paginate($pageSize, ['*'], 'page', $page);
  }



  /**
   * delete job by Id
   * 
   */
  public function delete($jobId)
  {
    if ($jobId) {
      return Job::find($jobId)->delete();
    }
    return false;
  }

  /**
   * update user profile
   * 
   * @param  userName $userName
   * @param email $email
   * @param password $passwword
   * @return mixed
   */
  public function update($job)
  {
    return Job::find($job['jobId'])->update([
      'title' => $job['title'],
      'summary' => $job['summary'],
      'description' => $job['description'],
      'responsibilities' => $job['responsibilities'],
      'experience' => $job['experience'],
      'additionalCompetencies' => $job['additionalCompetencies'],
      'guideline' => $job['guideline'],
      'published' => $job['published'],
      'expiryDate' => $job['expiryDate'],
      'salary' => $job['salary'],
      'location' => $job['location'],
      'spec_id' => $job['specId'],
      'jobType_id' => $job['jobTypeId'],

    ]);
  }
}
