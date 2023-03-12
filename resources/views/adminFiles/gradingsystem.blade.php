@extends('layouts.layout')

@section('title','Grading System')

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
@include('adminFiles.topnav')
<div class="loader d-none"></div>
<div class="row p-2">
    <h4 class="text-center w3-red p-2">Grading System</h4>
    <div id="response"></div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <h6 class="text-center text-danger"><b>SUBJECTS GRADING SYSTEM</b></h6>
     <div class="form-group mb-3">
        <label>Select Class</label>
         <select class="form-control" name="class" id="class">
         <option value="">Select Class</option>
          
          <!-- -->
          
          </select>
          <div class="invalid-feedback"></div>
     </div>

     <div class="form-group mb-4">
        <label>Select Subject</label>
        <select name="subject" id="subject" class="form-control">
        <option value="">Select Subject</option>
        
        <!--  -->
        
        </select>
        <div class="invalid-feedback"></div>
    </div>
    
    <div class="row p-1">
              <div class="col-lg-6 col-md-12 col-sm-12 d-grid">
                <button id="addsubjectgrading" class="btn btn-sm w3-indigo rounded-0">ADD GRADING SYSTEM</button>
              </div>

              <div class="col-lg-6 col-md-12 col-sm-12 d-grid">
              <button id="viewsubgradingsystem" class="btn btn-sm w3-green rounded-0">VIEW GRADING SYSTEM</button>
              </div>
          </div>
    <hr>
    
    <h6 class="text-center text-danger"><b>OVERALL GRADING SYSTEM</b></h6>
    <div class="form-group mb-3">
        <label>Select Class</label>
         <select class="form-control" name="class" id="overallclass">
         <option value="">Select Class</option>
          
          <!--  -->
        
          </select>
          <div class="invalid-feedback"></div>
     </div>
     <div class="d-grid pb-2">
     <button id="viewoverallgradsystem" class="btn btn-sm w3-indigo rounded-0">VIEW OVERALL GRADING SYSTEM</button>
     </div>

     <div class="d-grid pb-2">
     <button id="addoverallgradingsystem" class="btn btn-sm w3-green rounded-0">ADD OVERALL GRADING SYSTEM</button>
     </div>
     <hr>
    <hr>
    </div>


    <div class="col-lg-8 col-md-8 col-sm-12">
    <!--Grading div start  -->
    <div id="divgrades" class="p-3 border border-1 border-danger w3-animate-right d-none">
    <div class="table-responsive">
        <table class="table" id="gradestable1" style="background-color: #cccccc">
        <h6 class="text-center"><span class="text-danger" id="gradingtableheading"></span></h6>
            <thead>
                <tr>
                    <th scope="col">Grade</th>
                    <th scope="col">A</th>
                    <th scope="col">A-</th>
                    <th scope="col">B+</th>
                    <th scope="col">B</th>
                    <th scope="col">B-</th>
                    <th scope="col">C+</th>
                    <th scope="col">C</th>
                    <th scope="col">C-</th>
                    <th scope="col">D+</th>
                    <th scope="col">D</th>
                    <th scope="col">D-</th>
                    <th scope="col">E</th>
                </tr>
            </thead>
            <tbody id="gradestable3">

            </tbody>
        </table>
        <div class="d-grid">
        <button id="gradingsytemupdate" class="btn btn-sm rounded-0 w3-teal">UPDATE GRADING SYSTEM</button>
        </div>
    </div>
    </div>
    <!--Grading div End  -->


    <div id="gradesdiv" class="p-2 mt-2 border border-2 border-info d-none w3-animate-right">
    <form action="#" class="p-2" method="POST" id="GradeForm">
<h6 class="text-center text-danger p-1 bg-info d-none" id="graderegdiv"></h6>  
<div class="">
<h6 class="text-center text-success">Grading System</h6>
<input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
     <div class="border border-success">
    <div class="form-group mb-2 d-none">
        <label for="">SUBJECT</label>
        <input readonly value="" class="form-control" type="text" name="subject" id="subject1">
        <div class="invalid-feedback"></div>
    </div>

    <!-- <div class="form-group mb-2">
        <label for="">Class</label>
        <input type="number" class="form-control" name="classid" id="classid">
    <div class="invalid-feedback"></div>
    </div> -->
    </div> 

    <div class="border border-danger p-2">
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
                    <input value="12" readonly class="form-control" type="number" name="pointsA" id="pointsA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="A" readonly class="form-control" type="text" name="gradeA" id="gradeA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA" id="RemarksA">
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
                    <input value="11" readonly class="form-control" type="number" name="pointsA_minus" id="pointsA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="A-" readonly class="form-control" type="text" name="gradeA_minus" id="gradeA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA_minus" id="RemarksA_minus">
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
                    <input value="10" readonly class="form-control" type="number" name="pointsB_plus" id="pointsB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B+" readonly class="form-control" type="text" name="gradeB_plus" id="gradeB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB_plus" id="RemarksB_plus">
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
                    <input value="9" readonly class="form-control" type="number" name="pointsB" id="pointsB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B" readonly class="form-control" type="text" name="gradeB" id="gradeB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB" id="RemarksB">
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
                    <input value="8" readonly class="form-control" type="number" name="pointsB_minus" id="pointsB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B-" readonly class="form-control" type="text" name="gradeB_minus" id="gradeB_minus">
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
                    <input value="7" readonly class="form-control" type="number" name="pointsC_plus" id="pointsC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C+" readonly class="form-control" type="text" name="gradeC_plus" id="gradeC_plus">
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
                    <input value="6" readonly class="form-control" type="number" name="pointsC" id="pointsC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C" readonly class="form-control" type="text" name="gradeC" id="gradeC">
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
                    <input value="5" readonly class="form-control" type="number" name="pointsC_minus" id="pointsC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C-" readonly class="form-control" type="text" name="gradeC_minus" id="gradeC_minus">
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
                    <input value="4" readonly class="form-control" type="number" name="pointsD_plus" id="pointsD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D+" readonly class="form-control" type="text" name="gradeD_plus" id="gradeD_plus">
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
                    <input value="3" readonly class="form-control" type="number" name="pointsD" id="pointsD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D" readonly class="form-control" type="text" name="gradeD" id="gradeD">
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
                    <input value="2" readonly class="form-control" type="number" name="pointsD_minus" id="pointsD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D-" readonly class="form-control" type="text" name="gradeD_minus" id="gradeD_minus">
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
                    <input value="1" readonly class="form-control" type="number" name="pointsE" id="pointsE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="E" readonly class="form-control" type="text" name="gradeE" id="gradeE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksE" id="RemarksE">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    </div>
    </div>

    <div class="form-group d-grid">
        <input class="btn btn-info btn-sm rounded-0" type="submit" value="ADD GRADING SYSTEM">
    </div>
</form>
</div>

    <!--UPDATE GRADING SYTEM START-->
    <div id="updategradesdiv" class="p-2 mt-2 border border-2 border-info d-none w3-animate-bottom">
    <form action="#" class="p-2" method="POST" id="GradeUpdateForm">
