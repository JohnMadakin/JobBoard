<?php

namespace App\Http\Controllers;

use App\Http\Services\ProfileService;
use illuminate\Http\Request;
use Illuminate\Validation\Validator;

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
    if ($result) {
      return response()->json([
        'success' => true,
        'jobs' => $result
      ], 200);
    }
    return response()->json([
      'success' => false,
      'message' => 'Job not Found'
    ], 404);
  }

  /**
   * Delete job
   * 
   * @param  \App\User   $user 
   * @return mixed
   */
  public function deleteJob()
  {
    $jobId = $this->request->id;
    $jobs = new JobService();
    $result = $jobs->delete($jobId);
    if ($result) {
      return response()->json([
        'success' => true,
      ], 204);
    }
    return response()->json([
      'success' => false,
      'message' => 'Job not Found'
    ], 404);
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
    $sortBy = $this->request->query('sort') ?? 'name_asc';
    $search = $this->request->query('search');
    $location = $this->request->query('location');
    $spec = $this->request->query('specialization');
    $jobType = $this->request->query('type');
    $filter = [
      'location' => $location,
      'spec' => $spec,
      'jobType' => $jobType,
    ];
    $allowedFields = ['location', 'spec', 'jobType'];
    $allowedOrder = ['asc', 'desc']; 

    $sort = ControllerHelpers::deserializeSort($sortBy, $allowedFields, $allowedOrder);

    if (!$sort) {
      return response()->json([
        'success' => false,
        'message' => 'Please enter a valid sort params'
      ], 400);
    }

    $users = new UserService();
    try {
      $result = $users->getJobs($page, $pageSize, $search, $sort, $filter);
      if ($result) {
        return response()->json([
          'success' => true,
          'users' => $result
        ], 200);
      }
    } catch (Exception $ex) {
      return response()->json([
        'success' => false,
        'message' => 'your request could not be completed'
      ], 400);
    }
  }

  public function validateJobs()
  {
    $this->validate($this->request,[
      'title' => 'required|string',
      'summary' => 'required|string|max:255',
      'description' => 'sometimes|string',
      'responsibilities' => 'sometimes|string',
      'experience' => 'sometimes|string',
      'additionalCompetences' => 'sometimes|string',
      'guideline' => 'sometimes|string',
      'expiryDate' => 'required|date',
      'published' => 'sometimes|boolean',
      'expiryDate' => 'required|date',
      'location' => 'sometimes|string',
      'jobTypeId' => 'required|exists:jobTypes',
      'specId' => 'required|exists:specs',
    ]);
    return array(
      'title' => trim($this->request->input('title')),
      'summary' => trim($this->request->input('summary')),
      'description' => trim($this->request->input('description')),
      'responsibilities' => trim($this->request->input('responsibilities')),
      'experience' => trim($this->request->input('experience')),
      'additionalCompetences' => trim($this->request->input('additionalCompetences')),
      'guideline' => trim($this->request->input('guideline')),
      'published' => $this->request->input('published'),
      'expiryDate' => trim($this->request->input('expiryDate')),
      'location' => trim($this->request->input('location')),
      'jobTypeId' => trim($this->request->input('jobTypeId')),
      'specId' => $this->request->input('specId'),
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
        return response()->json([
          'success' => true,
          'data' => [
            'jobId' => $jobCreated->id
          ],
          'message' => 'Job Created',
        ], 201);
      }
    } catch (Exception $ex) {
      return response()->json([
        'success' => false,
        'message' => 'Server Error Occured'
      ], 500);
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
        return response()->json([
          'success' => true,
          'data' => [
            'jobId' => $jobUpdated->id
          ],
          'message' => 'Job Updated',
        ], 200);
      }
    } catch (Exception $ex) {
      return response()->json([
        'success' => false,
        'message' => 'Server Error Occured'
      ], 500);
    }
  }

}
