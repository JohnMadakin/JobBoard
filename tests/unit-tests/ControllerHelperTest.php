<?php

use App\Http\Helpers\ControllerHelpers;

class ControllerHelperTest extends TestCase
{
  /**
   * hash password.
   *
   * @return void
   */
  public function test_hash_password()
  {
    $encryptedPassword = ControllerHelpers::hashPassword('test');

    $this->assertInternalType('string', $encryptedPassword);
    $this->assertNotEquals('test', $encryptedPassword);  
  }

  /**
   * verify valid password.
   *
   * @return void
   */
  public function test_verify_valid_password()
  {
    $encryptedPassword = ControllerHelpers::hashPassword('test');
    $verifyPassword = ControllerHelpers::verifyPassword('test',$encryptedPassword);
    $this->assertInternalType('bool', $verifyPassword);
    $this->assertEquals(true, $verifyPassword);
  }

  /**
   * verify invalid password.
   *
   * @return void
   */
  public function test_verify_invalid_password()
  {
    $encryptedPassword = ControllerHelpers::hashPassword('test');
    $verifyPassword = ControllerHelpers::verifyPassword('test2', $encryptedPassword);
    $this->assertInternalType('bool', $verifyPassword);
    $this->assertEquals(false, $verifyPassword);
  }


}
