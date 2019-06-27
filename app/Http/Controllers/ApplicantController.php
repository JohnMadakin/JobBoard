<?php

namespace App\Http\Controllers;

use App\Http\Services\ApplicantService;
use illuminate\Http\Request;


class ApplicantController extends Controller
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

  public function validateRequest(Request $request)
  {

    $rules = [
      'coverLetter' => 'required|string',
      'cvLink' => 'sometimes|required|url',
    ];
    $this->validate($request, $rules);
  }
  /**
   * apply for a job
   * 
   * @param  
   * @return mixed
   */

  public function applyForJob()
  {
    $this->validateRequest($this->request);
    $applicantObject = $this->request->only('coverLetter', 'cvLink');

    $applicantObject['jobId'] = $this->request->id;
    $applicantObject['applicantId'] = $this->request->user()->id;
    try {
      $application = new ApplicantService();
      $result = $application->create( $applicantObject);
      if ($result) {
        return $this->success('You have Successfully Applied', $result, 201);
      }
    } catch (Exception $ex) {
      return $this->error('Server Error Occured', 500);
    }
  }

  public function getApplicants()
  {
    $jobId = $this->request->id;
    try {
      $application = new ApplicantService();
      $result = $application->getAll($jobId);
      if (count($result) > 0) {
        return $this->success('Applicants Found', $result, 201);
      }
      return $this->error('No Applicants for this Job', 404);

    } catch (Exception $ex) {
      return $this->error('Server Error Occured', 500);
    }
  }
}
