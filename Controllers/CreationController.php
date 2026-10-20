<?php

namespace App\Controllers;

class CreationController extends Controller 
{
    public function index() 
    {
        $list = array(
            array('id' => 0, 'title' => 'création1', 'description' => 'description1', 'created_at' => '01/01/2010', 'picture' => 'picture1'),
            array('id' => 1, 'title' => 'création2', 'description' => 'description2', 'created_at' => '02/01/2010', 'picture' => 'picture2')
        );

        $this->render('creation/index', ['list' => $list]);
        
    }
}