<h6 class="text-center text-danger p-1 bg-info d-none" id="graderegdiv"></h6>  
<div class="">
<!-- <h6 class="text-center text-success">Grading System</h6> -->
     <div class="border border-success">
    <!-- <div class="form-group mb-2 d-none">
        <label for="">SUBJECT</label>
        <input readonly value="" class="form-control" type="text" name="subject" id="subject1">
        <div class="invalid-feedback"></div>
    </div>  -->

     <!-- <div class="form-group mb-2">
        <label for="">Class</label>
        <input type="number" class="form-control" name="classid" id="classid">
    <div class="invalid-feedback"></div>
     </div> 
    </div>  -->
    <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
    <div class="border border-danger p-2">
    <div id="gradestable" class="table-responsive">
    <table class="table w3-grey">
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
                    <input class="form-control" type="number" name="minA" id="upminA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="99" class="form-control" type="number" name="maxA" id="upmaxA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="12" readonly class="form-control" type="number" name="pointsA" id="uppointsA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="A" readonly class="form-control" type="text" name="gradeA" id="upgradeA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA" id="upRemarksA">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minA_minus" id="upminA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxA_minus" id="upmaxA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="11" readonly class="form-control" type="number" name="pointsA_minus" id="uppointsA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="A-" readonly class="form-control" type="text" name="gradeA_minus" id="upgradeA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA_minus" id="upRemarksA_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_plus" id="upminB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_plus" id="upmaxB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="10" readonly class="form-control" type="number" name="pointsB_plus" id="uppointsB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B+" readonly class="form-control" type="text" name="gradeB_plus" id="upgradeB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB_plus" id="upRemarksB_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB" id="upminB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB" id="upmaxB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="9" readonly class="form-control" type="number" name="pointsB" id="uppointsB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B" readonly class="form-control" type="text" name="gradeB" id="upgradeB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB" id="upRemarksB">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_minus" id="upminB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_minus" id="upmaxB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="8" readonly class="form-control" type="number" name="pointsB_minus" id="uppointsB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="B-" readonly class="form-control" type="text" name="gradeB_minus" id="upgradeB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksB_minus" id="upRemarksB_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_plus" id="upminC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_plus" id="upmaxC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="7" readonly class="form-control" type="number" name="pointsC_plus" id="uppointsC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C+" readonly class="form-control" type="text" name="gradeC_plus" id="upgradeC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_plus" id="upRemarksC_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC" id="upminC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC" id="upmaxC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="6" readonly class="form-control" type="number" name="pointsC" id="uppointsC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C" readonly class="form-control" type="text" name="gradeC" id="upgradeC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC" id="upRemarksC">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_minus" id="upminC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_minus" id="upmaxC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="5" readonly class="form-control" type="number" name="pointsC_minus" id="uppointsC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="C-" readonly class="form-control" type="text" name="gradeC_minus" id="upgradeC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_minus" id="upRemarksC_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_plus" id="upminD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_plus" id="upmaxD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="4" readonly class="form-control" type="number" name="pointsD_plus" id="uppointsD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D+" readonly class="form-control" type="text" name="gradeD_plus" id="upgradeD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_plus" id="upRemarksD_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD" id="upminD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD" id="upmaxD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="3" readonly class="form-control" type="number" name="pointsD" id="uppointsD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D" readonly class="form-control" type="text" name="gradeD" id="upgradeD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD" id="upRemarksD">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_minus" id="upminD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_minus" id="upmaxD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="2" readonly class="form-control" type="number" name="pointsD_minus" id="uppointsD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="D-" readonly class="form-control" type="text" name="gradeD_minus" id="upgradeD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_minus" id="upRemarksD_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minE" id="upminE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxE" id="upmaxE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="1" readonly class="form-control" type="number" name="pointsE" id="uppointsE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="E" readonly class="form-control" type="text" name="gradeE" id="upgradeE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksE" id="upRemarksE">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    </div>
    </div>

    <div class="form-group d-grid">
        <input class="btn w3-teal btn-sm rounded-0" type="submit" value="UPDATE GRADING SYSTEM">
    </div>
</form>
</div>
<!--UPDATE GRADING SYSTEM END  -->
</div>

    <!-- Overall Grading System -->
    <div id="overallgradingsytemform" class="p-2 mt-2 border border-2 border-info d-none w3-animate-bottom">
 <form action="#" class="p-2" method="POST" id="OverGradingForm">
     <h6 class="text-center w3-indigo p-2">OVERALL GRADING SYSTEM</h6>
<h6 class="text-center text-danger p-1 bg-info d-none" id="graderegdiv"></h6> 
<input hidden type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid"> 
<div class="">
     <div class="border border-success">
    
     <div class="form-group p-2">
         <label class="text-danger"><b>What would you use for setting grading system?</b></label>
         <select name="gradingtype" id="gradingtype" class="form-control">
            <option value="">Select what grading is to be based on</option>
            <option value="Marks">Marks</option>
            <option value="Points">Points</option>
         </select>
         <div class="invalid-feedback"></div>
     </div>

    <div class="border border-danger p-2">
    <div id="gradestable" class="table-responsive">
    <table class="table">
            <thead>
            <tr>
                <th scope="col">MIN <span class="text-danger" id="typeth"></span></th>
                <th scope="col">MAX <span class="text-danger" id="typeth1"></span></th>
                <th scope="col">GRADE</th>
                <th scope="col">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input class="form-control" type="number" name="minA" id="ovminA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="number" name="maxA" id="ovmaxA">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="12" readonly class="form-control" type="number" name="pointsA" id="uppointsA">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="A" readonly class="form-control" type="text" name="gradeA" id="ovgradeA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA" id="ovRemarksA">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minA_minus" id="ovminA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxA_minus" id="ovmaxA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="11" readonly class="form-control" type="number" name="pointsA_minus" id="uppointsA_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="A-" readonly class="form-control" type="text" name="gradeA_minus" id="ovgradeA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA_minus" id="ovRemarksA_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_plus" id="ovminB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_plus" id="ovmaxB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="10" readonly class="form-control" type="number" name="pointsB_plus" id="uppointsB_plus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="B+" readonly class="form-control" type="text" name="gradeB_plus" id="ovgradeB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB_plus" id="ovRemarksB_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB" id="ovminB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB" id="ovmaxB">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="9" readonly class="form-control" type="number" name="pointsB" id="uppointsB">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="B" readonly class="form-control" type="text" name="gradeB" id="ovgradeB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB" id="ovRemarksB">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_minus" id="ovminB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_minus" id="ovmaxB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="8" readonly class="form-control" type="number" name="pointsB_minus" id="uppointsB_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="B-" readonly class="form-control" type="text" name="gradeB_minus" id="ovgradeB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksB_minus" id="ovRemarksB_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_plus" id="ovminC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_plus" id="ovmaxC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="7" readonly class="form-control" type="number" name="pointsC_plus" id="uppointsC_plus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="C+" readonly class="form-control" type="text" name="gradeC_plus" id="ovgradeC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_plus" id="ovRemarksC_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC" id="ovminC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC" id="ovmaxC">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="6" readonly class="form-control" type="number" name="pointsC" id="uppointsC">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="C" readonly class="form-control" type="text" name="gradeC" id="ovgradeC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC" id="ovRemarksC">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_minus" id="ovminC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_minus" id="ovmaxC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="5" readonly class="form-control" type="number" name="pointsC_minus" id="uppointsC_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="C-" readonly class="form-control" type="text" name="gradeC_minus" id="ovgradeC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_minus" id="ovRemarksC_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_plus" id="ovminD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_plus" id="ovmaxD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="4" readonly class="form-control" type="number" name="pointsD_plus" id="uppointsD_plus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="D+" readonly class="form-control" type="text" name="gradeD_plus" id="ovgradeD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_plus" id="ovRemarksD_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD" id="ovminD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD" id="ovmaxD">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="3" readonly class="form-control" type="number" name="pointsD" id="uppointsD">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="D" readonly class="form-control" type="text" name="gradeD" id="ovgradeD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD" id="ovRemarksD">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_minus" id="ovminD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_minus" id="ovmaxD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="2" readonly class="form-control" type="number" name="pointsD_minus" id="uppointsD_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="D-" readonly class="form-control" type="text" name="gradeD_minus" id="ovgradeD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_minus" id="ovRemarksD_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minE" id="ovminE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxE" id="ovmaxE">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="1" readonly class="form-control" type="number" name="pointsE" id="uppointsE">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="E" readonly class="form-control" type="text" name="gradeE" id="ovgradeE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksE" id="ovRemarksE">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    </div>
    </div>

    <div class="form-group d-grid">
        <input class="btn w3-teal btn-sm rounded-0" type="submit" value="ADD OVERALL GRADING SYSTEM">
    </div>
