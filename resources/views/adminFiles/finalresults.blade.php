@extends('layouts.layout')

@section('title','Final Results')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">
<!-- @include('adminFiles.motto') -->
<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')
<h4 class="text-center text-danger"><i>Final Results Computation</i></h4>

<!--Start of determinant field---> 
<div class="row">
<form action="#" id="selthreadmarks" method="POST">
<div class="row d-flex justify-content-center p-2">
<div class="col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="form-group">
<label for="">Select Class</label>
<select class="form-control" id="class" name="class">
<option value="">--Select Class--</option>
@foreach($classes as $classe)
<option value="{{ $classe->id }},{{ $classe->class }},{{ $classe->stream }}">{{ $classe->class }} {{ $classe->stream }}</option>
@endforeach
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

<div class="loader d-none"></div>

<hr>
<div id="norecordsdiv" class="w3-animate-left w3-teal d-none p-2">
<h5 class="text-center">No records matching <span id="missingrecords"></span> Found</h5>
</div>
<!-------Append fetched Results Start----->
<form id="computefinalresultsform" class="p-3 w3-animate-left d-none" action="#">

<!-- Subject and Students -->
<div id="substudents" class="d-flex p-2">

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
    </tr>
        </thead>
        <tbody id="finalscoresbody">

        </tbody>
        </table>
    </form>
