<?php

namespace App\Http\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;


class ProfileService
{
  /**
   * update user profile
   * 
   * @param  userName $userName
   * @param email $email
   * @param password $passwword
   * @return mixed
   */
  public function update($user)
  {
    return Profile::find($user['profileId'])->update([
      'dateOfBirth' => $user['dob'],
      'imageUrl' => $user['imageUrl'],
      'address' => $user['address'],
      'company' => $user['company'],
      'specialization' => $user['specialization'],
      'name' => $user['name'],
      'cvLink' => $user['cvLink']
    ]);
  }

}