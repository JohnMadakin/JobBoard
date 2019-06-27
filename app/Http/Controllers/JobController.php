<?php

namespace App\Http\Controllers;

use illuminate\Http\Request;
use Illuminate\Validation\Validator;

use App\Http\Services\ProfileService;
use App\Http\Services\JobService;
use App\Http\Helpers\ControllerHelpers;

class JobController extends Controller
{
  /**
   * The request instance.
   *
   * @var \Illuminate\Http\Request
   */
  private $request;

  /**
   * Create a new controller instance.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return void
   */
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  /**
   * Get Job by Id
   * 
   * @param  \App\User   $user 
   * @return mixed
   */
  public function getJobById()
  {
    $jobId = $this->request->id;
    $jobs = new JobService();
    $result = $jobs->getById($jobId);
    // var_dump($result);
    if (($result)) {
      return $this->success('Job found',$result,200);
    }
    return $this->error('Job not Found', 404);
  }


  /**
   * Get Job by employerId
   * 
   * @param  \App\User   $user 
   * @return mixed
   */
  public function getJobsByEmployerId()
  {
    $employerId = $this->request->id;
    $jobs = new JobService();
    $result = $jobs->getByUserId($employerId);
    if (count($result) > 0) {
      return $this->success('Jobs found',$result,200);
    }
    return $this->error('No Jobs Found for this Employer', 404);
  }

  /**
   * Delete job 
   * 
   * @param  \App\User   $user 
   * @return mixed
   */
  public function deleteJob()
  {
    //incomplete.. ensure the owner owns the resource he wants to delete
    $jobId = $this->request->id;
    $jobs = new JobService();
    $result = $jobs->delete($jobId);
    if ($result) {
      return $this->success('Job Deleted',$result,204);
    }
    return $this->error('Job not Found', 404);
  }

  /**
   * Get Jobs
   * 
   * @param  \App\User   $user 
   * @return mixed
   */
  public function getJobs()
  {
    $pageSize = $this->request->query('size') ?? 10;
    $page = $this->request->query('page') ?? 1;
    $sortBy = $this->request->query('sort') ?? 'title_asc';
    $search = $this->request->query('search');
    $location = $this->request->query('location');
    $spec = $this->request->query('spec');
    $jobType = $this->request->query('jobType');
    $filter = Array(
      'location' => $location,
      'spec' => $spec,
      'jobType' => $jobType,
    );
    $allowedSortFields = ['title','location'];
    $allowedOrder = ['asc', 'desc']; 

    $sort = ControllerHelpers::deserializeSort($sortBy, $allowedSortFields, $allowedOrder);

    if (!$sort) {
      return $this->error('Please enter a valid sort params', 400);
    }

    $jobs = new JobService();
    try {
      $result = $jobs->getJobs($page, $pageSize, $search, $sort, $filter);
      if ($result) {
        return $this->success('Job(s) found',$result,200);
      }
      return $this->error('Job not Found', 404);

    } catch (Exception $ex) {
        return $this->error('request couldnt be processed', 400);

    }
  }

  public function validateJobs()
  {
    $this->validate($this->request,[
      'title' => 'required|string',
      'summary' => 'required|string|max:255',
      'description' => 'required|string',
      'responsibilities' => 'required|string',
      'experience' => 'required|string',
      'additionalCompetencies' => 'required|string',
      'guideline' => 'required|string',
      'expiryDate' => 'required|date',
      'published' => 'required|boolean',
      'expiryDate' => 'required|date',
      'salary' => 'required|string',
      'location' => 'required|string',
      'jobTypeId' => 'required|exists:jobTypes,id',
      'specId' => 'required|exists:specs,id',
    ]);
    return array(
      'title' => trim($this->request->input('title')),
      'summary' => trim($this->request->input('summary')),
      'description' => trim($this->request->input('description')),
      'responsibilities' => trim($this->request->input('responsibilities')),
      'experience' => trim($this->request->input('experience')),
      'additionalCompetencies' => trim($this->request->input('additionalCompetencies')),
      'guideline' => trim($this->request->input('guideline')),
      'published' => $this->request->input('published'),
      'expiryDate' => trim($this->request->input('expiryDate')),
      'location' => trim($this->request->input('location')),
      'jobTypeId' => $this->request->input('jobTypeId'),
      'specId' => $this->request->input('specId'),
      'salary' => $this->request->input('salary')
    );
  }


  /**
   * create a new job
   * 
   * @param  \App\User   $user 
   * @return mixed
   */

  public function createJobs()
  {
    $userId = $this->request->user()->id;
    $jobObject = $this->validateJobs();
    $jobObject['userId'] = $userId;
    try {
      $job = new JobService();
      $jobCreated = $job->create($jobObject);
      if ($jobCreated) {
        $data = [
          'jobId' => $jobCreated->id
        ];
        return $this->success('Job Created',$data,201);
      }
    } catch (Exception $ex) {
      return $this->error('Server Error Occured', 500);
    }
  }

  /**
   * create a new job
   * 
   * @param  \App\User   $user 
   * @return mixed
   */

  public function updateJobs()
  {
    
    $jobId = $this->request->id;
    $jobObject = $this->validateJobs();
    $jobObject['jobId'] = $jobId;
    try {
      $job = new JobService();
      $jobUpdated = $job->update($jobObject);
      if ($jobUpdated) {
        $data = [
          'job' => $jobObject
        ];
        return $this->success('Job Updated',$data,200);
      }
      return $this->error('Job Could not be updated', 400);

    } catch (Exception $ex) {
      return $this->error('Server Error Occured', 500);
    }
  }

}
