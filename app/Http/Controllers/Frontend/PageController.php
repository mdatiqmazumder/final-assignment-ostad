<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    //

    function index(){
        return view('frontend.pages.index');
    }

    function cars(){
        return view('frontend.pages.cars');
    }

    function book(Car $id){
        return view('frontend.pages.book');
    }

    function login(){
        if (Cookie::get('token')) {
            return redirect()->route('rent.index')->with('success', 'You are already logged in!');
        }
        return view('frontend.pages.login');
    }
    function register(){
        return view('frontend.pages.register');
    }


}
