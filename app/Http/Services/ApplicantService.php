<?php

namespace App\Http\Services;

use App\Models\Applicant;
use Illuminate\Support\Facades\DB;


class ApplicantService
{
  /**
   * update user profile
   * 
   * @param  userName $userName
   * @param email $email
   * @param password $passwword
   * @return mixed
   */
  public function create($applicant)
  {
    return Applicant::create([
      'coverLetter' => $applicant[ 'coverLetter'],
      'cvLink' => $applicant['cvLink'],
      'job_id' => $applicant['jobId'],
      'applicant_id' => $applicant['applicantId'],
    ]);
  }

  public function getAll($id)
  {
    return Applicant::where('job_id', $id)->get();
  }  
}
