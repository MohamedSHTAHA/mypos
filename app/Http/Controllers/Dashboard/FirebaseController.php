<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseController extends Controller
{
    public function index()
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/mypos-57196-firebase-adminsdk-ywtzy-b658840996.json');
        $database = $factory->createDatabase();
        $newuser = $database->getReference('laravel')->push([
            'id' => 1,
            'name' => 'mo',
            'email' => 's@s.s'
        ]);
        echo "insert into  firebase db";
        print_r($newuser->getvalue());
    }
}
