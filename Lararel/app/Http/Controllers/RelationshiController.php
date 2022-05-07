<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;

class RelationshiController extends Controller
{
    public function OnetoOne()
    {
        // get contact detail using user
        // $user = User::with('contact')->first();
        // dd($user->toArray());

        // get user detail using contact
        $contact = Contact::with('user')->first();
        dd($contact->toArray());
    }
}