<!-------Append fetched Results End----->


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

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#class').change(function(){
            $('#classdiv').addClass('d-none')
            
            var val = $(this).val().split(',');
            $('#selectedclass').text(val[1]+' '+val[2]);
            $('#classdiv').removeClass('d-none')
        })

        $('#thread').change(function(){
            $('#threaddiv').addClass('d-none')

            var val = $(this).val().split(',');
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
                console.log(res)
                subnames = [];
                subids = [];
                remarks = [];
                minmarks = [];
                maxmarks = [];
                topgrades = []; 

                $('.loader').addClass('d-none');

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

                    $('#substudents').html('');
                    $.each(res.substudents,function(key,item){
                        $('#substudents').append(`<h6>${key} - (${item})</h6>`); 
                    })
                    
                    //Update Grading System
                    if (res.grades == null) {
                        $('#overallgradingtable').html('<h6 class="text-danger">The grading System for This class is not yet set.Make sure you set it.</h6>')
                    } else {
                        remarks.push(res.grades.RemarksA,res.grades.RemarksA_minus,res.grades.RemarksB_plus,res.grades.RemarksB,
                               res.grades.RemarksB_minus,res.grades.RemarksC_plus,res.grades.RemarksC,res.grades.RemarksC_minus,
                               res.grades.RemarksD_plus,res.grades.RemarksD,res.grades.RemarksD_minus,res.grades.RemarksE);
                        
                        minmarks.push(res.grades.minA,res.grades.minA_minus,res.grades.minB_plus,res.grades.minB,res.grades.minB_minus,
                                res.grades.minC_plus,res.grades.minC,res.grades.minC_minus,res.grades.minD_plus,
                                res.grades.minD,res.grades.minD_minus,res.grades.minE);

                        maxmarks.push(res.grades.maxA,res.grades.maxA_minus,res.grades.maxB_plus,res.grades.maxB,res.grades.maxB_minus,
                                res.grades.maxC_plus,res.grades.maxC,res.grades.maxC_minus,res.grades.maxD_plus,res.grades.maxD,
                                res.grades.maxD_minus,res.grades.maxE);

                        topgrades.push(res.grades.gradeA,res.grades.gradeA_minus,res.grades.gradeB_plus,res.grades.gradeB,res.grades.gradeB_minus,
                                    res.grades.gradeC_plus,res.grades.gradeC,res.grades.gradeC_minus,res.grades.gradeD_plus,res.grades.gradeD,
                                    res.grades.gradeD_minus,res.grades.gradeE)
                        

                        gradingtype = res.grades.consideration;
                        var appenddata = '';
                    /**Deal with Marks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder"><span id="gradingide">'+res.grades.consideration+' Range</td>';
                     appenddata += '<td>'+res.grades.minA+' - '+res.grades.maxA+'</td>';
                     appenddata += '<td>'+res.grades.minA_minus+' - '+res.grades.maxA_minus+'</td>';
                     appenddata += '<td>'+res.grades.minB_plus+' - '+res.grades.maxB_plus+'</td>';
                     appenddata += '<td>'+res.grades.minB+' - '+res.grades.maxB+'</td>';
                     appenddata += '<td>'+res.grades.minB_minus+' - '+res.grades.maxB_minus+'</td>';
                     appenddata += '<td>'+res.grades.minC_plus+' - '+res.grades.maxC_plus+'</td>';
                     appenddata += '<td>'+res.grades.minC+' - '+res.grades.maxC+'</td>';
                     appenddata += '<td>'+res.grades.minC_minus+' - '+res.grades.maxC_minus+'</td>';
                     appenddata += '<td>'+res.grades.minD_plus+' - '+res.grades.maxD_plus+'</td>';
                     appenddata += '<td>'+res.grades.minD+' - '+res.grades.maxD+'</td>';
                     appenddata += '<td>'+res.grades.minD_minus+' - '+res.grades.maxD_minus+'</td>';
                     appenddata += '<td>'+res.grades.minE+' - '+res.grades.maxE+'</td>';
                     //appenddata += '<td>'+item3.min+' - '+item3.max+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Marks End*/

                     /**Deal with Remarks */
                     appenddata += '<tr>';
                     appenddata += '<td style="font-weight: bolder">Remarks</td>';
                     appenddata += '<td>'+res.grades.RemarksA+'</td>';
                     appenddata += '<td>'+res.grades.RemarksA_minus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksB_plus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksB+'</td>';
                     appenddata += '<td>'+res.grades.RemarksB_minus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksC_plus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksC+'</td>';
                     appenddata += '<td>'+res.grades.RemarksC_minus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksD_plus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksD+'</td>';
                     appenddata += '<td>'+res.grades.RemarksD_minus+'</td>';
                     appenddata += '<td>'+res.grades.RemarksE+'</td>';
                     appenddata += '</tr>';
                     /**Deal with Remarks End*/
                     $('#overallgradingtable').append(appenddata)
                    }

                    /** Create exam names and ids start */
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

                      for (let i = 0; i < subids.length; i++) {
                        $.each(res.records,function(key,item2){
                             if (subids[i] == item2.subid && item2.AdmissionNo == item.AdmissionNo) {
                                 subs.push(subnames[i])   
                             }  
                        })
                         }

                    $.each(res.records,function(key,item2){
                        if (item2.AdmissionNo == item.AdmissionNo) {
                            marks.push(item2.score)
                            points.push(item2.points)
                        }
                    })

                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="" sval2="'+item.id+'" name="viewlname[]" id="finalScore" class="form-control"></td>'; 
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="" sval2="'+item.id+'" name="viewlname[]" id="finalGrade" class="form-control"></td>';
                    appenddata +='<td><input style="width: auto" send="send" type="text" value="" sval2="'+item.id+'" name="viewlname[]" id="finalRemarks" class="form-control"><span class="text-danger" style="font-size: 11px;"><i>You can edit the above remarks as per your convinience</i></span></td>';
                    // appenddata +='<td><input send="send" readonly type="text" value="'+subnames+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>';  
                    // appenddata +='<td><input send="send" readonly type="text" value="''" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>';     
                    
                    appenddata +='<td><input send="send" readonly type="text" value="'+marks+'" sval2="'+item.id+'" name="viewlname[]" id="marks" class="form-control"><span class="text-danger" style="font-size: 11px"><b><i>'+subs+'</i></b></span><span class="text-success" style="font-size: 11px"> Respectively</span></td>';  
                    appenddata +='<td><input send="send" readonly type="text" value="'+points+'" sval2="'+item.id+'" name="viewlname[]" id="points" class="form-control"><span class="text-danger" style="font-size: 11px"><b><i>'+subs+'</i></b></span><span class="text-success" style="font-size: 11px"> Respectively</span></td>';
                    
                    appenddata +='<td class="d-none"><input style="width: auto" send="send" readonly type="text" value="'+subs+'" sval2="'+item.id+'" name="subjects[]" id="subjects" class="form-control"></td>';
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="'+item.Fname+'" sval2="'+item.id+'" name="viewfirstname[]" id="viewfirstname" class="form-control"></td>';
                    appenddata +='<td><input style="width: auto" send="send" readonly type="text" value="'+item.Lname+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>';         
                    appenddata +='</tr>';

                    $('#finalscoresbody').append(appenddata)
                   
                   })  
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
            console.log(remarks);
            console.log(minmarks)
            console.log(maxmarks)
            console.log(topgrades)
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
            console.log(remarks)
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

    })
</script>
@endsection