</form>
 </div>
    <!-- Overall Grading System End -->

</div>
 
<!--  -->
<div id="overalldivgrades" class="p-3 border border-1 border-danger w3-animate-top d-none">
    <div class="table-responsive">
        <table class="table" id="gradestable1" style="background-color: #cccccc">
        <h6 class="text-center">Overall Grading System for <span class="text-danger" id="overrallgradingheading"></span></h6>
            <thead>
                <tr>
                    <th scope="col">Grade</th>
                    <th scope="col">A</th>
                    <th scope="col">A-</th>
                    <th scope="col">B+</th>
                    <th scope="col">B</th>
                    <th scope="col">B-</th>
                    <th scope="col">C+</th>
                    <th scope="col">C</th>
                    <th scope="col">C-</th>
                    <th scope="col">D+</th>
                    <th scope="col">D</th>
                    <th scope="col">D-</th>
                    <th scope="col">E</th>
                </tr>
            </thead>
            <tbody id="gradestable4">

            </tbody>
        </table>
        <div class="d-grid">
        <button id="overallgradingsytemupdatebtn" class="btn btn-sm rounded-0 w3-teal">UPDATE GRADING SYSTEM</button>
        </div>
    </div>
    </div>
<!--  -->

<!-- Overall grading system update form start -->
<div id="overallgradingsytemupdateform" class="p-2 mt-2 border border-2 border-info d-none w3-animate-bottom">
 <form action="#" class="p-2" method="POST" id="OverGradingFormUpdate">
     <h6 class="text-center w3-purple p-2">OVERALL GRADING SYSTEM UPDATE <span id="classup"></span></h6>
<h6 class="text-center text-danger p-1 bg-info d-none" id="graderegdiv"></h6>  
<input hidden type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid">
<div class="">
     <div class="border border-success">
    
     <div class="form-group p-2">
         <label class="text-danger"><b>What would you use for setting grading system?</b></label>
         <select name="gradingtype" id="gradingtype2" class="form-control">
            <option id="updategradingtype"></option>
            <option value="Marks">Marks</option>
            <option value="Points">Points</option>
         </select>
         <div class="invalid-feedback"></div>
     </div>

    <div class="border border-danger p-2">
    <div id="gradestable" class="table-responsive">
    <table class="table w3-grey">
            <thead>
            <tr>
                <th scope="col">MIN <span class="text-danger" id="uptypeth"></span></th>
                <th scope="col">MAX <span class="text-danger" id="uptypeth1"></span></th>
                <th scope="col">GRADE</th>
                <th scope="col">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input class="form-control" type="number" name="minA" id="upovminA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="number" name="maxA" id="upovmaxA">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="12" readonly class="form-control" type="number" name="pointsA" id="uppointsA">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="A" readonly class="form-control" type="text" name="gradeA" id="upovgradeA">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA" id="upovRemarksA">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minA_minus" id="upovminA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxA_minus" id="upovmaxA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="11" readonly class="form-control" type="number" name="pointsA_minus" id="uppointsA_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="A-" readonly class="form-control" type="text" name="gradeA_minus" id="upovgradeA_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksA_minus" id="upovRemarksA_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_plus" id="upovminB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_plus" id="upovmaxB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="10" readonly class="form-control" type="number" name="pointsB_plus" id="uppointsB_plus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="B+" readonly class="form-control" type="text" name="gradeB_plus" id="upovgradeB_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB_plus" id="upovRemarksB_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB" id="upovminB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB" id="upovmaxB">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="9" readonly class="form-control" type="number" name="pointsB" id="uppointsB">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="B" readonly class="form-control" type="text" name="gradeB" id="upovgradeB">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksB" id="upovRemarksB">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minB_minus" id="upovminB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxB_minus" id="upovmaxB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="8" readonly class="form-control" type="number" name="pointsB_minus" id="uppointsB_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="B-" readonly class="form-control" type="text" name="gradeB_minus" id="upovgradeB_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksB_minus" id="upovRemarksB_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_plus" id="upovminC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_plus" id="upovmaxC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="7" readonly class="form-control" type="number" name="pointsC_plus" id="uppointsC_plus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="C+" readonly class="form-control" type="text" name="gradeC_plus" id="upovgradeC_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_plus" id="upovRemarksC_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC" id="upovminC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC" id="upovmaxC">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="6" readonly class="form-control" type="number" name="pointsC" id="uppointsC">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="C" readonly class="form-control" type="text" name="gradeC" id="upovgradeC">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC" id="upovRemarksC">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minC_minus" id="upovminC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxC_minus" id="upovmaxC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="5" readonly class="form-control" type="number" name="pointsC_minus" id="uppointsC_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="C-" readonly class="form-control" type="text" name="gradeC_minus" id="upovgradeC_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksC_minus" id="upovRemarksC_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_plus" id="upovminD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_plus" id="upovmaxD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="4" readonly class="form-control" type="number" name="pointsD_plus" id="uppointsD_plus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="D+" readonly class="form-control" type="text" name="gradeD_plus" id="upovgradeD_plus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_plus" id="upovRemarksD_plus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD" id="upovminD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD" id="upovmaxD">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="3" readonly class="form-control" type="number" name="pointsD" id="uppointsD">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="D" readonly class="form-control" type="text" name="gradeD" id="upovgradeD">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD" id="upovRemarksD">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minD_minus" id="upovminD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxD_minus" id="upovmaxD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="2" readonly class="form-control" type="number" name="pointsD_minus" id="uppointsD_minus">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="D-" readonly class="form-control" type="text" name="gradeD_minus" id="upovgradeD_minus">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="RemarksD_minus" id="upovRemarksD_minus">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control" type="number" name="minE" id="upovminE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input class="form-control" type="number" name="maxE" id="upovmaxE">
                    <div class="invalid-feedback"></div>
                </td>
                <!-- <td>
                    <input value="1" readonly class="form-control" type="number" name="pointsE" id="uppointsE">
                    <div class="invalid-feedback"></div>
                </td> -->
                <td>
                    <input value="E" readonly class="form-control" type="text" name="gradeE" id="upovgradeE">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input value="" class="form-control" type="text" name="RemarksE" id="upovRemarksE">
                    <div class="invalid-feedback"></div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    </div>
    </div>

    <div class="form-group d-grid">
        <input class="btn w3-teal btn-sm rounded-0" type="submit" value="UPDATE OVERALL GRADING SYSTEM">
    </div>
