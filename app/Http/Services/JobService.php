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
      'userId' => $job['userId'],
      'summary' => $job['summary'],
      'description' => $job['description'],
      'responsibilities' => $job[ 'responsibilities'],
      'experience' => $job[ 'experience'],
      'additionalCompetences' => $job[ 'additionalCompetences'],
      'guideline' => $job[ 'guideline'],
      'expiryDate' => $job[ 'expiryDate'],
      'published' => $job['published'],
      'salary' => $job['salary'],
      'location' => $job['location'],
      'specId' => $job['specId'],
      'jobTypeId' => $job['jobTypeId'],

    ]);
  }

  /**
   * get job by Id
   * 
   */
  public function getById($jobId)
  {
    if(is_int($jobId)) {
      return Job::with('jobTypes','specs')->where(['id' => $jobId]);
    }
    return false;
  }

  /**
   * get jobs
   * 
   */
  public function getJobs($page, $pageSize, $search, $sort, $filter)
  {
    // $jobs = DB::table('jobs')->select('items.id as itemId', 'title', 'isbn', 'numberInStock as totalNumber', 'itemTypes.name as itemType', 'categories.name as itemCategory', 'itemStocks.itemUniqueCode as itemCode', 'authors.name as author', 'items.created_at as dateAdded')
    //   ->join('jobTypes', 'items.id', '=', 'itemStocks.itemId')
    //   ->join('specs', 'items.itemTypeId', '=', 'itemTypes.id')
    //   ->when($search, function ($query, $search) {
    //     return $query->where('title', 'ilike', '%' . $search . '%')
    //       ->orWhere('authors.name', 'ilike', '%' . $search . '%')
    //       ->orWhere('isbn', 'ilike', '%' . $search . '%');
    //   })->when($sortBy, function ($query, $sortBy) {
    //     return $query->orderBy($sortBy['column'], $sortBy['order']);
    //   }, function ($query) {
    //     return $query->orderBy('name');
    //   })->paginate($pageSize, ['*'], 'page', $page);
    $jobs = Job::with('jobTypes', 'specs')->simplePaginate($pageSize);
  }



  /**
   * delete job by Id
   * 
   */
  public function delete($jobId)
  {
    if (is_int($jobId)) {
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
    return Job::updateOrCreate(['id' => $job['jobId']],[
      'title' => $job['title'],
      'summary' => $job['summary'],
      'description' => $job['description'],
      'responsibilities' => $job['responsibilities'],
      'experience' => $job['experience'],
      'additionalCompetences' => $job['additionalCompetences'],
      'guideline' => $job['guideline'],
      'published' => $job['published'],
      'expiryDate' => $job['expiryDate'],
      'salary' => $job['salary'],
      'location' => $job['location'],
      'specId' => $job['specId'],
      'jobTypeId' => $job['jobTypeId'],

    ]);
  }
}
