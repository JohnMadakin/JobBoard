<?php
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTest extends TestCase
{

  use DatabaseMigrations;
  /**
   * A users can signup
   *
   * @return void
   */
  public function test_applicants_can_signup()
  {
    $params = [
      'password' => 'password',
      'email' => 'example@test.com',
      'role' =>  'applicant'
    ];
    $this->json('POST', '/api/v1/signup', $params)
      ->seeStatusCode(201)
      ->seeJson([
        'success' => true,
        'message' => 'you have successfully registered'
      ]);
    $this->assertEquals(12, User::count());
  }

  public function test_employers_can_signup()
  {
    $params = [
      'password' => 'password',
      'email' => 'example@test.com',
      'role' =>  'employer'
    ];
    $this->json('POST', '/api/v1/signup', $params)
      ->seeStatusCode(201)
      ->seeJson([
        'success' => true,
        'message' => 'you have successfully registered'
      ]);
    $this->assertEquals(12, User::count());
  }


  /**
   * A users cant signup if role is invalid
   *
   * @return void
   */
  public function test_users_cant_signup_if_role_isInvalid()
  {
    $params = [
      'password' => 'password',
      'email' => 'example@test.com',
      'role' =>  'test'
    ];
    $this->json('POST', '/api/v1/signup', $params)
      ->seeStatusCode(422)
      ->seeJson([
        'role' => ['The selected role is invalid.']
      ]);
    $this->assertEquals(11, User::count());
  }

  /**
   * A users cant signup if role is invalid
   *
   * @return void
   */
  public function test_users_cant_signup_if_email_isNotUnique()
  {
    $params = [
      'password' => 'password',
      'email' => 'test@test.com',
      'role' =>  'applicant'
    ];
    $this->json('POST', '/api/v1/signup', $params)
      ->seeStatusCode(422)
      ->seeJson([
        'email' => ['The email has already been taken.']
      ]);
    $this->assertEquals(11, User::count());
  }

  /**
   * A users cant signup if role is invalid
   *
   * @return void
   */
  public function test_users_cant_signup_if_password_length_isLessThan6()
  {
    $params = [
      'password' => 'pass',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $this->json('POST', '/api/v1/signup', $params)
      ->seeStatusCode(422)
      ->seeJson([
        'password' => ['The password must be at least 6 characters.']
      ]);
    $this->assertEquals(11, User::count());
  }

  public function test_applicants_can_login()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $this->call('POST', '/api/v1/signup', $user);

    $this->json('POST', '/api/v1/login', $user)
      ->seeStatusCode(200)
      ->seeJson([
        'success' => true,
        'message' => 'login successfull'
      ]);
  }

  public function test_should_not_login_invalid_email()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $this->call('POST', '/api/v1/signup', $user);

    $this->json('POST', '/api/v1/login',[
      'password' => 'pass1233',
      'email' => 'test1223@test.com',
    ])
      ->seeStatusCode(422)
      ->seeJson([
        'email' => ['The selected email is invalid.']
      ]);
  }

  public function test_should_not_login_invalid_password()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $this->call('POST', '/api/v1/signup', $user);

    $this->json('POST', '/api/v1/login', [
      'password' => 'pass1ii',
      'email' => 'test@test.com',
    ])
    ->seeStatusCode(422)
    ->seeJson([
      'success' => false,
      'message' => 'Password is wrong.'
    ]);
  }

  public function test_should_edit_profile()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $response = $this->call('POST', '/api/v1/signup', $user);
    $token = json_decode($response->getContent())->token;
    $header = [ 'Api-Token' => $token];
    $profile = [
      'firstName' => 'test',
      'lastName' => 'test',
      'specialization' =>  'Education',
      'dob' => '12/02/1992',
      'address' => '234 test str',
      'company' =>  'andela',
      'imageLink' => 'http://googledrive.com/image/1',
      'cvLink' =>  'http://googledrive.com/docs/1',
    ];
    $this->post('/api/v1/profiles/1', $profile, $header)
      ->seeStatusCode(200)
      ->seeJson([
        'success' => true,
        'message' => 'Profile Updated'
      ]);
  }

  public function test_should_not_edit_profile_if_isNotOwner()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $response = $this->call('POST', '/api/v1/signup', $user);
    $token = json_decode($response->getContent())->token;
    $header = ['Api-Token' => $token];
    $profile = [
      'firstName' => 'test',
      'lastName' => 'test',
      'specialization' =>  'Education',
      'dob' => '12/02/1992',
      'address' => '234 test str',
      'company' =>  'andela',
      'imageLink' => 'http://googledrive.com/image/1',
      'cvLink' =>  'http://googledrive.com/docs/1',
    ];
    $this->post('/api/v1/profiles/2', $profile, $header)
      ->seeStatusCode(403)
      ->seeJson([
        'success' => false,
        'message' => 'sorry, you can only edit your profile'
      ]);
  }

  public function test_should_not_edit_profile_if_noToken()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $response = $this->call('POST', '/api/v1/signup', $user);
    $token = json_decode($response->getContent())->token;
    $header = ['Api-Token' => ''];
    $profile = [
      'firstName' => 'test',
      'lastName' => 'test',
      'specialization' =>  'Education',
      'dob' => '12/02/1992',
      'address' => '234 test str',
      'company' =>  'andela',
      'imageLink' => 'http://googledrive.com/image/1',
      'cvLink' =>  'http://googledrive.com/docs/1',
    ];
    $this->post('/api/v1/profiles/1', $profile, $header)
      ->seeStatusCode(401)
      ->seeJson([
        'success' => false,
        'message' => 'Unauthorized.'
      ]);
  }

  public function test_should_not_edit_profile_if_malformedToken()
  {
    $user = [
      'password' => 'pass1233',
      'email' => 'test1@test.com',
      'role' =>  'applicant'
    ];
    $response = $this->call('POST', '/api/v1/signup', $user);
    $token = json_decode($response->getContent())->token;
    $header = ['Api-Token' => $token.'222'];
    $profile = [
      'firstName' => 'test',
      'lastName' => 'test',
      'specialization' =>  'Education',
      'dob' => '12/02/1992',
      'address' => '234 test str',
      'company' =>  'andela',
      'imageLink' => 'http://googledrive.com/image/1',
      'cvLink' =>  'http://googledrive.com/docs/1',
    ];
    $this->post('/api/v1/profiles/1', $profile, $header)
      ->seeStatusCode(400)
      ->seeJson([
        'success' => false,
        'message' => 'Malformed or Invalid token.'
      ]);
  }




}