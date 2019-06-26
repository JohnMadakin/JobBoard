<?php

namespace App\Http\Controllers;

use App\Http\Services\ProfileService;
use illuminate\Http\Request;


class ProfileController extends Controller
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
      'dob' => 'sometimes|date',
      'address' => 'sometimes|min:6',
      'imageUrl' => 'sometimes|url',
      'company' => 'sometimes|min:6',
      'specId' => 'required|exists:specs,id',
      'cvLink' => 'sometimes|url',
      'firstName' => 'required|regex:/^[a-z ,.\'-]+$/i |max:100',
      'lastName' => 'required|regex:/^[a-z ,.\'-]+$/i |max:100',
    ];
    $this->validate($request, $rules);
  }
  /**
   * update a user profile
   * 
   * @param  \App\User   $user 
   * @return mixed
   */

  public function updateProfile()
  {
    $this->validateRequest($this->request);
    $profileId = $this->request->id;
    $userObject = $this->request->only('firstName', 'lastName', 'dob', 'address', 'imageUrl', 'company', 'cvLink', 'specId');
    $userObject['profileId'] = $profileId;
    try {
      $userProfile = new ProfileService();
      $profile = $userProfile->update($userObject);
      if ($profile) {
        return $this->success('Profile Updated',$userObject,200);
      }
    } catch (Exception $ex) {
      return $this->success('Server Error Occured',500);
    }
  }
}
