<?php

namespace App\Http\Controllers;
use App\Models\Term;
use App\Models\classes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TermController extends Controller
{
    //Add term
    public function addTerm(Request $req){
        $validator = Validator::make($req->all(),[
            'class' => 'required',
            'term' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $term = new Term;
            $term->class = $req->class;
            $term->term = $req->term;
            $term->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Term Registered Successfully'
            ]);
        }
        
    }
    //Function to fetch terms data
    public function fetchTerms(){
        $classes = classes::all();
        $terms = Term::all();

        return response()->json([
            'terms' => $terms,
            'classes' => $classes
        ]);
    }
    //Function to fetch one term
    public function fetchTerm($class){
        $data = explode(',',$class);
        $classes = classes::find($data[1]);
        $cterm = $classes['current_term'];
        $term = Term::where('class',$data[0])
                    ->get();
        return response()->json([
            'terms' => $term,
            'cterm' => $cterm
        ]);
    }
    //update term
    public function updateTerm(Request $req){
        $validator = Validator::make($req->all(),[
            'class' => 'required',
            'term' => 'required'
        ],
    [
        'term.required' => 'You must select a term to update'
    ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $classinfo = $req->class;
            $classdata = explode(',',$classinfo);
            $term = classes::find($classdata[1]);
            $term->current_term = $req->term;
            $term->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Current Term for '.$classdata[0].' set successfully'
            ]);
        }
        
    }
}
