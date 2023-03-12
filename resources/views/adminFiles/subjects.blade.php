@extends('layouts.layout')

@section('title','Subjects')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
<div class="loader d-none"></div>
@include('adminFiles.topnav')
<div class="row p-2 border border-success border-2 mt-2 mr-3">
    <div class="col-lg-5 col-md-4 border border-info p-3">
    
    @if( session()->get('schooldetails.level') === "PrimarySchool")
    <h5 class="text-center text-success"><b>Please Select The Subjects Offered to Register</b></h5>
    <form action="#" id="primary844subjects" method="POST">
    <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
    <input type="text" value="8-4-4" name="system" id="system" hidden>
    <input type="text" value="Primary" name="level" id="level" hidden>
    <input type="text" value="" name="pathway" id="pathway" hidden>
            <div class="mb-2 border border-success border-3 p-2">
                <h5 class="text-center text-danger">8-4-4 SUBJECTS</h5>
                <table id="8-4-4subjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="844subjects">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER 8-4-4 SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
            </div>
    

            <div>
            <form action="#" id="preprimarysubjects" method="POST">
            <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
            <input type="text" value="CBC" name="system" id="system" hidden>
            <input type="text" value="Pre-Primary" name="level" id="level" hidden>
            <input type="text" value="" name="pathway" id="pathway" hidden>
                <h5 class="text-center text-success">CBC SUBJECTS</h5>
                <div class="mb-2 border border-success border-3 p-2">
                    <h6 class="text-center">Pre-Primary</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="cbcpreprimary">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER PRE-PRIMARY SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>

                <div class="mb-2 border border-success border-3 p-2">
                <form action="#" id="lowerprimarysubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Lower-Primary" name="level" id="level" hidden>
                <input type="text" value="" name="pathway" id="pathway" hidden>  
                <h6 class="text-center">Lower Primary</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="cbclowerprimary">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER LOWER-PRIMARY SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>

                <div class="mb-2 border border-success border-3 p-2">
                <form action="#" id="upperprimarysubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Upper-Primary" name="level" id="level" hidden>
                <input type="text" value="" name="pathway" id="pathway" hidden>
                    <h6 class="text-center">Upper Primary</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="cbcupperprimary">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER UPPER-PRIMARY SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>

                <div class="mb-2 border border-success border-3 p-2">
                <form action="#" id="juniorsecondarysubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Junior Secondary" name="level" id="level" hidden>
                <input type="text" value="" name="pathway" id="pathway" hidden>
                    <h6 class="text-center">Junior Secondary</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="juniorsecondary">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER JUNIOR-SECONDARY SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>
            </div> 

    @else( session()->get('schooldetails.level') === "SecondarySchool")
    <h5 class="text-center text-success"><b>Please Select The Subjects Offered to Register</b></h5>
           <div class="mb-2 mb-2 border border-success border-3 p-2">
           <form action="#" id="secondary844subjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="8-4-4" name="system" id="system" hidden>
                <input type="text" value="Secondary" name="level" id="level" hidden>
                <input type="text" value="" name="pathway" id="pathway" hidden>
                <h5 class="text-center text-danger">8-4-4 SUBJECTS</h5>
                <table id="8-4-4subjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="844secondarysubjects">
                      
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER 8-4-4 SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
            </div>

            <div>
                <h5 class="text-center text-success">CBC SUBJECTS</h5>
                <form action="#" id="juniorsecondarysubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Junior Secondary" name="level" id="level" hidden>
                <input type="text" value="" name="pathway" id="pathway" hidden>
                <div class="mb-2 border border-success border-3 p-2">
                    <h6 class="text-center">Junior Secondary</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="juniorsecondary">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER JUNIOR-SECONDARY SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>

                <div>
                <form action="#" id="artssportsubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Senior Secondary" name="level" id="level" hidden>
                <input type="text" value="Arts and Sports Science Pathway" name="pathway" id="pathway" hidden>
                <h6 class="text-center">Upper Secondary</h6>
                <div class="mb-2 border border-success border-3 p-2">
                    <h6 class="text-center">Arts and Sports Science Pathhway</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="cbcartssportpathh">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER ARTS & SPORTS SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>

                <div class="mb-2 border border-success border-3 p-2">
                <form action="#" id="socialsciencessubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Senior Secondary" name="level" id="level" hidden>
                <input type="text" value="Social Sciences Pathway" name="pathway" id="pathway" hidden>
                    <h6 class="text-center">Social Sciences Pathway Subjects</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="cbcsocialsciencespath">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER SOCIAL SCIENCES SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>

                
                <div class="mb-2 border border-success border-3 p-2">
                <form action="#" id="scietechsubjects" method="POST">
                <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
                <input type="text" value="CBC" name="system" id="system" hidden>
                <input type="text" value="Senior Secondary" name="level" id="level" hidden>
                <input type="text" value="STEM Pathway" name="pathway" id="pathway" hidden>
                    <h6 class="text-center">Science,Technology, Engineering and Mathematics Subjects</h6>
                    <table id="cbcsubjectstable" class="table">
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Subject</th> 
                    </tr>
                    </thead>
                    <tbody id="cbcscitechengmath">
            
                    </tbody>
                </table>
                <div class="form-group d-grid">
                 <input type="submit" id="subregbtn" value="REGISTER STEM SUBJECTS" class="btn btn-sm rounded-0 btn-danger">
                </div>
                </form>
                </div>
                </div>
            </div>
    @endif
    

        <!-- <form action="#" class="border border-danger p-2" id="subjectregform" method="POST">
        <div id="response"></div>
        <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
            <div class="form-group mb-3">
                <label for="">Subject</label>
                <input placeholder="Enter the subject Name" type="text" name="subject" id="subject" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-3">
                <label for="">Subject Category</label>
                <select name="category" id="category" class="form-control">
                    <option value="">--Select Category--</option>
                    <option value="Humanities">Humanities</option>
                    <option value="Sciences">Sciences</option>
                    <option value="Languages">Languages</option>
                    <option value="Technical">Technical</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-3">
                <input id="subregbtn" type="submit" class="btn btn-success form-control" value="ADD SUBJECT">
            </div>
        </form> -->
    </div>

    <div class="col-lg-7 col-md-8 border border-success p-3">
    <!-- <h6 class="text-center text-success">Subjects Management</h6>
    <form action="#" method="POST">
        <div class="form-group">
            <select class="form-control" name="subjecttomanage" id="subjecttomanage">
            <option value="">--Select Subject To Manage--</option>
            </select>
        </div>
    </form> -->

    <div class="table-responsive">
    <div id="response2"></div>
        <h6 class="text-center text-danger"><b>SUBJECTS OFFERED</b></h6>
        <table id="subjectstablebody" class="table">
            <thead>
                <tr>
                    <th scope="col">SUBJECT</th>
                    <th scope="col">SCHOOL SYSTEM</th>
                    <th scope="col">LEVEL</th>
                    <th scope="col">PATHWAY</th>
                </tr>
            </thead>
            <tbody id="subjectstable">

            </tbody>
        </table>
    </div>
    <!-- <div id="actionbtns" class="pt-2 d-none">
    <button type="button" class="btn btn-sm btn-info">View Grading System</button>
    <button type="button" id="gradingsystembtn" class="btn btn-sm btn-warning float-end">Update Grading System</button>
    </div> -->
    <div>