</form>
 </div>
<!-- Overall grading system update form end -->

</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        fetchclasses();
        fetchsubjects();
        overallgradeclasses();

        $('#gradingtype').change(function(){
            var gtype = $(this).val().toUpperCase();
            $('#typeth1').text(gtype)
            $('#typeth').text(gtype)
        })

        $('#addsubjectgrading').click(function(e){
            $('#class').removeClass('is-invalid')
            $('#subject').removeClass('is-invalid')
            $('#divgrades').addClass('d-none')
            $('#updategradesdiv').addClass('d-none')
            $('#overallgradingsytemform').addClass('d-none')
            $('#overalldivgrades').addClass('d-none')
            $('#overallgradingsytemupdateform').addClass('d-none');
            e.preventDefault();
            var clasval = $('#class').val();
            var subval = $('#subject').val();

            if (clasval == '') {
                showError('class','You must select a Class')
            } 
            
            if (subval == '') {
                showError('subject','You must select a Subject')
                $('#subject1').val(subval);
            } else {
                $('#gradesdiv').removeClass('d-none')
            }
        })

        //Handle overall grading system Update
        $('#overallgradingsytemupdatebtn').click(function(e){
            $('#class').removeClass('is-invalid')
            $('#subject').removeClass('is-invalid')
            $('#divgrades').addClass('d-none')
            $('#updategradesdiv').addClass('d-none')
            $('#overallgradingsytemform').addClass('d-none')
            $('#overalldivgrades').addClass('d-none')
            e.preventDefault();
            var clasval = $('#class').val();
            var subval = $('#subject').val();

            $('#overallgradingsytemupdateform').removeClass('d-none');
        })

        //Function to fetch classes
        function fetchclasses(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "8-4-4";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses2/${sid}/${etype}`,
                success: function(res){
                    //console.log(res)
                    if (res.classes.length == 0) {
                        $('#class').text('Sorry!There are no classes added recently')
                    } else {
                        $('#class').html('');
                        $('#class').append('<option value="">Select Class</option>');
                        $('#class').append('<option value="FORM ONE">FORM ONE</option>');
                        $('#class').append('<option value="FORM TWO">FORM TWO</option>');
                        $('#class').append('<option value="FORM THREE">FORM THREE</option>');
                        $('#class').append('<option value="FORM FOUR">FORM FOUR</option>');
                        // $.each(res.classes, function(key,item){
                        //     $('#class').append('<option value="'+item.id+'">'+item.class+' '+item.stream+'</option>')
                        // })
                    }
                }
            });
        }

        //Function to fetch subjects for overall grading
        function overallgradeclasses(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "8-4-4";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses2/${sid}/${etype}`,
                success: function(res){
                    //console.log(res)
                    if (res.classes.length == 0) {
                        $('#overallclass').text('Sorry!There are no classes added recently')
                    } else {
                        $('#overallclass').html('');
                        $('#overallclass').append('<option value="">Select Class</option>');
                        $('#overallclass').append('<option value="FORM ONE">FORM ONE</option>');
                        $('#overallclass').append('<option value="FORM TWO">FORM TWO</option>');
                        $('#overallclass').append('<option value="FORM THREE">FORM THREE</option>');
                        $('#overallclass').append('<option value="FORM FOUR">FORM FOUR</option>');
                        // $.each(res.classes, function(key,item){
                        //     $('#overallclass').append('<option value="'+item.id+'">'+item.class+' '+item.stream+'</option>')
                        // })
                    }
                }
            });
        }

        //Function to fetch subjects
        function fetchsubjects(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "8-4-4";
            $.ajax({
                method: 'GET',
                url: `/fetchsubjects2/${sid}/${etype}`,
                success: function(response){
                    if (response.subjects.length == 0) {
                        $('#subject').append('<option>No subjects Registered yet</option>')
                    } else {
                        $('#subject').html('')
                        $('#subject').append('<option value="">Select Subject</option>')
                        $.each(response.subjects, function(key,item){
                            $('#subject').append('<option value="'+item.id+','+item.subject+'">'+item.subject+'</option>');
                        }) 
                    }
                }
            })
        }

        //Handle grading system Update
        $('#gradingsytemupdate').click(function(e){
            var sid = "{{ session()->get('schooldetails.id') }}";
            e.preventDefault();
            var clasval = $('#class').val();
            var subval = $('#subject').val();
            $('#divgrades').addClass('d-none')
            $('#gradesdiv').addClass('d-none')
            $('#updategradesdiv').removeClass('d-none')
            $('#overallgradingsytemform').addClass('d-none')
            $('#overalldivgrades').addClass('d-none')
            $('#overallgradingsytemupdateform').addClass('d-none');

            $.ajax({
                method: 'GET',
                url: `/fetchsubgrades/${sid}/${clasval.split(',')[0]}/${subval.split(',')[1]}`,
                contentType: false,
                processData: false,
               //dataType: 'json',
               success: function(res){
                //console.log(res.grades)
                $.each(res.grades, function(key,item){
                   $('#upminA').val(item.minA)
                   $('#upminA_minus').val(item.minA_minus)
                   $('#upminB_plus').val(item.minB_plus)
                   $('#upminB').val(item.minB)
                   $('#upminB_minus').val(item.minB_minus)
                   $('#upminC_plus').val(item.minC_plus)
                   $('#upminC').val(item.minC)
                   $('#upminC_minus').val(item.minC_minus)
                   $('#upminD_plus').val(item.minD_plus)
                   $('#upminD').val(item.minD)
                   $('#upminD_minus').val(item.minD_minus)
                   $('#upminE').val(item.minE)
                   $('#upmaxA').val(item.maxA) 
                   $('#upmaxA_minus').val(item.maxA_minus)
                   $('#upmaxB_plus').val(item.maxB_plus)
                   $('#upmaxB').val(item.maxB)
                   $('#upmaxB_minus').val(item.maxB_minus)
                   $('#upmaxC_plus').val(item.maxC_plus)
                   $('#upmaxC').val(item.maxC)
                   $('#upmaxC_minus').val(item.maxC_minus)
                   $('#upmaxD_plus').val(item.maxD_plus)
                   $('#upmaxD').val(item.maxD)
                   $('#upmaxD_minus').val(item.maxD_minus)
                   $('#upmaxE').val(item.maxE)
                   $('#upRemarksA').val(item.RemarksA)
                   $('#upRemarksA_minus').val(item.RemarksA_minus)
                   $('#upRemarksB_plus').val(item.RemarksB_plus)
                   $('#upRemarksB').val(item.RemarksB)
                   $('#upRemarksB_minus').val(item.RemarksB_minus)
                   $('#upRemarksC_plus').val(item.RemarksC_plus)
                   $('#upRemarksC').val(item.RemarksC)
                   $('#upRemarksC_minus').val(item.RemarksC_minus)
                   $('#upRemarksD_plus').val(item.RemarksD_plus)
                   $('#upRemarksD').val(item.RemarksD)
                   $('#upRemarksD_minus').val(item.RemarksD_minus)
                   $('#upRemarksE').val(item.RemarksE)
                })
               }
                })
            })
        //Submit Update Form
        $('#GradeUpdateForm').submit(function(e){
            $('.loader').removeClass('d-none');
            e.preventDefault()
            var formdata = new FormData($(this)[0]);
            formdata.append('class',$('#class').val());
            formdata.append('subject',$('#subject').val())

            $.ajax({
                method: 'POST',
                url: '{{ route('grade.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none');
                //console.log(res)
                  if (res.status == 400) {
                    showError('subject1', res.messages.subject);
                    showError('class', res.messages.class);
                    showError('upmaxA', res.messages.maxA);
                    showError('upminA', res.messages.minA);
                    showError('upgradeA', res.messages.gradeA);
                    showError('uppointsA', res.messages.pointsA);
                    showError('upRemarksA', res.messages.RemarksA);
                    showError('upminA_minus', res.messages.minA_minus);
                    showError('upmaxA_minus', res.messages.maxA_minus);
                    showError('uppointsA_minus', res.messages.pointsA_minus);
                    showError('upgradeA_minus', res.messages.gradeA_minus);
                    showError('upRemarksA_minus', res.messages.RemarksA_minus);
                    showError('upmaxB_plus', res.messages.maxB_plus);
                    showError('upminB_plus', res.messages.minB_plus);
                    showError('upgradeB_plus', res.messages.gradeB_plus);
                    showError('uppointsB_plus', res.messages.pointsB_plus);
                    showError('upRemarksB_plus', res.messages.RemarksB_plus);
                    showError('upmaxB', res.messages.maxB);
                    showError('upminB', res.messages.minB);
                    showError('upgradeB', res.messages.gradeB);
                    showError('uppointsB', res.messages.pointsB);
                    showError('upRemarksB', res.messages.RemarksB);
                    showError('upminB_minus', res.messages.minB_minus);
                    showError('upmaxB_minus', res.messages.maxB_minus);
                    showError('uppointsB_minus', res.messages.pointsB_minus);
                    showError('upgradeB_minus', res.messages.gradeB_minus);
                    showError('upRemarksB_minus', res.messages.RemarksB_minus);
                    showError('upmaxC_plus', res.messages.maxC_plus);
                    showError('upminC_plus', res.messages.minC_plus);
                    showError('upgradeC_plus', res.messages.gradeC_plus);
                    showError('uppointsC_plus', res.messages.pointsC_plus);
                    showError('upRemarksC_plus', res.messages.RemarksC_plus);
                    showError('upmaxC', res.messages.maxC);
                    showError('upminC', res.messages.minC);
                    showError('upgradeC', res.messages.gradeC);
                    showError('uppointsC', res.messages.pointsC);
                    showError('upRemarksC', res.messages.RemarksC);
                    showError('upminC_minus', res.messages.minC_minus);
                    showError('upmaxC_minus', res.messages.maxC_minus);
                    showError('uppointsC_minus', res.messages.pointsC_minus);
                    showError('upgradeC_minus', res.messages.gradeC_minus);
                    showError('upRemarksC_minus', res.messages.RemarksC_minus);
                    showError('upmaxD_plus', res.messages.maxD_plus);
                    showError('upminD_plus', res.messages.minD_plus);
                    showError('upgradeD_plus', res.messages.gradeD_plus);
                    showError('uppointsD_plus', res.messages.pointsD_plus);
                    showError('upRemarksD_plus', res.messages.RemarksD_plus);
                    showError('upmaxD', res.messages.maxD);
                    showError('upminD', res.messages.minD);
                    showError('upgradeD', res.messages.gradeD);
                    showError('uppointsD', res.messages.pointsD);
                    showError('upRemarksD', res.messages.RemarksD);
                    showError('upminD_minus', res.messages.minD_minus);
                    showError('upmaxD_minus', res.messages.maxD_minus);
                    showError('uppointsD_minus', res.messages.pointsD_minus);
                    showError('upgradeD_minus', res.messages.gradeD_minus);
                    showError('upRemarksD_minus', res.messages.RemarksD_minus);
                    showError('upmaxE', res.messages.maxE);
                    showError('upminE', res.messages.minE);
                    showError('upgradeE', res.messages.gradeE);
                    showError('uppointsE', res.messages.pointsE);
                    showError('upRemarksE', res.messages.RemarksE);
                  } else if(res.status == 200){
                      $('#graderegdiv').removeClass('d-none');
                      $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                      //$('#graderegdiv').text(res.messages);
                      $('#GradeUpdateForm')[0].reset();
                  } 
               }
            })
        })

    //Handle subject grade viewing
        $('#viewsubgradingsystem').click(function(e){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $('#overallgradingsytemform').addClass('d-none')
            $('#updategradesdiv').addClass('d-none')
            $('#class').removeClass('is-invalid')
            $('#subject').removeClass('is-invalid')
            $('#gradesdiv').addClass('d-none')
            $('#overalldivgrades').addClass('d-none')
            $('#overallgradingsytemupdateform').addClass('d-none');
            $('#gradingtableheading').text('')
            e.preventDefault();
            var clasval = $('#class').val();
            var subval = $('#subject').val();
            
            if (clasval == '') {
                showError('class','You must select a Class')
            } 
            
            if (subval == '') {
                showError('subject','You must select a Subject')
                
            } else {
                $('#divgrades').removeClass('d-none')
                $('.loader').removeClass('d-none');
                $.ajax({
                method: 'GET',
                url: `/fetchsubgrades/${sid}/${clasval.split(',')[0]}/${subval.split(',')[1]}`,
                contentType: false,
                processData: false,
               //dataType: 'json',
               success: function(res){
                //console.log(res)
                $('.loader').addClass('d-none');
                $('#gradingtableheading').text(`${res.class} ${res.subject} Grading System`)
                $('#gradestable3').html('')
                if (res.grades.length == 0) {
                    $('#gradestable3').append('<h6 class="text-center text-danger">Grading System Not Yet Set. Please make sure you set it.</h6>')
                    $('#gradingsytemupdate').addClass('d-none');
                } else {
                    $('#gradingsytemupdate').removeClass('d-none');
                    $.each(res.grades,function(key,item3){
                    $('#gradestable3').html('')
                    var appenddata = '';
                    /**Points */
                    appenddata += '<tr>';
                    appenddata += '<td style="font-weight: bolder">Points</td>';
                    appenddata += '<td>12</td>';
                    appenddata += '<td>11</td>';
                    appenddata += '<td>10</td>';
                    appenddata += '<td>9</td>';
                    appenddata += '<td>8</td>';
                    appenddata += '<td>7</td>';
                    appenddata += '<td>6</td>';
                    appenddata += '<td>5</td>';
                    appenddata += '<td>4</td>';
                    appenddata += '<td>3</td>';
                    appenddata += '<td>2</td>';
                    appenddata += '<td>1</td>';
                    appenddata += '<tr>';
                    /**Points */

                    /**Deal with Marks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder">Marks Range</td>';
                     appenddata += '<td>'+item3.minA+' - '+item3.maxA+'</td>';
                     appenddata += '<td>'+item3.minA_minus+' - '+item3.maxA_minus+'</td>';
                     appenddata += '<td>'+item3.minB_plus+' - '+item3.maxB_plus+'</td>';
                     appenddata += '<td>'+item3.minB+' - '+item3.maxB+'</td>';
                     appenddata += '<td>'+item3.minB_minus+' - '+item3.maxB_minus+'</td>';
                     appenddata += '<td>'+item3.minC_plus+' - '+item3.maxC_plus+'</td>';
                     appenddata += '<td>'+item3.minC+' - '+item3.maxC+'</td>';
                     appenddata += '<td>'+item3.minC_minus+' - '+item3.maxC_minus+'</td>';
                     appenddata += '<td>'+item3.minD_plus+' - '+item3.maxD_plus+'</td>';
                     appenddata += '<td>'+item3.minD+' - '+item3.maxD+'</td>';
                     appenddata += '<td>'+item3.minD_minus+' - '+item3.maxD_minus+'</td>';
                     appenddata += '<td>'+item3.minE+' - '+item3.maxE+'</td>';
                     //appenddata += '<td>'+item3.min+' - '+item3.max+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Marks End*/

                     /**Deal with Remarks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder">Remarks</td>';
                     appenddata += '<td>'+item3.RemarksA+'</td>';
                     appenddata += '<td>'+item3.RemarksA_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksB_plus+'</td>';
                     appenddata += '<td>'+item3.RemarksB+'</td>';
                     appenddata += '<td>'+item3.RemarksB_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksC_plus+'</td>';
                     appenddata += '<td>'+item3.RemarksC+'</td>';
                     appenddata += '<td>'+item3.RemarksC_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksD_plus+'</td>';
                     appenddata += '<td>'+item3.RemarksD+'</td>';
                     appenddata += '<td>'+item3.RemarksD_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksE+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Remarks End*/
                     $('#gradestable3').append(appenddata)
                 })
                }
               }
                });
            }
        })

        $('#viewoverallgradsystem').click(function(e){
            e.preventDefault();
            //$('.loader').removeClass('d-none');
            $('#gradesdiv').addClass('d-none')
            $('#updategradesdiv').addClass('d-none')
            $('#divgrades').addClass('d-none')
            $('#overallgradingsytemform').addClass('d-none')
            $('#overallgradingsytemupdateform').addClass('d-none');
            

            var classval = $('#overallclass').val();
            var sid = "{{ session()->get('schooldetails.id') }}";

            if (classval == '') {
                showError('overallclass','You must select a class');
            } else {
                $('#overalldivgrades').removeClass('d-none')
                $.ajax({
                method: 'GET',
                url: `/fetchOverallgrading/${sid}/${classval}`,
                contentType: false,
                processData: false,
               //dataType: 'json',
               success: function(res){
                //console.log(res)
                $('.loader').addClass('d-none');
                $('#gradestable4').html('')
                $('#overrallgradingheading').text(`${res.class}`)
                if (res.grades.length == 0) {
                    $('#gradestable4').append('<h6 class="text-center text-danger">Overall Grading System '+res.class+' Not Yet Set. Please make sure you set it.</h6>')
                    $('#overallgradingsytemupdatebtn').addClass('d-none')
                } else {
                    $('#overallgradingsytemupdatebtn').removeClass('d-none')
                    $.each(res.grades,function(key,item3){
                    $('#updategradingtype').val(item3.consideration)
                    $('#updategradingtype').text(item3.consideration)
                    $('#uptypeth').text(item3.consideration.toUpperCase())
                    $('#uptypeth1').text(item3.consideration.toUpperCase())
                    $('#classup').text(res.class)
                    $('#gradestable4').html('')
                    var appenddata = '';
                    /**Deal with Marks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder"><span id="gradingide">'+item3.consideration+' Range</td>';
                     appenddata += '<td>'+item3.minA+' - '+item3.maxA+'</td>';
                     appenddata += '<td>'+item3.minA_minus+' - '+item3.maxA_minus+'</td>';
                     appenddata += '<td>'+item3.minB_plus+' - '+item3.maxB_plus+'</td>';
                     appenddata += '<td>'+item3.minB+' - '+item3.maxB+'</td>';
                     appenddata += '<td>'+item3.minB_minus+' - '+item3.maxB_minus+'</td>';
                     appenddata += '<td>'+item3.minC_plus+' - '+item3.maxC_plus+'</td>';
                     appenddata += '<td>'+item3.minC+' - '+item3.maxC+'</td>';
                     appenddata += '<td>'+item3.minC_minus+' - '+item3.maxC_minus+'</td>';
                     appenddata += '<td>'+item3.minD_plus+' - '+item3.maxD_plus+'</td>';
                     appenddata += '<td>'+item3.minD+' - '+item3.maxD+'</td>';
                     appenddata += '<td>'+item3.minD_minus+' - '+item3.maxD_minus+'</td>';
                     appenddata += '<td>'+item3.minE+' - '+item3.maxE+'</td>';
                     //appenddata += '<td>'+item3.min+' - '+item3.max+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Marks End*/

                     /**Deal with Remarks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder">Remarks</td>';
                     appenddata += '<td>'+item3.RemarksA+'</td>';
                     appenddata += '<td>'+item3.RemarksA_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksB_plus+'</td>';
                     appenddata += '<td>'+item3.RemarksB+'</td>';
                     appenddata += '<td>'+item3.RemarksB_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksC_plus+'</td>';
                     appenddata += '<td>'+item3.RemarksC+'</td>';
                     appenddata += '<td>'+item3.RemarksC_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksD_plus+'</td>';
                     appenddata += '<td>'+item3.RemarksD+'</td>';
                     appenddata += '<td>'+item3.RemarksD_minus+'</td>';
                     appenddata += '<td>'+item3.RemarksE+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Remarks End*/
                     $('#gradestable4').append(appenddata)
                 })
                 //Append the overal Grading system
                 $.each(res.grades, function(key,item){
                   $('#upovminA').val(item.minA)
                   $('#upovminA_minus').val(item.minA_minus)
                   $('#upovminB_plus').val(item.minB_plus)
                   $('#upovminB').val(item.minB)
                   $('#upovminB_minus').val(item.minB_minus)
                   $('#upovminC_plus').val(item.minC_plus)
                   $('#upovminC').val(item.minC)
                   $('#upovminC_minus').val(item.minC_minus)
                   $('#upovminD_plus').val(item.minD_plus)
                   $('#upovminD').val(item.minD)
                   $('#upovminD_minus').val(item.minD_minus)
                   $('#upovminE').val(item.minE)
                   $('#upovmaxA').val(item.maxA) 
                   $('#upovmaxA_minus').val(item.maxA_minus)
                   $('#upovmaxB_plus').val(item.maxB_plus)
                   $('#upovmaxB').val(item.maxB)
                   $('#upovmaxB_minus').val(item.maxB_minus)
                   $('#upovmaxC_plus').val(item.maxC_plus)
                   $('#upovmaxC').val(item.maxC)
                   $('#upovmaxC_minus').val(item.maxC_minus)
                   $('#upovmaxD_plus').val(item.maxD_plus)
                   $('#upovmaxD').val(item.maxD)
                   $('#upovmaxD_minus').val(item.maxD_minus)
                   $('#upovmaxE').val(item.maxE)
                   $('#upovRemarksA').val(item.RemarksA)
                   $('#upovRemarksA_minus').val(item.RemarksA_minus)
                   $('#upovRemarksB_plus').val(item.RemarksB_plus)
                   $('#upovRemarksB').val(item.RemarksB)
                   $('#upovRemarksB_minus').val(item.RemarksB_minus)
                   $('#upovRemarksC_plus').val(item.RemarksC_plus)
                   $('#upovRemarksC').val(item.RemarksC)
                   $('#upovRemarksC_minus').val(item.RemarksC_minus)
                   $('#upovRemarksD_plus').val(item.RemarksD_plus)
                   $('#upovRemarksD').val(item.RemarksD)
                   $('#upovRemarksD_minus').val(item.RemarksD_minus)
                   $('#upovRemarksE').val(item.RemarksE)
                })
                }
               }  
                })
            }             
            
        })
    //Handle overall Grading System
    $('#OverGradingForm').submit(function(e){
            $('.loader').removeClass('d-none');
            e.preventDefault()
            $('#overallclass','#gradingtype','#ovmaxA').removeClass('is-valid')
            $('#overallclass','#gradingtype','#ovmaxA').removeClass('is-invalid')
            var formdata = new FormData($(this)[0]);
            formdata.append('class',$('#overallclass').val());
            //formdata.append('subject',$('#subject').val())

            $.ajax({
                method: 'POST',
                url: '/addoverallgrading',
                contentType: false,
                processData: false,
                data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none');
                //console.log(res)
                  if (res.status == 400) {
                    showError('class', res.messages.class);
                    showError('gradingtype', res.messages.gradingtype);
                    showError('ovmaxA', res.messages.maxA);
                    showError('ovminA', res.messages.minA);
                    showError('ovgradeA', res.messages.gradeA);
                    showError('ovRemarksA', res.messages.RemarksA);
                    showError('ovminA_minus', res.messages.minA_minus);
                    showError('ovmaxA_minus', res.messages.maxA_minus);
                    showError('ovgradeA_minus', res.messages.gradeA_minus);
                    showError('ovRemarksA_minus', res.messages.RemarksA_minus);
                    showError('ovmaxB_plus', res.messages.maxB_plus);
                    showError('ovminB_plus', res.messages.minB_plus);
                    showError('ovgradeB_plus', res.messages.gradeB_plus);
                    showError('ovRemarksB_plus', res.messages.RemarksB_plus);
                    showError('ovmaxB', res.messages.maxB);
                    showError('ovminB', res.messages.minB);
                    showError('ovgradeB', res.messages.gradeB);
                    showError('ovRemarksB', res.messages.RemarksB);
                    showError('ovminB_minus', res.messages.minB_minus);
                    showError('ovmaxB_minus', res.messages.maxB_minus);
                    showError('ovgradeB_minus', res.messages.gradeB_minus);
                    showError('ovRemarksB_minus', res.messages.RemarksB_minus);
                    showError('ovmaxC_plus', res.messages.maxC_plus);
                    showError('ovminC_plus', res.messages.minC_plus);
                    showError('ovgradeC_plus', res.messages.gradeC_plus);
                    showError('ovRemarksC_plus', res.messages.RemarksC_plus);
                    showError('ovmaxC', res.messages.maxC);
                    showError('ovminC', res.messages.minC);
                    showError('ovgradeC', res.messages.gradeC);
                    showError('ovpointsC', res.messages.pointsC);
                    showError('ovminC_minus', res.messages.minC_minus);
                    showError('ovmaxC_minus', res.messages.maxC_minus);
                    showError('ovgradeC_minus', res.messages.gradeC_minus);
                    showError('ovRemarksC_minus', res.messages.RemarksC_minus);
                    showError('ovRemarksC', res.messages.RemarksC);
                    showError('ovmaxD_plus', res.messages.maxD_plus);
                    showError('ovminD_plus', res.messages.minD_plus);
                    showError('ovgradeD_plus', res.messages.gradeD_plus);
                    showError('ovRemarksD_plus', res.messages.RemarksD_plus);
                    showError('ovmaxD', res.messages.maxD);
                    showError('ovminD', res.messages.minD);
                    showError('ovgradeD', res.messages.gradeD);
                    showError('ovRemarksD', res.messages.RemarksD);
                    showError('ovminD_minus', res.messages.minD_minus);
                    showError('ovmaxD_minus', res.messages.maxD_minus);
                    showError('ovgradeD_minus', res.messages.gradeD_minus);
                    showError('ovRemarksD_minus', res.messages.RemarksD_minus);
                    showError('ovmaxE', res.messages.maxE);
                    showError('ovminE', res.messages.minE);
                    showError('ovgradeE', res.messages.gradeE);
                    showError('ovRemarksE', res.messages.RemarksE);
                  } else if(res.status == 200){
                      //$('#graderegdiv').removeClass('d-none');
                      $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                      //$('#graderegdiv').text(res.messages);
                      $('#OverGradingForm')[0].reset();
                  } 
               }
            })
        })

        //Update Overall Grading System
        $('#OverGradingFormUpdate').submit(function(e){
            $('.loader').removeClass('d-none');
            e.preventDefault()
            $('#overallclass','#gradingtype2','#ovmaxA').removeClass('is-valid')
            $('#overallclass','#gradingtype2','#ovmaxA').removeClass('is-invalid')
            var formdata = new FormData($(this)[0]);
            formdata.append('class',$('#overallclass').val());
            //formdata.append('subject',$('#subject').val())

            $.ajax({
                method: 'POST',
                url: '/addoverallgrading',
                contentType: false,
                processData: false,
                data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none');
                //console.log(res)
                  if (res.status == 400) {
                    showError('overallclass', res.messages.class);
                    showError('gradingtype2', res.messages.gradingtype);
                    showError('upovmaxA', res.messages.maxA);
                    showError('upovminA', res.messages.minA);
                    showError('upovgradeA', res.messages.gradeA);
                    showError('upovRemarksA', res.messages.RemarksA);
                    showError('upovminA_minus', res.messages.minA_minus);
                    showError('upovmaxA_minus', res.messages.maxA_minus);
                    showError('upovgradeA_minus', res.messages.gradeA_minus);
                    showError('upovRemarksA_minus', res.messages.RemarksA_minus);
                    showError('upovmaxB_plus', res.messages.maxB_plus);
                    showError('upovminB_plus', res.messages.minB_plus);
                    showError('upovgradeB_plus', res.messages.gradeB_plus);
                    showError('upovRemarksB_plus', res.messages.RemarksB_plus);
                    showError('upovmaxB', res.messages.maxB);
                    showError('upovminB', res.messages.minB);
                    showError('upovgradeB', res.messages.gradeB);
                    showError('upovRemarksB', res.messages.RemarksB);
                    showError('upovminB_minus', res.messages.minB_minus);
                    showError('upovmaxB_minus', res.messages.maxB_minus);
                    showError('upovgradeB_minus', res.messages.gradeB_minus);
                    showError('upovRemarksB_minus', res.messages.RemarksB_minus);
                    showError('upovmaxC_plus', res.messages.maxC_plus);
                    showError('upovminC_plus', res.messages.minC_plus);
                    showError('upovgradeC_plus', res.messages.gradeC_plus);
                    showError('upovRemarksC_plus', res.messages.RemarksC_plus);
                    showError('upovmaxC', res.messages.maxC);
                    showError('upovminC', res.messages.minC);
                    showError('upovgradeC', res.messages.gradeC);
                    showError('upovpointsC', res.messages.pointsC);
                    showError('upovminC_minus', res.messages.minC_minus);
                    showError('upovmaxC_minus', res.messages.maxC_minus);
                    showError('upovgradeC_minus', res.messages.gradeC_minus);
                    showError('upovRemarksC_minus', res.messages.RemarksC_minus);
                    showError('upovRemarksC', res.messages.RemarksC);
                    showError('upovmaxD_plus', res.messages.maxD_plus);
                    showError('upovminD_plus', res.messages.minD_plus);
                    showError('upovgradeD_plus', res.messages.gradeD_plus);
                    showError('upovRemarksD_plus', res.messages.RemarksD_plus);
                    showError('upovmaxD', res.messages.maxD);
                    showError('upovminD', res.messages.minD);
                    showError('upovgradeD', res.messages.gradeD);
                    showError('upovRemarksD', res.messages.RemarksD);
                    showError('upovminD_minus', res.messages.minD_minus);
                    showError('upovmaxD_minus', res.messages.maxD_minus);
                    showError('upovgradeD_minus', res.messages.gradeD_minus);
                    showError('upovRemarksD_minus', res.messages.RemarksD_minus);
                    showError('upovmaxE', res.messages.maxE);
                    showError('upovminE', res.messages.minE);
                    showError('upovgradeE', res.messages.gradeE);
                    showError('upovRemarksE', res.messages.RemarksE);
                  } else if(res.status == 200){
                      //$('#graderegdiv').removeClass('d-none');
                      $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                      //$('#graderegdiv').text(res.messages);
                      $('#OverGradingFormUpdate')[0].reset();
                  } 
               }
            })
        })

        $('#addoverallgradingsystem').click(function(e){
            e.preventDefault();
            $('#overallclass').removeClass('is-invalid')
            var classval = $('#overallclass').val();
            $('#updategradesdiv').addClass('d-none')
            $('#gradesdiv').addClass('d-none')
            $('#divgrades').addClass('d-none')
            $('#overalldivgrades').addClass('d-none')
            $('#overallgradingsytemupdateform').addClass('d-none');

            if (classval == '') {
                showError('overallclass','You must select a class');
            } else {
                $('#overallgradingsytemform').removeClass('d-none')   
            }             
            
        })
        //Submit the form
        $('#GradeForm').submit(function(e){
            $('.loader').removeClass('d-none');
            e.preventDefault()
            var formdata = new FormData($(this)[0]);
            formdata.append('class',$('#class').val());
            formdata.append('subject',$('#subject').val())

            $.ajax({
                method: 'POST',
                url: '{{ route('grade.register') }}',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){
                $('.loader').addClass('d-none');
                //console.log(res)
                  if (res.status == 400) {
                    showError('subject1', res.messages.subject);
                    showError('class', res.messages.class);
                    showError('maxA', res.messages.maxA);
                    showError('minA', res.messages.minA);
                    showError('gradeA', res.messages.gradeA);
                    showError('pointsA', res.messages.pointsA);
                    showError('RemarksA', res.messages.RemarksA);
                    showError('minA_minus', res.messages.minA_minus);
                    showError('maxA_minus', res.messages.maxA_minus);
                    showError('pointsA_minus', res.messages.pointsA_minus);
                    showError('gradeA_minus', res.messages.gradeA_minus);
                    showError('RemarksA_minus', res.messages.RemarksA_minus);
                    showError('maxB_plus', res.messages.maxB_plus);
                    showError('minB_plus', res.messages.minB_plus);
                    showError('gradeB_plus', res.messages.gradeB_plus);
                    showError('pointsB_plus', res.messages.pointsB_plus);
                    showError('RemarksB_plus', res.messages.RemarksB_plus);
                    showError('maxB', res.messages.maxB);
                    showError('minB', res.messages.minB);
                    showError('gradeB', res.messages.gradeB);
                    showError('pointsB', res.messages.pointsB);
                    showError('RemarksB', res.messages.RemarksB);
                    showError('minB_minus', res.messages.minB_minus);
                    showError('maxB_minus', res.messages.maxB_minus);
                    showError('pointsB_minus', res.messages.pointsB_minus);
                    showError('gradeB_minus', res.messages.gradeB_minus);
                    showError('RemarksB_minus', res.messages.RemarksB_minus);
                    showError('maxC_plus', res.messages.maxC_plus);
                    showError('minC_plus', res.messages.minC_plus);
                    showError('gradeC_plus', res.messages.gradeC_plus);
                    showError('pointsC_plus', res.messages.pointsC_plus);
                    showError('RemarksC_plus', res.messages.RemarksC_plus);
                    showError('maxC', res.messages.maxC);
                    showError('minC', res.messages.minC);
                    showError('gradeC', res.messages.gradeC);
                    showError('pointsC', res.messages.pointsC);
                    showError('RemarksC', res.messages.RemarksC);
                    showError('minC_minus', res.messages.minC_minus);
                    showError('maxC_minus', res.messages.maxC_minus);
                    showError('pointsC_minus', res.messages.pointsC_minus);
                    showError('gradeC_minus', res.messages.gradeC_minus);
                    showError('RemarksC_minus', res.messages.RemarksC_minus);
                    showError('maxD_plus', res.messages.maxD_plus);
                    showError('minD_plus', res.messages.minD_plus);
                    showError('gradeD_plus', res.messages.gradeD_plus);
                    showError('pointsD_plus', res.messages.pointsD_plus);
                    showError('RemarksD_plus', res.messages.RemarksD_plus);
                    showError('maxD', res.messages.maxD);
                    showError('minD', res.messages.minD);
                    showError('gradeD', res.messages.gradeD);
                    showError('pointsD', res.messages.pointsD);
                    showError('RemarksD', res.messages.RemarksD);
                    showError('minD_minus', res.messages.minD_minus);
                    showError('maxD_minus', res.messages.maxD_minus);
                    showError('pointsD_minus', res.messages.pointsD_minus);
                    showError('gradeD_minus', res.messages.gradeD_minus);
                    showError('RemarksD_minus', res.messages.RemarksD_minus);
                    showError('maxE', res.messages.maxE);
                    showError('minE', res.messages.minE);
                    showError('gradeE', res.messages.gradeE);
                    showError('pointsE', res.messages.pointsE);
                    showError('RemarksE', res.messages.RemarksE);
                  } else if(res.status == 200){
                      $('#graderegdiv').removeClass('d-none');
                      $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                      //$('#graderegdiv').text(res.messages);
                      $('#GradeForm')[0].reset();
                  } 
               }
            })
        })
    })
</script>
@endsection