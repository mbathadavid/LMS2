@extends('layouts.layout')

@section('title','Final Results')

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
<h6 class="text-center text-danger"><i>Final Results Computation</i></h6>

<!--Start of determinant field---> 
<div class="row">
<form action="#" id="selthreadmarks" method="POST">
<input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
<div class="row d-flex justify-content-center p-2">
<div class="col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="form-group">
<label for="">Select Class</label>
<select class="form-control" id="class" name="class">
<option value="">--Select Class--</option>
<!-- @foreach($classes as $classe)
<option value="{{ $classe->id }},{{ $classe->class }},{{ $classe->stream }}">{{ $classe->class }} {{ $classe->stream }}</option>
@endforeach -->
<option value="FORM ONE">FORM ONE</option>
<option value="FORM TWO">FORM TWO</option>
<option value="FORM THREE">FORM THREE</option>
<option value="FORM FOUR">FORM FOUR</option>
</select>
<div class="invalid-feedback"></div>
</div>
</div>


<div class="col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="form-group">
<label for="">Select Thread</label>
<select name="thread" class="form-control" id="thread">
<option value="">--Select Result Thread--</option>
@foreach($threads as $thread)
<option value="{{ $thread->id }},{{ $thread->name }},{{ $thread->term }},{{ $thread->year }}">{{ $thread->name }} {{ $thread->term }} {{ $thread->year }}</option>
@endforeach
</select>
<div class="invalid-feedback"></div>
</div>   
</div>

<div class="row">
    <div id="classdiv" class="col-lg-6 col-md-6 col-sm-6 w3-animate-left d-none">
        <h6 class="w3-red text-center p-2" id="selectedclass">FORM THREE F</h6>
    </div>

    <div id="threaddiv" class="col-lg-6 col-md-6 col-sm-6 w3-animate-right d-none">
        <h6 class="w3-green text-center p-2" id="selectedthread">END TERM 3 2022</h6>
    </div>
</div>


<div class="form-group">
    <button type="submit" id="selectmarks" class="btn btn-sm btn-danger form-control">
        SEARCH FOR THREAD AND MARKS 
    </button>
</div>

</div>
</form>
</div>
<!-------Start Computed Table start----->

<div style="background-color: #e6e6e6;" id="computedresultsdiv" class="p-3 d-none">
<div class="table-responsive">
    <button id="printexcel" class="btn btn-sm w3-blue rounded-0 float-right"><i class="fas fa-file-csv"></i>&nbsp; DOWNLOAD EXCEL</button>
    <button id="printpdf" class="btn btn-sm w3-red rounded-0"><i class="fas fa-file-pdf"></i>&nbsp; PRINT</button>
    <button id="downloadpdf" class="btn btn-sm w3-green rounded-0"><i class="fas fa-file-pdf"></i>&nbsp; DOWNLOAD PDF</button>
        <div style="background-color: white;"  class="mt-3 mb-5 p-3" id="computedresforpdf">
        <h5 class="text-center text-success">{{ $schoolinfo->name }}</h5>
        <div style="height: 100px;" class="d-flex justify-content-center">
        <img style="" src="images/{{ $schoolinfo->logo }}" class="img-fluid img-thumbnail" alt="">
        </div>
        <h6 class="text-center text-danger">{{ $schoolinfo->motto }}</h6>
        <hr>
        <h6 class="text-center w3-green p-2" id="pdfheading"></h6>
        <table class="table" id="computedmarks">
                <thead id="theadings">
                   
                </thead>
                <tbody id="computedresultstable">
                  
                </tbody>
                <!-- <h6 class="text-center">Mean Mark <b><span id="meanmark" class="text-danger"></span></b></h6> -->
                <h6 class="text-center">Mean <b><span id="meanpoints" class="text-danger"></span></b></h6>
                <h6 class="text-center">Mean Grade <b><span id="meangrade" class="text-danger"></span></b></h6>
            </table>
            
            </div>
</div>
</div>




<div class="loader d-none"></div>
<div id="allbody">
<hr>
<div id="norecordsdiv" class="w3-animate-left w3-teal d-none p-2">
<h5 class="text-center">No records matching <span id="missingrecords"></span> Found</h5>
</div>
<!-------Append fetched Results Start----->
<form id="computefinalresultsform" class="p-3 w3-animate-left d-none" method="POST" action="#">