</div>

</div>
</div>

<!-- Update Subject Modal Start -->
<div class="modal w3-animate-zoom" id="subjecteditmodal" tabindex="-1" aria-labelledby="booksaddModalLabel">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="booksaddModalLabel">EDIT <span id="subtoedit"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" id="subjectupdateform">
        <div class="row">
            <div class="form-group d-none">
                <input type="number" name="subid" id="subid" class="form-control">
            </div>

            <div class="form-group mb-2">
                <label>Subject</label>
                <input type="text" name="subject" id="subname" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-2">
                <label>Subject Category</label>
                <select class="form-control" name="category" id="subeditcat">
                 <option id="editcat"></option>
                 <option value="Humanities">Humanities</option>
                 <option value="Sciences">Sciences</option>
                 <option value="Languages">Languages</option>
                 <option value="Technical">Technical</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group d-grid">
                <button type="submit" class="btn btn-sm rounded-0 w3-teal">EDIT SUBJECT <span id="subinbtn"></span></button>
            </div>

        </div>
        </form>
        </div>
        </div>
        </div>
<!-- Update Subject Modal End -->

<!-- <div id="gradesdiv" class="p-2 mt-2 border border-2 border-info d-none">
<form action="#" class="p-2" method="POST" id="GradeForm">
<h6 class="text-center text-danger p-1 bg-info d-none" id="graderegdiv"></h6>  
<div class="row">
<h6 class="text-center text-success">Grading System</h6>
    <div class="col-lg-4 col-md-3 p-2 border border-success">
    <div class="form-group mb-2 d-none">
        <label for="">SUBJECT</label>
        <input readonly value="" class="form-control" type="text" name="subject" id="subject1">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group mb-2">
        <label for="">Class</label>
    <select name="class" id="class" class="form-control">
        <option value="">--Select Class--</option>
        <option value="FORM ONE">FORM ONE</option>
        <option value="FORM TWO">FORM TWO</option>
        <option value="FORM THREE">FORM THREE</option>
        <option value="FOUR FOUR">FOUR FOUR</option>
    </select>
    <div class="invalid-feedback"></div>
    </div>
    </div>

    <div class="col-lg-8 col-md-9 border border-danger p-2">
    <div id="gradestable" class="table-responsive">
    <table class="table">
            <thead>
            <tr>
                <th scope="col">MIN MARKS</th>
                <th scope="col">MAX MARKS</th>
                <th scope="col">POINTS</th>
                <th scope="col">GRADE</th>
                <th scope="col">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input class="form-control" type="number" name="minA" id="minA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="99" class="form-control" type="number" name="maxA" id="maxA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="12" class="form-control" type="number" name="pointsA" id="pointsA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="A" class="form-control" type="text" name="gradeA" id="gradeA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="Excellent" class="form-control" type="text" name="RemarksA" id="RemarksA">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minA_minus" id="minA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxA_minus" id="maxA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="11" class="form-control" type="number" name="pointsA_minus" id="pointsA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="A-" class="form-control" type="text" name="gradeA_minus" id="gradeA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="Very Good" class="form-control" type="text" name="RemarksA_minus" id="RemarksA_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_plus" id="minB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_plus" id="maxB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="10" class="form-control" type="number" name="pointsB_plus" id="pointsB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B+" class="form-control" type="text" name="gradeB_plus" id="gradeB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="Good" class="form-control" type="text" name="RemarksB_plus" id="RemarksB_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB" id="minB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB" id="maxB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="9" class="form-control" type="number" name="pointsB" id="pointsB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B" class="form-control" type="text" name="gradeB" id="gradeB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="Fairly Good" class="form-control" type="text" name="RemarksB" id="RemarksB">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_minus" id="minB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_minus" id="maxB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="8" class="form-control" type="number" name="pointsB_minus" id="pointsB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B-" class="form-control" type="text" name="gradeB_minus" id="gradeB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksB_minus" id="RemarksB_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_plus" id="minC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_plus" id="maxC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="7" class="form-control" type="number" name="pointsC_plus" id="pointsC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C+" class="form-control" type="text" name="gradeC_plus" id="gradeC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_plus" id="RemarksC_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC" id="minC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC" id="maxC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="6" class="form-control" type="number" name="pointsC" id="pointsC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C" class="form-control" type="text" name="gradeC" id="gradeC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC" id="RemarksC">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_minus" id="minC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_minus" id="maxC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="5" class="form-control" type="number" name="pointsC_minus" id="pointsC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C-" class="form-control" type="text" name="gradeC_minus" id="gradeC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_minus" id="RemarksC_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_plus" id="minD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_plus" id="maxD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="4" class="form-control" type="number" name="pointsD_plus" id="pointsD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D+" class="form-control" type="text" name="gradeD_plus" id="gradeD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_plus" id="RemarksD_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD" id="minD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD" id="maxD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="3" class="form-control" type="number" name="pointsD" id="pointsD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D" class="form-control" type="text" name="gradeD" id="gradeD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD" id="RemarksD">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_minus" id="minD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_minus" id="maxD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="2" class="form-control" type="number" name="pointsD_minus" id="pointsD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D-" class="form-control" type="text" name="gradeD_minus" id="gradeD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_minus" id="RemarksD_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minE" id="minE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxE" id="maxE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="1" class="form-control" type="number" name="pointsE" id="pointsE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="E" class="form-control" type="text" name="gradeE" id="gradeE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="Very Poor" class="form-control" type="text" name="RemarksE" id="RemarksE">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>
        </tbody>
    </div>
    </div>
    </div>

    <div class="form-group d-grid">
        <input class="btn btn-info btn-sm rounded-0" type="submit" value="UPDATE GRADING SYSTEM">
    </div>
