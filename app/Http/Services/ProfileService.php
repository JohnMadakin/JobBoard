<?php

namespace App\Http\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;


class ProfileService
{
  /**
   * update user profile
   * @return mixed
   */
  public function update($user)
  {
    return Profile::find($user['profileId'])->update([
      'dateOfBirth' => $user['dob'],
      'imageUrl' => $user['imageUrl'],
      'address' => $user['address'],
      'company' => $user['company'],
      'spec_id' => $user['specId'],
      'name' => trim($user['firstName']) .' '. trim($user['lastName']),
      'cvLink' => $user['cvLink']
    ]);
  }

}