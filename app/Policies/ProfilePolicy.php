<?php
namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilePolicy
{

  public function update(Request $request)
  {
    // var_dump('i was here2');
    // var_dump( $user->id);
    var_dump( $request->id == $request->user()->profiles->id);

    return $request->id == $request->user()->profiles->id;
  }
}