</form>
</div> -->

</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        //setting csrf token
        $.ajaxSetup({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

    //Subjects arrays
    var primary844subject = ['English','Kiswahili','Mathematics','Science','Social Studies'];
    var primaryprecbc = ['Language Activities','Mathematical Activities','Environmental Activities',
                         'Psychomotor and Creative Activities','Religious Education Activities','Pre Braille Activities'
                        ];
    var primarylowercbc = ['Literacy Activities','Braille Literacy Activities','Kiswahili Language Activities',
                           ' Kenya Sign Language','Religious Education Activities','Movement and Creative Activities'
                          ];
    var primaryuppercbc = ['English','Kiswahili','Kenya Sign Language','Home Science','Agriculture','Science and Technology',
                           'Mathematics','CRE','IRE','HRE','Creative Arts','Physical and Health Education','Social Studies',
                           'Indigenous languages','Braille literacy'
                          ];
            

    $('#844subjects').html('');
    for (let i = 0; i < primary844subject.length; i++) {
        const element = primary844subject[i];
        $('#844subjects').append('<tr>\
        <td><input value="'+element+'" id="subject1" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbcpreprimary').html();
    for (let i = 0; i < primaryprecbc.length; i++) {
        const element = primaryprecbc[i];
        $('#cbcpreprimary').append('<tr>\
        <td><input value="'+element+'" id="subject2" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbclowerprimary').html();
    for (let i = 0; i < primarylowercbc.length; i++) {
        const element = primarylowercbc[i];
        $('#cbclowerprimary').append('<tr>\
        <td><input value="'+element+'" id="subject3" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbcupperprimary').html();
    for (let i = 0; i < primaryuppercbc.length; i++) {
        const element = primaryuppercbc[i];
        $('#cbcupperprimary').append('<tr>\
        <td><input value="'+element+'" id="subject4" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    var secondary844 = ['English','Kiswahili','Arabic','German','French','Mathematics','Chemistry','Physics','Biology','Home Science',
                        'Agriculture','Computer Studies','History','Geography','CRE','IRE','HRE','Life Skills',
                        'Business Studies','Music','Art and Design','Drawing and design','Building/Construction','Power and Mechanics',
                        'Metal work','Aviation','Woodwork','Electronics',
                        ];
    var cbcjuniorsec = ['English','Kiswahili','Kenyan Sign Language','Mathematics','Integrated Science','Health Education','Pre-Technical and Pre-Career Education',
                        'Social Studies','Religious Education','Business Studies','Agriculture','Life Skills','Sports and Physical Education','Visual Arts',
                        'Performing Arts','Home Science','Computer Science','German','French','Mandarin','Arabic','Indigenous Languages'
                        ]; 
    
    var cbcartsportpath = ['Legal and Ethical issues in Arts','Communication Skills','Performing Arts','Music','Dance','Theatre and Elocution',
                           'Fine Art','Applied Art','Time Based Media','Crafts','Human Physiology, Anatomy and Nutrition','Sports Ethics','Athletics',
                           'Indoor Games','Gymnastics','Water Sports','Boxing','Martial Arts','Outdoor Pursuits','Advanced Physical Education'
                          ];
                          
    var cbcsocialsciencepath = ['History and Citizenship','Geography','Christian Religious Education','Islamic Religious Education','Hindu Religious Education',
                                'Business Studies','Mathematics','English Language','Literature in English','Lugha ya Kiswahili','Fasihi ya Kiswahili','Kenyan Sign Language',
                                'Indigenous Languages','Arabic','French','German','Mandarin'
                                ];
                                
    var cbcscitechengpath = ['Community Service Learning','Physical Education','ICT','Mathematics','Physics','Chemistry','Biology','Agriculture','Computer Science','Foods and Nutrition',
                             'Home Management','Biological Sciences','Physical Sciences','Agricultural Technology','Geosciences Technology','Marine and Fisheries Technology','Aviation Technology',
                             'Wood Technology','Electrical Technology','Metal Technology','Power Mechanics','Clothing Technology','Construction Technology','Media Technology','Electronics Technology',
                             'Manufacturing Technology','Mechatronic','Garment Making and Interior Design','Leather Work','Culinary Arts','Hair Dressing and Beauty Therapy','Plumbing and Ceramics','Welding and Fabrication',
                             'Tourism and Travel','Air Conditioning and Refrigeration','Animal Keeping','Exterior Design and Landscaping','Building Construction','Photography','Graphic Designing and Animation',
                             'Food and Beverage','Motor Vehicle Mechanics','Carpentry and Joinery','Fire Fighting','Metalwork','Electricity','Land Surveying','Science Laboratory Technology',
                             'Electronics','Printing Technology','Crop Production'
                            ];                             
        
    $('#844secondarysubjects').html();
    for (let i = 0; i < secondary844.length; i++) {
        const element = secondary844[i];
        $('#844secondarysubjects').append('<tr>\
        <td><input value="'+element+'" id="subject5" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    } 
    
    $('#juniorsecondary').html();
    for (let i = 0; i < cbcjuniorsec.length; i++) {
        const element = cbcjuniorsec[i];
        $('#juniorsecondary').append('<tr>\
        <td><input value="'+element+'" id="subject6" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbcartssportpathh').html();
    for (let i = 0; i < cbcartsportpath.length; i++) {
        const element = cbcartsportpath[i];
        $('#cbcartssportpathh').append('<tr>\
        <td><input value="'+element+'" id="subject7" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbcsocialsciencespath').html();
    for (let i = 0; i < cbcsocialsciencepath.length; i++) {
        const element = cbcsocialsciencepath[i];
        $('#cbcsocialsciencespath').append('<tr>\
        <td><input value="'+element+'" id="subject8" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbcsocialsciencespath').html();
    for (let i = 0; i < cbcsocialsciencepath.length; i++) {
        const element = cbcsocialsciencepath[i];
        $('#cbcsocialsciencespath').append('<tr>\
        <td><input value="'+element+'" id="subject9" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }

    $('#cbcscitechengmath').html();
    for (let i = 0; i < cbcscitechengpath.length; i++) {
        const element = cbcscitechengpath[i];
        $('#cbcscitechengmath').append('<tr>\
        <td><input value="'+element+'" id="subject10" type="checkbox" name="subject"></td>\
        <td>'+element+'</td>\
        </tr>');
    }


        $("#subresdiv").addClass('d-none');
        fetchSubjects()

        //select subject for managing
        $('#subjecttomanage').change(function(e){
            e.preventDefault();
            var subject = $('#subjecttomanage').val();
            $('#subject1').val(subject);
            $('#actionbtns').removeClass('d-none')
        })
        //select grading system form
        $('#gradingsystembtn').click(function(e){
            e.preventDefault();
            $('#gradesdiv').removeClass("d-none");
        })

        function fetchSubjects(){
            var sid = "{{ session()->get('schooldetails.id') }}";

            $.ajax({
                method: 'GET',
                url: `/fetchsubjects/${sid}`,
                success: function(response){
                    if (response.subjects.length == 0) {
                        $('#subjecttomanage').append('<option>No subjects Registered yet</option>')
                        $('#subjectstable').append('<h5>No subjects Registered yet. Please make sure to select some subjects from the left to register.</h5>')
                    } else {
                        $('#subjectstable').html('')
                        $.each(response.subjects, function(key,item){
                            $('#subjecttomanage').append('<option value="'+item.id+','+item.subject+'">'+item.subject+'</option>');
                        }) 

                        $.each(response.subjects, function(key,item){
                            //$('#subjectstable').append('<option value="'+item.id+','+item.subject+'">'+item.subject+'</option>');
                            var appenddata = '';

                            appenddata += '<tr>';
                            appenddata += '<td>'+item.subject+'</td>';
                            appenddata += '<td>'+item.educationsystem+'</td>';
                            appenddata += '<td>'+(item.level == null ? "N/A" : item.level)+'</td>';
                            appenddata += '<td>'+(item.pathway == null ? "No Pathway" : item.pathway)+'</td>';
                            appenddata += '<tr>';

                            $('#subjectstable').append(appenddata)
                        })
                        $("#subjectstablebody").DataTable().fnDestroy()

                        $('#subjectstablebody').DataTable({
                        ordering: false,
                        paging: false,
                        searching: true
                         });
                    }

                    if (response.classes.length == 0) {
                        $('#class').append('<option>No any Class Registered yet</option>')
                    } else {
                        $('#class').html('')
                        $.each(response.classes, function(key,item){
                            $('#class').append('<option value="'+item.id+'">'+item.class+' '+item.stream+'</option>');
                        }) 
                        
                    }
                }
            })
        }

      //Register Primary 8-4-4 Subjects
      $('#primary844subjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#primary844subjects')[0]);
          
          var subjects = [];
            $('#subject1:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
                $('.loader').addClass('d-none')
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#primary844subjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 

      //Register Pre primary subjects
      $('#preprimarysubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#preprimarysubjects')[0]);
          
          var subjects = [];
            $('#subject2:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
                $('.loader').addClass('d-none')
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#preprimarysubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 

     //Register Lower primary Subjects
     $('#lowerprimarysubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#lowerprimarysubjects')[0]);
          
          var subjects = [];
            $('#subject3:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
                $('.loader').addClass('d-none')
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#lowerprimarysubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 
      
     //Register Upper primary subjects
     $('#upperprimarysubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#upperprimarysubjects')[0]);
          
          var subjects = [];
            $('#subject4:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none') 
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#upperprimarysubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 
      
      //Register Secondary 8-4-4
      $('#secondary844subjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#secondary844subjects')[0]);
          
          var subjects = [];
            $('#subject5:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
                $('.loader').addClass('d-none')
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#secondary844subjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 

      //Register lower Secondary subjects
      $('#juniorsecondarysubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#juniorsecondarysubjects')[0]);
          
          var subjects = [];
            $('#subject6:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none') 
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#juniorsecondarysubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 
      //Register Upper Secondary arts and social sciences pathway
      $('#artssportsubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#artssportsubjects')[0]);
          
          var subjects = [];
            $('#subject7:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none') 
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#artssportsubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 

      //Register lower Secondary subjects
      $('#socialsciencessubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#socialsciencessubjects')[0]);
          
          var subjects = [];
            $('#subject8:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none') 
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#socialsciencessubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 
      //Register upper secondary social sciences pathway
      $('#scietechsubjects').submit(function(e){
          e.preventDefault();
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#scietechsubjects')[0]);
          
          var subjects = [];
            $('#subject10:checked').each(function(i){
                subjects[i] = $(this).val()
            })  
            formdata.append('subjects', subjects);

          $.ajax({
                method: 'POST',
                url: '{{ route('subject.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
                $('.loader').addClass('d-none')
                   if (res.status == 200) {
                        fetchSubjects();
                       $('#scietechsubjects')[0].reset();
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   }
                    else {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry!some error occured while registering subject.Try again Later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                   }  
               } 
            });
      }) 

      /*Subjects grading start*/
        $('#minA').change(function(e){
           e.preventDefault()
           var value = $(this).val();
            $('#maxA-').val(value-1)
        })
      /*Subjects grading end*/

       //Perform Deletion Operation
       $(document).on('click','#editbtn',function(e){
           e.preventDefault();
           var subval = $(this).attr('sid')
           
           $.ajax({
                method: 'GET',
                url: `/subdetails/${subval}`,
                contentType: false,
                processData: false,
               //dataType: 'json',
               success: function(res){
                //console.log(res)
                $('#subid').val(res.subjectdetails.id)
                $('#subname').val(res.subjectdetails.subject)
                $('#subtoedit').text(res.subjectdetails.subject.toUpperCase())
                $('#editcat').text(res.subjectdetails.category)
                $('#editcat').text(res.subjectdetails.category)
                $('#subinbtn').text(res.subjectdetails.subject.toUpperCase())
                $('#subjecteditmodal').modal('show');
               }
           })
       })

       //Perform Subject Deleting
       $(document).on('click','#delbtn',function(e){
           e.preventDefault();
           var subval = $(this).attr('sid')
           
           var confirm = window.confirm('Are you sure you want to delete this Subject? This may alter other system outputs')
           
            if (confirm) {
                $.ajax({
                method: 'GET',
                url: `/deletesubject/${subval}`,
                contentType: false,
                processData: false,
               //dataType: 'json',
               success: function(res){
                $('#response2').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                fetchSubjects()
               }
            })
            } else {
                
            }
       })

       //Submit Subject Update Form
       $('#subjectupdateform').submit(function(e){
          e.preventDefault();
          $('#subregbtn').val('PLEASE WAIT...')
          var formdata = new FormData($('#subjectupdateform')[0]);
          $.ajax({
                method: 'POST',
                url: '{{ route('subject.update') }}',
                contentType: false,
               processData: false,
               data: formdata,
               success: function(res){
                   if (res.status == 200) {
                        fetchSubjects();
                       //$("#subresdiv").removeClass('d-none');
                       $('#subjectupdateform')[0].reset();
                       $('#response2').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                       $('#subregbtn').val('ADD SUBJECT');
                       $('#subjecteditmodal').modal('hide');
                   } else if(res.status == 400){
                    showError('subname', res.messages.subject);
                    showError('subeditcat', res.messages.category);
                    $('#subregbtn').val('ADD SUBJECT');
                   }
                    else {
                       $('#subregbtn').val('ADD SUBJECT')
                       $('#response2').html('Sorry!some error occured while editing the subject.Try again Later')  
                       
                   }  
               } 
            });
      }) 

    })
</script>
@endsection