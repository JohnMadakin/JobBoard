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

  /**
   * update a user profile
   * 
   * @param  \App\User   $user 
   * @return mixed
   */

  public function updateProfile()
  {
    $this->validate($this->request, [
      'dob' => 'sometimes|date',
      'address' => 'sometimes|min:6',
      'imageUrl' => 'sometimes|url',
      'company' => 'sometimes|min:6',
      'specialization' => 'sometimes|string',
      'cvLink' => 'sometimes|url',
      'firstName' => 'required|regex:/^[a-z ,.\'-]+$/i |max:100',
      'lastName' => 'required|regex:/^[a-z ,.\'-]+$/i |max:100',
    ]);
    $profileId = $this->request->id;
    $userObject = array(
      'profileId' => $profileId,
      'name' => trim($this->request->input('firstName')) .' '. trim($this->request->input('lastName')),
      'dob' => $this->request->input('dob'),
      'email' => $this->request->input('email'),
      'address' => $this->request->input('address'),
      'imageUrl' => $this->request->input('imageUrl'),
      'company' => $this->request->input('company'),
      'cvLink' => $this->request->input('cvLink'),
      'specialization' => $this->request->input( 'specialization'),
    );
    try {
      $userProfile = new ProfileService();
      $profile = $userProfile->update($userObject);
      if ($profile) {
        return response()->json([
          'success' => true,
          'message' => 'Profile Updated',
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
