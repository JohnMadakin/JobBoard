<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;


class UserService
{
  /**
   * Get a user from the DB using  email as optional parameters.
   * 
   * @param  userName $userName
   * @param email $email
   * @param password $passwword
   * @return mixed
   */
  public function getUser($email)
  {
    return User::with('profiles')->where('email', $email)->first();
  }

  /**
   * Get all users
   *
   * @return mixed
   */
  public function get()
  {
    return User::with('profiles', 'roles')->paginate(10);
  }

  /**
   * add a user to the users table .
   * 
   * @param  userName $userName
   * @param email $email
   * @param password $passwword
   * @param address $address
   * @return mixed
   */
  public function createUser($email,$password,$roleId)
  {
    return DB::transaction(function() use( $email, $password, $roleId){
      $user = User::create(
        [
          'email' => $email,
          'password' => $password,
          'role_id' => $roleId
        ]
      );
      $profile = Profile::create([
        'user_id' => $user->id
      ]);
      $user['profileId'] = $profile->id;
      return $user;
    });
  }

  public static function getClient()
  {
    $clauses = [
      'id' => 1,
      'password_client' => true,
      'revoked' => false,
    ];
    return DB::table('oauth_clients')->where($clauses)->first();
  }

}