<!-- Subject and Students -->
<div id="substudents" class="d-flex p-2">
<div class="table-responsive">
        <table class="table" style="background-color: #cccccc">
            <thead>
                <tr id="subjectsheading">
                    
                </tr>
            </thead>
            <tbody>
                <tr id="substucounts">

                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Subject and Students -->

<!-- Overall Grading System -->
<div class="table-responsive">
        <table class="table" id="gradestable1" style="background-color: #cccccc">
        <h6 class="text-center"><span class="text-danger" id="gradetableheading"></span></h6>
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
            <tbody id="overallgradingtable">

            </tbody>
        </table>
    </div>
<!-- Overall Grading System End -->


<div class="row w3-light-blue p-2">
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="form-group">
<label for="" class="text-danger"><b>How Many Subject Should be Considered per student?</b></label>
<select name="noofsubjects" id="noofsubjects" class="form-control">
    <option value="">--Select Number of subjects to apply--</option>
    <option value="all">All</option>
    <option value="specify">Let Me Specify</option>
</select>
<div class="invalid-feedback">

</div>
</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-6">
  <div id="subnodiv" style="background-color: #f2f2f2;" class="form-group p-2 w3-animate-left d-none">
    <label for="" class="text-danger"><b>Enter the number of Subjects that should be considered</b></label>
    <input type="number" name="subjectsNo" id="subjectsNo" class="form-control">
    <div class="invalid-feedback"></div>
    </div>  
</div>
</div>

    <h5 class="text-center text-danger">Calculate Final Score by:</h5>
<div class="w3-teal p-2 mt-2 row">
<div class="col-lg-6 col-md-6 col-sm-6 d-grid">
<button id="finalscorebymarks" class="btn btn-sm w3-green">MARKS SCORED</button>
</div>

<div class="col-lg-6 col-md-6 col-sm-6 d-grid">
 <button id="finalscorebypoints" class="btn btn-sm w3-red">POINTS SCORED</button>   
</div>
</div>

<div class="row">

</div>
<div class="form-group">
    
</div>
<div class="table-responsive">
<table class="table">
<thead>
    <tr>
        <th scope="col">Eliminate</th>
        <th scope="col">Adm No</th>
        <th scope="col">Final Score</th>
        <th scope="col">Final Grade</th>
        <th scope="col">Remarks</th>
        <th scope="col">Scores by Marks</th>
        <th scope="col">Scores by Points</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Class</th>
    </tr>
        </thead>
        <tbody id="finalscoresbody">

        </tbody>
        </table>
    <input type="submit" value="PRINT AND ANALYZE" class="btn btn-sm w3-green form-control">
    </form>
<!-------Append fetched Results End----->


