<?php
include "vendor/autoload.php";
use PHPUnit\Framework\TestCase;

spl_autoload_register(function($class) {
    include '../classes/' . $class . '.php';
});

final class TestDB extends TestCase
{

    public function __construct()
    {   $this->newdb = new DB; 
        $this->connect = $this->newdb->getConn();
        $this->crud = new Crud($this->connect);
    }
    function test_getExistingDonation()
    {
        $result =   $this->crud->makesql("prospective_donors",'*');
        //Assert
        $this->assertEquals("SELECT * FROM prospective_donors", $result);
    }


}

//$dd  = new TestDB();
//$dd->test_getExistingDonation();