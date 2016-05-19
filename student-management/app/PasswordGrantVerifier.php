<?php
namespace App;

use Illuminate\Support\Facades\Hash;
use App\User;

class PasswordGrantVerifier
{
  public function verify($username, $password)
  {
      $user = User::where('email', $username)->first();
      if ($user && Hash::check($password, $user->password)) {
          return $user->id;
      }
      return false;
  }
}