</div>
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        var subnames = [];
        var subids = [];
        var remarks = [];
        var minmarks = [];
        var maxmarks = [];
        var topgrades = [];
        var gradingtype = '';
        var tid = '';
        var form ='';
        var filename = '';

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#class').change(function(){
            $('#classdiv').addClass('d-none')
            
            //var val = $(this).val().split(',');
            var val = $(this).val();
            //$('#selectedclass').text(val[1]+' '+val[2]);
            $('#selectedclass').text(val);
            form = val;
            $('#classdiv').removeClass('d-none')
        })

        $('#thread').change(function(){
            $('#threaddiv').addClass('d-none')

            var val = $(this).val().split(',');

            tid = val[0];

            $('#selectedthread').text(val[1]+','+val[2]+','+val[3]);
            $('#threaddiv').removeClass('d-none')
        })

        //Select Thread and marks
        $('#selthreadmarks').submit(function(e){
            e.preventDefault();
            $('#class').removeClass('is-invalid');
            $('#thread').removeClass('is-invalid');
            $('.loader').removeClass('d-none');

            var formData = new FormData($('#selthreadmarks')[0]);

            $.ajax({
                method: 'POST',
                url: '/fetchfinalgrades',
                contentType: false,
                processData: false,
                data: formData,
                success: function(res){
                    $('.loader').addClass('d-none');
                if (res.status == 400) {
                    showError('thread',res.thread);
                    showError('class',res.class);
                } else {
                $("#allbody").removeClass('d-none');
                $("#computedresultsdiv").addClass('d-none');
                console.log(res)
                //console.log(res.grades)
                subnames = [];
                subids = [];
                remarks = [];
                minmarks = [];
                maxmarks = [];
                topgrades = []; 

                if (res.records.length == 0) {
                    $('#missingrecords').text(res.classthread)
                    $('#computefinalresultsform').addClass('d-none')
                    $('#norecordsdiv').removeClass('d-none')
                } else {
                    $('#norecordsdiv').addClass('d-none')
                    $('#computefinalresultsform').removeClass('d-none')
                    if (res.status == 400) {
                    showError('class', res.messages.class);
                    showError('thread', res.messages.thread);
                 } else {
                    $('#finalscoresbody').html('')
                    $('#overallgradingtable').html('')

                    // $('#substudents').html(''); subjectsheading
                    // $.each(res.substudents,function(key,item){
                    //     $('#substudents').append(`<h6>${key} - (${item})</h6>`); substucounts
                    // })

                    $('#subjectsheading').html('');
                    $('#subjectsheading').append('<th class="text-danger">Subjects</th>');
                    $.each(res.substudents,function(key,item){
                        $('#subjectsheading').append(`<th>${key}</th>`); 
                    })

                    $('#substucounts').html('');
                    $('#substucounts').append('<th class="text-danger">Number of Students</th>');
                    $.each(res.substudents,function(key,item){
                        $('#substucounts').append(`<td>${item}</td>`); 
                    })

                    
                //     //Update Grading System
                    if (res.grades == null) {
                        $('#overallgradingtable').html('<h6 class="text-danger">The grading System for This class is not yet set.Make sure you set it.</h6>')
                    } else {
                        remarks.push(res.grades[0].RemarksA,res.grades[0].RemarksA_minus,res.grades[0].RemarksB_plus,res.grades[0].RemarksB,
                               res.grades[0].RemarksB_minus,res.grades[0].RemarksC_plus,res.grades[0].RemarksC,res.grades[0].RemarksC_minus,
                               res.grades[0].RemarksD_plus,res.grades[0].RemarksD,res.grades[0].RemarksD_minus,res.grades[0].RemarksE);
                        
                        minmarks.push(res.grades[0].minA,res.grades[0].minA_minus,res.grades[0].minB_plus,res.grades[0].minB,res.grades[0].minB_minus,
                                res.grades[0].minC_plus,res.grades[0].minC,res.grades[0].minC_minus,res.grades[0].minD_plus,
                                res.grades[0].minD,res.grades[0].minD_minus,res.grades[0].minE);

                        maxmarks.push(res.grades[0].maxA,res.grades[0].maxA_minus,res.grades[0].maxB_plus,res.grades[0].maxB,res.grades[0].maxB_minus,
                                res.grades[0].maxC_plus,res.grades[0].maxC,res.grades[0].maxC_minus,res.grades[0].maxD_plus,res.grades[0].maxD,
                                res.grades[0].maxD_minus,res.grades[0].maxE);

                        topgrades.push(res.grades[0].gradeA,res.grades[0].gradeA_minus,res.grades[0].gradeB_plus,res.grades[0].gradeB,res.grades[0].gradeB_minus,
                                    res.grades[0].gradeC_plus,res.grades[0].gradeC,res.grades[0].gradeC_minus,res.grades[0].gradeD_plus,res.grades[0].gradeD,
                                    res.grades[0].gradeD_minus,res.grades[0].gradeE)
                        

                    gradingtype = res.grades[0].consideration;
                    var appenddata = '';
                    /**Deal with Marks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder"><span id="gradingide">'+res.grades[0].consideration+' Range</td>';
                     appenddata += '<td>'+res.grades[0].minA+' - '+res.grades[0].maxA+'</td>';
                     appenddata += '<td>'+res.grades[0].minA_minus+' - '+res.grades[0].maxA_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].minB_plus+' - '+res.grades[0].maxB_plus+'</td>';
                     appenddata += '<td>'+res.grades[0].minB+' - '+res.grades[0].maxB+'</td>';
                     appenddata += '<td>'+res.grades[0].minB_minus+' - '+res.grades[0].maxB_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].minC_plus+' - '+res.grades[0].maxC_plus+'</td>';
                     appenddata += '<td>'+res.grades[0].minC+' - '+res.grades[0].maxC+'</td>';
                     appenddata += '<td>'+res.grades[0].minC_minus+' - '+res.grades[0].maxC_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].minD_plus+' - '+res.grades[0].maxD_plus+'</td>';
                     appenddata += '<td>'+res.grades[0].minD+' - '+res.grades[0].maxD+'</td>';
                     appenddata += '<td>'+res.grades[0].minD_minus+' - '+res.grades[0].maxD_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].minE+' - '+res.grades[0].maxE+'</td>';
                     //appenddata += '<td>'+item3.min+' - '+item3.max+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Marks End*/

                     /**Deal with Remarks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder">Remarks</td>';
                     appenddata += '<td>'+res.grades[0].RemarksA+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksA_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksB_plus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksB+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksB_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksC_plus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksC+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksC_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksD_plus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksD+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksD_minus+'</td>';
                     appenddata += '<td>'+res.grades[0].RemarksE+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Remarks End*/
                     $('#overallgradingtable').append(appenddata)
                    }

                //     /** Create exam names and ids start */
                    $.each(res.subjects,function(key,item){
                        subnames.push(item.subject)
                        subids.push(item.id) 
                    })
                    /** Create exam names and ids end */

                   $.each(res.students,function(key,item){
                    var appenddata = '';
                    appenddata +='<tr sval="'+item.id+'">';
                    appenddata +='<td><input value="'+item.id+'" type="checkbox" name="enableupdate[]" id="removestudent"></td>';
                    appenddata +='<td><input style="width: auto" send="send" readonly type="number" value="'+item.AdmissionNo+'" sval2="'+item.id+'" name="viewadmissionnumber[]" id="viewadmissionnumber" class="form-control"></td>';

                    var marks = [];
                    var points = [];
                    var subs = [];
                    var grades = [];

                    //   for (let i = 0; i < subids.length; i++) {
                    //     $.each(res.records,function(key,item2){
                    //          if (subids[i] == item2.subid && item2.AdmissionNo == item.AdmissionNo) {
                    //              subs.push(subnames[i])   
                    //          }  
                    //     })
                    //      }

                    $.each(res.records,function(key,item2){
                        if (item2.AdmissionNo == item.AdmissionNo) {
                            marks.push(item2.score)
                            points.push(item2.points)
                            grades.push(item2.grade)

                            for (let k = 0; k < res.subids.length; k++) {
                                //const element = array[k];
                                if (res.subids[k] == item2.subid) {
                                    subs.push(res.subnames[k]);
                                }

                            }
                        }
                    })

                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="" sval2="'+item.id+'" name="viewscore[]" id="finalScore" class="form-control"></td>'; 
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="" sval2="'+item.id+'" name="viewgrade[]" id="finalGrade" class="form-control"></td>';
                    appenddata +='<td><input style="width: auto" send="send" type="text" value="" sval2="'+item.id+'" name="viewremarks[]" id="finalRemarks" class="form-control"><span class="text-danger" style="font-size: 11px;"><i>You can edit the above remarks as per your convinience</i></span></td>';
                    // appenddata +='<td><input send="send" readonly type="text" value="'+subnames+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>';  
                    // appenddata +='<td><input send="send" readonly type="text" value="''" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>';     
                    
                    appenddata +='<td><input send="send" readonly type="text" value="'+marks+'" sval2="'+item.id+'" name="viewmarks[]" id="marks" class="form-control"><span class="text-danger" style="font-size: 11px"><b><i>'+subs+'</i></b></span><span class="text-success" style="font-size: 11px"> Respectively</span></td>';  
                    appenddata +='<td><input send="send" readonly type="text" value="'+points+'" sval2="'+item.id+'" name="viewpoints[]" id="points" class="form-control"><span class="text-danger" style="font-size: 11px"><b><i>'+subs+'</i></b></span><span class="text-success" style="font-size: 11px"> Respectively</span></td>';
                    appenddata +='<td class="d-none"><input send="send" readonly type="text" value="'+grades+'" sval2="'+item.id+'" name="viewgrades[]" id="grades" class="form-control"><span class="text-danger" style="font-size: 11px"><b><i>'+subs+'</i></b></span><span class="text-success" style="font-size: 11px"> Respectively</span></td>';

                    appenddata +='<td class="d-none"><input style="width: auto" send="send" readonly type="text" value="'+subs+'" sval2="'+item.id+'" name="subjects[]" id="subjects" class="form-control"></td>';
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="'+item.Fname+'" sval2="'+item.id+'" name="viewfirstname[]" id="viewfirstname" class="form-control"></td>';
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="'+item.Lname+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>'; 
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="'+item.current_class+'" sval2="'+item.id+'" name="viewclass[]" id="viewclass" class="form-control"></td>';        
                    appenddata +='</tr>';

                    $('#finalscoresbody').append(appenddata)
                   
                   })  
                  }
                 }
  
               }
            }
        })
        })
        //Specify No. of Subject
        $('#noofsubjects').change(function(){
            var val = $(this).val();

            if (val === "specify") {
               $('#subnodiv').removeClass('d-none'); 
            } else {
                $('#subnodiv').addClass('d-none'); 
            }
        })
        //Calculate Scores by marks
        $('#finalscorebymarks').click(function(e){
            // console.log(remarks);
            // console.log(minmarks)
            // console.log(maxmarks)
            // console.log(topgrades)
            e.preventDefault()
            if (gradingtype !== "Marks") {
                alert('The Grading system for this class dictates that grading can only be done based on Points only but not Marks. Please use the POINTS SCORED button to auto-compute results. Else you can go to grading system and update it to compute with Marks')
            } else {
            $('#noofsubjects').removeClass('is-invalid')
            $('#subjectsNo').removeClass('is-invalid')
            var subjectNo = $('#noofsubjects').val();

            if (subjectNo === '') {
                showError('noofsubjects', 'You must indicate the number of subjects that should feature in this exam');
            }
            else if (subjectNo === "all") {
            var markSum = []
            $('#computefinalresultsform').find("input[id='marks']").each(function(i){
                var markArr = $(this).val().split(',');
                var sum = 0;

                for (let i = 0; i < markArr.length; i++) {
                    sum += parseInt(markArr[i])
                }
                markSum.push(sum)
            })

            for (let i = 0; i < markSum.length; i++) {
                $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]) 
                            $(this).addClass('w3-green') 
                        }
                    })
            }

            //Start Computing Final Grade and marks
        var computedgrades = [];
        var computedRemarks = [];
        var mark = 0;

        $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
            mark = $(this).val();
            for (let k = 0; k < maxmarks.length; k++) {
                if (mark >= parseInt(minmarks[k]) && mark <= parseInt(maxmarks[k])) {
                    computedRemarks.push(remarks[k])
                    computedgrades.push(topgrades[k])
                }  
            }

        })

        //Update the Remarks fields
        for (let i = 0; i < computedRemarks.length; i++) {
            $('#computefinalresultsform').find("input[id='finalRemarks']").each(function(i){
                $(this).val(computedRemarks[i])
                //$(this).addClass('w3-green') 
            })

            $('#computefinalresultsform').find("input[id='finalGrade']").each(function(i){
                $(this).val(computedgrades[i])
                $(this).addClass('w3-green') 
            })
        }


            } else if(subjectNo === 'specify'){
               var val = $('#subjectsNo').val();
               if (val == '') {
                showError('subjectsNo', 'You must enter the number of subjects that should be considered');
               } else if(parseInt(val) > subnames.length){
                showError('subjectsNo', `Sorry! The maximum number of subjects registered for this school is ${subnames.length}. You must enter a value less than ${subnames.length}`);
               } else {
                var markSum = []
                $('#computefinalresultsform').find("input[id='marks']").each(function(i){
                var markArr = $(this).val().split(',');
                var arrangedarray = markArr.sort(function(a, b){return b - a});
                var finalArr = arrangedarray.slice(0,parseInt(val))
                var sum = 0;

                for (let i = 0; i < finalArr.length; i++) {
                    sum += parseInt(finalArr[i])
                }
                markSum.push(sum)
            }) 

            for (let i = 0; i < markSum.length; i++) {
                $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]) 
                            $(this).addClass('w3-green') 
                        }
                })
            }

        //Start Computing Final Grade and marks
        var computedgrades = [];
        var computedRemarks = [];
        var mark = 0;

        $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
            mark = $(this).val();
            for (let k = 0; k < maxmarks.length; k++) {
                if (mark >= parseInt(minmarks[k]) && mark <= parseInt(maxmarks[k])) {
                    computedRemarks.push(remarks[k])
                    computedgrades.push(topgrades[k])
                }  
            }

        })

        //Update the Remarks fields
        for (let i = 0; i < computedRemarks.length; i++) {
            $('#computefinalresultsform').find("input[id='finalRemarks']").each(function(i){
                $(this).val(computedRemarks[i])
                //$(this).addClass('w3-green') 
            })

            $('#computefinalresultsform').find("input[id='finalGrade']").each(function(i){
                $(this).val(computedgrades[i])
                $(this).addClass('w3-green') 
            })
        }

               }
            } 
            }
         })



         //Calculate scores by points
         $('#finalscorebypoints').click(function(e){
            //console.log(remarks)
            e.preventDefault()
            if (gradingtype !== 'Points') {
                alert('The Grading system for this class dictates that grading can only be done based on Marks only but not Points. Please use the MARKS SCORED button to auto-compute results. Else you can go to the grading system and update it to compute with Points.')
            } else {
            $('#noofsubjects').removeClass('is-invalid')
            $('#subjectsNo').removeClass('is-invalid')
            var subjectNo = $('#noofsubjects').val();

            if (subjectNo === '') {
                showError('noofsubjects', 'You must indicate the number of subjects that should feature in this exam');
            }
            else if (subjectNo === "all") {
            var markSum = []
            $('#computefinalresultsform').find("input[id='points']").each(function(i){
                var markArr = $(this).val().split(',');
                var sum = 0;

                for (let i = 0; i < markArr.length; i++) {
                    sum += parseInt(markArr[i])
                }
                markSum.push(sum)
            })

            for (let i = 0; i < markSum.length; i++) {
                $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]) 
                            $(this).addClass('w3-green') 
                        }
                    })
            }

        //Start Computing Final Grade and marks
        var computedgrades = [];
        var computedRemarks = [];
        var mark = 0;

        $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
            mark = $(this).val();
            for (let k = 0; k < maxmarks.length; k++) {
                if (mark >= parseInt(minmarks[k]) && mark <= parseInt(maxmarks[k])) {
                    computedRemarks.push(remarks[k])
                    computedgrades.push(topgrades[k])
                }  
            }

        })

        //Update the Remarks fields
        for (let i = 0; i < computedRemarks.length; i++) {
            $('#computefinalresultsform').find("input[id='finalRemarks']").each(function(i){
                $(this).val(computedRemarks[i])
                //$(this).addClass('w3-green') 
            })

            $('#computefinalresultsform').find("input[id='finalGrade']").each(function(i){
                $(this).val(computedgrades[i])
                $(this).addClass('w3-green') 
            })
        }


            } else if(subjectNo === 'specify'){
               var val = $('#subjectsNo').val();
               if (val == '') {
                showError('subjectsNo', 'You must enter the number of subjects that should be considered');
               } else if(parseInt(val) > subnames.length){
                showError('subjectsNo', `Sorry! The maximum number of subjects registered for this school is ${subnames.length}. You must enter a value less than ${subnames.length}`);
               } else {
                var markSum = []
                $('#computefinalresultsform').find("input[id='points']").each(function(i){
                var markArr = $(this).val().split(',');
                var arrangedarray = markArr.sort(function(a, b){return b - a});
                var finalArr = arrangedarray.slice(0,parseInt(val))
                var sum = 0;

                for (let i = 0; i < finalArr.length; i++) {
                    sum += parseInt(finalArr[i])
                }
                markSum.push(sum)
            }) 

            for (let i = 0; i < markSum.length; i++) {
                $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]) 
                            $(this).addClass('w3-green') 
                        }
                })
            }

            //Start Computing Final Grade and marks
        var computedgrades = [];
        var computedRemarks = [];
        var mark = 0;

        $('#computefinalresultsform').find("input[id='finalScore']").each(function(i){
            mark = $(this).val();
            for (let k = 0; k < maxmarks.length; k++) {
                if (mark >= parseInt(minmarks[k]) && mark <= parseInt(maxmarks[k])) {
                    computedRemarks.push(remarks[k])
                    computedgrades.push(topgrades[k])
                }  
            }

        })

        //Update the Remarks fields
        for (let i = 0; i < computedRemarks.length; i++) {
            $('#computefinalresultsform').find("input[id='finalRemarks']").each(function(i){
                $(this).val(computedRemarks[i])
                //$(this).addClass('w3-green') 
            })

            $('#computefinalresultsform').find("input[id='finalGrade']").each(function(i){
                $(this).val(computedgrades[i])
                $(this).addClass('w3-green') 
            })
        }


               }
            } 
            }           
         })

    //Submit overall computation form
    $("#computefinalresultsform").submit(function(e){
        $('.loader').removeClass('d-none');
       // $("#allbody").addClass('d-none');
        e.preventDefault();

        var sid = "{{ session()->get('schooldetails.id') }}";

        var formData = new FormData($(this)[0]);
        formData.append('sid',sid);
        formData.append('tid',tid);
        formData.append('form',form);
        formData.append('gradingtype',gradingtype);


        $.ajax({
                method: 'POST',
                url: '/insertcomputedmarks',
                contentType: false,
                processData: false,
                data: formData,
                success: function(res){
                 $('.loader').addClass('d-none');
                    //console.log(res);

                    if (res.status == 200) {
                        filename = res.filename;

                        // console.log(minmarks);
                        // console.log(maxmarks);
                        // console.log(topgrades);

                        //console.log(typeof(res.average))
                        var avggrade = [];

                         for (let k = 0; k < maxmarks.length; k++) {
                            if (res.actualaverage >= minmarks[k] && res.actualaverage <= maxmarks[k]) {
                                avggrade.push(topgrades[k])
                            }  
                         }

                         $("#meangrade").text(avggrade);

                        $('#meanpoints').text(res.average);
                        $('#pdfheading').text(filename);
                        $("#computedresultsdiv").removeClass('d-none');
                        $("#allbody").addClass('d-none'); 

                        $("#theadings").html("");
                        $("#computedresultstable").html("");
                        var theadings = "";

                        theadings +='<tr>';
                        theadings +='<th scope="col">Adm No</th>';
                        theadings +='<th scope="col">Name</th>';
                        theadings +='<th scope="col" class="text-danger">Class</th>';

                        $.each(res.subjects, function(key,item){
                            theadings +='<th scope="col">'+item.subject+'</th>'
                        })

                        theadings +='<th scope="col">Subjects</th>';
                        theadings +='<th scope="col">DEV</th>';
                        theadings +='<th scope="col">Points Scored</th>';
                        theadings +='<th scope="col">Grade</th>';
                        theadings +='<th scope="col">STR POS</th>';
                        theadings +='<th scope="col">OVR POS</th>';

                        theadings +='</tr>';
                        $('#theadings').append(theadings);


                        $.each(res.Computedmarks, function(key,item){
                        var appenddata ='';
                        
                        appenddata +='<tr>';
                        appenddata +='<td>'+item.AdmissionNo+'</td>';
                        appenddata +='<td>'+item.FName+' '+item.Lname+'</td>';
                        appenddata +='<td>'+item.Class+'</td>';

                        for (let k = 0; k < res.subnames.length; k++) {
                            const element = res.subnames[k];

                            var subarray = item.Subjects.split(',');
                            var marks = item.ScoresByMarks.split(',');
                            var points = item.ScoresByPoints.split(',');
                            var grades = item.Grades.split(',');

                            if (subarray.includes(res.subnames[k])) {
                                var subindex = subarray.indexOf(element);
                                // var pointindex = points.indexOf(element);
                                // var gradeindex = grades.indexOf(element);

                                appenddata +='<td>'+marks[subindex]+','+points[subindex]+','+grades[subindex]+'</td>';
                            } else {
                                appenddata +='<td>_</td>'; 
                            }
                        }

                        appenddata +='<td>'+item.ScoresByMarks.split(',').length+'</td>';
                        appenddata +='<td>'+item.DEV+'</td>';
                        appenddata +='<td>'+item.Finalscore+'</td>';
                        appenddata +='<td>'+item.Finalgrade+'</td>';
                        appenddata +='<td>'+item.STRPOS+'</td>';
                        appenddata +='<td>'+item.OVRPO+'</td>';
                        appenddata +='</tr>';
                        
                        $("#computedresultstable").append(appenddata);

                        })

                    } else {
                        
                    }

                    
                }
                })
    }) 
    
    //Print exccxel
    $('#printexcel').click(function(e){
            e.preventDefault();
            $("#computedmarks").table2excel({
                exclude: ".excludeThisClass",
                name: "Student Results",
                filename: `${filename}.xls`, // do include extension
                preserveColors: true
            })
        })

    //Print pdf
    $('#printpdf').click(function(e){
            e.preventDefault();
            $("#computedresforpdf").print({
                globalStyles : true,
            })
        })

    //Generate a pdf file
    window.onload = function(){
        document.getElementById('downloadpdf').addEventListener('click',()=>{
            const results = this.document.getElementById('computedresforpdf');

            var opt = {
                //margin: 0.5,
                filename: `${filename}.pdf`,
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(results).set(opt).save();
        })
    }

    })
</script>
@endsection