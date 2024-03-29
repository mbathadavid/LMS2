<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //Register Book
    public function registerBook(Request $req){
        $validator = Validator::make($req->all(),[
            'booknumber' => 'required',
            'category' => 'required',
            'class' => 'required',
            'publisher' => 'required'
        ],
    [
        //'booknumber.unique' => 'A book with similar number is already registered.Please choose another number',
        'booknumber.required' => 'You must enter the unique number of identifying the book',
        'class.required' => 'Please select the a class for which the book belongs',
        'publisher.required' => 'Please enter the publisher of the book'
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $checkbook = Book::where('BookNumber',$req->booknumber)
                                ->where('sid',$req->sid)
                                ->get();
            if (count($checkbook) > 0) {
            return response()->json([
                'status' => 401,
                'messages' => 'A Book with similar number has already been registered. Please Choose another number.' 
            ]);
            }

            $book = new Book;
            $book->BookNumber = $req->booknumber;
            $book->sid = $req->sid;
            $book->Category = $req->category;
            $book->Subject = $req->subject;
            $book->Class = $req->class;
            $book->Publisher = $req->publisher;
            $book->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Book added successfully'
            ]);
        }
    }
    //function to fetch books
    public function fetchBooks($sid){
        //$books = Book::all();
        $books = Book::where('deleted',0)
                    ->where('sid',$sid)
                    ->OrderByDesc('id')
                    ->get();

        $booksinstore = [];
        $borrowedbooks = [];

        foreach ($books as $key => $book) {
            if ($book->Status === "In Store") {
                array_push($booksinstore,$book->BookNumber);
            } else if ($book->Status === "Borrowed") {
                array_push($borrowedbooks,$book->BookNumber);
            }  
        }

        return response()->json([
            'books' => $books,
            'booksinstore' => count($booksinstore),
            'borrowedbooks' => count($borrowedbooks)
        ]);
    }
    //get Book Details
    public function getBookDetails($id){
        $bookdetails = Book::find($id);
        return response()->json([
            'bookdetails' => $bookdetails
        ]);
    }
    //issue book
    public function issueBook(Request $req){
        $sid = session()->get('schooldetails.id');

        $validator = Validator::make($req->all(),[
            'dateborrowed' => 'required',
            'returndate' => 'required',
            'admnos' => 'required'
        ],
    [
        'admnos.required' => 'You must enter admission number for whoever the book is issued to'
    ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $book = Book::find($req->bookid);
            $book->Status = 'Borrowed';
            $book->date_borrowed = $req->dateborrowed;
            $book->return_date = $req->returndate;
            $book->borrowed_by = $req->admnos;
            $book->fine = $req->fine;
            $book->save();

            // $student = Student::where('AdmissionNo',$req->admnos)
            //                     ->orWhere('')
            //                     ->get();


            // if ($req->upiadm == "UPI") {
            //     //$arraybooks = [];
            //     $student = Student::where('UPI', $req->admnos)
            //                         ->where('sid',$sid)
            //                         ->get();

            //     $studentresources = $student[0]['books'];
            //     $studentid = $student[0]['id'];
            //     $studentupdate = Student::find($studentid);

            //     if ($studentresources == null) {
            //        $studentupdate->books = $book['BookNumber'];
            //        $studentupdate->save(); 
            //     } else {
            //         $booksarray = explode(',',$studentresources);
            //         array_push($booksarray,$book['BookNumber']);
            //         $studentupdate->books = implode(',',$booksarray);
            //         $studentupdate->save(); 
            //     }

            // } else if ($req->upiadm == "admissonno") {
            //     $student = Student::where('AdmissionNo', $req->admnos)
            //                         ->where('sid',$sid)
            //                         ->get();

            //     $studentresources = $student[0]['books'];
            //     $studentid = $student[0]['id'];
            //     $studentupdate = Student::find($studentid);

            //     if ($studentresources == null) {
            //        $studentupdate->books = $book['BookNumber'];
            //        $studentupdate->save(); 
            //     } else {
            //         $booksarray = explode(',',$studentresources);
            //         array_push($booksarray,$book['BookNumber']);
            //         $studentupdate->books = implode(',',$booksarray);
            //         $studentupdate->save(); 
            //     }

            // }

            
            return response()->json([
                'status' => 200,
                'messages' => $book->BookNumber.' issued to '.$req->admnos.' successfully' 
            ]);
               }
    }
    //collect book function
    public function collectBook($ids){
        $idarray = explode(',',$ids);
        //$bookids = [];
        for ($i=0; $i < count($idarray); $i++) { 
            $book = Book::find($idarray[$i]);
            $book->Status = 'In Store';
            $book->borrowed_by = '';
            $book->save();
        }

        // for ($i=0; $i <  count($idarray); $i++) { 
        //     $book = Book::find($idarray[$i]);
        //     $stuide = $book['borrowed_by'];
        //     $student = Student::where('AdmissionNo',$stuide)
        //                         ->orWhere('UPI',$stuide)
        //                         ->get();

        //     $studentid = $student[0]['id'];
        //     $actualstudent = Student::find($studentid);
        //     $booksarray = explode(",",$actualstudent['books']);
        //     $booknumber = $book['BookNumber'];
        //     $removedbook = array_diff($booksarray,[$booknumber]);
        //     $stringified = implode(",",$removedbook);
        //     $actualstudent->books = $stringified;
        //     $actualstudent->save();
        // }

        return response()->json([
            'status' => 200,
            'messages' => 'Books Returned to store Successfully',
        ]); 
    }
    //Delete a book
    public function deleteBook($ids){
        $idarray = explode(',',$ids);
            for ($i=0; $i < count($idarray) ; $i++) { 
                $book = Book::find($idarray[$i]);
                $book->deleted = '1';
                $book->save(); 
            }
        return response()->json([
            'status' => 200,
            'messages' => 'Book deleted Successfullly'
        ]);
    }
    //Update a Book
    public function updateBook(Request $req){
        $validator = Validator::make($req->all(),[
            'booknumber2' => 'required',
            'bookcategory1' => 'required',
            'bookclass1' => 'required',
            'booksubject1' => 'required',
            'bookpublisher1' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $id = $req->bookid;
            $book = Book::find($id);
            $book->BookNumber = $req->booknumber2;
            $book->Category = $req->bookcategory1;
            $book->Class = $req->bookclass1;
            $book->Subject = $req->booksubject1;
            $book->Publisher = $req->bookpublisher1;
            $book->save();
            
            return response()->json([
                'status' => 200,
                'messages' => 'Book updated Successfully'
            ]);
        }
    }
}
