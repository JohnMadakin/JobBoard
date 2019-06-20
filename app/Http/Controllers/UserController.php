<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use App\Http\Helpers\ControllerHelpers;
use illuminate\Http\Request;


class UserController extends Controller
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
  
  public function authenticate()
  {

  }

  public static function getRole(String $role)
  {
    if ($role === 'applicant') return 1;
    return 2;
  }


  public function register()
  {
    $this->validate($this->request, [
      'email' => 'required|unique:users',
      'password' => 'required|min:6',
      'role' => 'required|in:employer,applicant'
    ]);

      $email = $this->request->input('email');
      $password = ControllerHelpers::hashPassword($this->request->input('password'));
      $roleId = $this->getRole($this->request->input('role'));
      $user = new UserService();
      try {
      $userDetail = $user->createUser(trim($email), $password, $roleId);
      return response()->json([
        'success' => true,
        'message' => 'you have successfully registered',
        'token' => ControllerHelpers::generateJWT($userDetail)
      ], 201);
      } catch(Exception $ex){
      return response()->json([
        'success' => false,
        'message' => 'Server Error Occured'
      ], 500);
      }
  }
}
