<?php
namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilePolicy
{

  public function update(Request $request)
  {
    return $request->id == $request->user()->profiles->id;
  }
}