<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Librarian;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class LibrarianController extends Controller
{
    //function to register a new librarian
    public function addNewLibarian(Request $req){
        $validator = Validator::make($req->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email|required|unique:librarians',
            'phone' => 'required|min:10|unique:librarians',
            'file' => 'image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $librarian = new Librarian;
            $librarian->firstname = $req->firstname;
            $librarian->lastname = $req->lastname;
            $librarian->Email = $req->email;
            $librarian->Phone = $req->phone;
            $librarian->Active = $req->active;

            if ($req->password) {
                $librarian->password = $req->password;
            }
            if ($req->hasFile('file')) {
                $file = $req->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'pro'.'.'.$extension;
                $file->move('images/', $filename);
                $librarian->profile = $filename;
            }
            $librarian->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Librarian Registered Successfully'
            ]);
        }
        
    }
    //Function to fetch all librarians
    public function fetchLibrarians(){
        $librarians = Librarian::all();
        return response()->json([
            'librarians' => $librarians
        ]);
    }
}
