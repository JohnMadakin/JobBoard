<?php
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

  use DatabaseMigrations;
  /**
   * A users can signup
   *
   * @return void
   */
  public function test_users_can_signup()
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


}