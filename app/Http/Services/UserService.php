<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;


class UserService
{
  /**
   * Get a user from the DB using userName or email as optional parameters.
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



  // /**
  //  * find user by id
  //  * 
  //  * @param  id $id
  //  * @return mixed
  //  */
  // public static function findUserById($id)
  // {
  //   if (is_int($id)) {
  //     return User::find($id);
  //   }
  //   return false;
  // }

  // /**
  //  * find user role by userid
  //  * 
  //  * @param  id $id
  //  * @return mixed
  //  */
  // public static function findUserRoleById($id)
  // {
  //   if (is_int($id)) {
  //     return User::find($id)->roles();
  //   }
  //   return false;
  // }

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

  // /**
  //  * add a user to the users table .
  //  * 
  //  * @param  userName $userName
  //  * @param email $email
  //  * @param password $passwword
  //  * @param address $address
  //  * @return mixed
  //  */
  // public function getAllUsers($page, $pageSize, $search, $sortBy)
  // {
  //   $users = DB::table('users')->select('id', 'name', 'userName', 'email', 'address', 'created_at as dateJoined')
  //     ->when($search, function ($query, $search) {
  //       return $query->where('name', 'ilike', '%' . $search . '%')
  //         ->orWhere('email', 'ilike', '%' . $search . '%')
  //         ->orWhere('userName', 'ilike', '%' . $search . '%');
  //     })->when($sortBy, function ($query, $sortBy) {
  //       return $query->orderBy($sortBy['column'], $sortBy['order']);
  //     }, function ($query) {
  //       return $query->orderBy('name');
  //     })->paginate($pageSize, ['*'], 'page', $page);
  //   return $users;
  // }
}
