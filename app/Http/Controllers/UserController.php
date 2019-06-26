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
  private $client;
  /**
   * Create a new controller instance.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return void
   */
  public function __construct(Request $request)
  {
    $this->request = $request;
    $this->client = UserService::getCLient();
  }
  
  public function getRole(String $role)
  {
    if ($role === 'applicant'){
      $applicant = [
        'roleId' => 1,
        'scope' => 'apply-jobs'
      ];
      return $applicant;
    }
    $employer = [
      'roleId' => 2,
      'scope' => 'create-jobs update-jobs'
    ];

    return $employer;
  }

  public function generateToken($username, $password,$scope, $client)
  {
    return REQUEST::create(
      'api/v1/oauth/token',
      'POST',
      [
        'grant_type' => 'password',
        'username' => $username,
        'password' => $password,
        'client_id' => $client->id,
        'client_secret' => $client->secret,
        'scope' => $scope
      ]
   );
  }


  public function register()
  {
    global $app;
    $this->validate($this->request, [
      'email' => 'required|unique:users',
      'password' => 'required|min:6',
      'role' => 'required|in:employer,applicant'
    ]);
    $email = $this->request->input('email');
    $password = ControllerHelpers::hashPassword($this->request->input('password'));
    $role = $this->getRole($this->request->input('role'));
    $user = new UserService();
    try {
      $userDetail = $user->createUser(trim($email), $password, $role['roleId']);
      $token = $this->generateToken($email, $this->request->input('password'), $role['scope'],$this->client
      );

      return $app->dispatch($token);
    } catch(Exception $ex){
      $message = 'Server Error Occured';
      return $this->error($message, 500);
    }
  }

  /**
   * Authenticate a user and return the token if the provided credentials are correct.
   * 
   * @param  \App\User   $user 
   * @return mixed
   */

  public function authenticate()
  {
    global $app;
    $this->validate($this->request, [
      'email' => 'required|email|exists:users',
      'password' => 'required|min:6',
    ]);
    $email = $this->request->input('email');
    $password = $this->request->input('password');
    $user = new UserService();
    $userFound = $user->getUser($email);
    if(ControllerHelpers::verifyPassword($password, $userFound->password)) {
      $scope = $this->getUserScopeByRoleId($userFound->role_id);
      $token = $this->generateToken($email, $password, $scope, $this->client);

      return $app->dispatch($token);
    }
    $message = 'Email or Password is wrong.';
    return $this->error($message,422);
  }

  public function getUserScopeByRoleId($roleId)
  {
    if($roleId == 1) return 'apply-jobs';
    if($roleId == 2) return 'create-jobs update-jobs';
    return '';
  }


}
