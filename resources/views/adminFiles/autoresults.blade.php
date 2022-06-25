@extends('layouts.layout')

@section('title','Results Computation')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">
@include('adminFiles.motto')
<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')
<h4 class="text-center text-danger"><i>Results Auto Computation</i></h4>

<!--Start of determinant field---> 
<div class="row">
<form action="#" id="selectexams" method="POST">
<div class="row d-flex justify-content-center p-2">
<div class="col-lg-4 mb-2">
<div class="form-group">
<label for="">Select Exams</label>
<select class="form-control" name="exams" id="examsselect" multiple="">
@foreach($exams as $exam)
<option value="{{ $exam->id }}">{{ $exam->Examination }}</option>
@endforeach
</select>
</div>
</div>

<div class="col-lg-4 mb-2">
<div class="form-group">
<label for="">Select The Class</label>
<select name="class" id="class" class="form-control">
<option value="">--Select Class--</option>
@foreach($classes as $class)
<option value="{{ $class->id }}">{{ $class->class }} {{ $class->stream }}</option>
@endforeach
</select>
</div>
<span id="termcheck" class="text-danger d-none"></span>   
</div>

<div class="col-lg-4 mb-2">
<div class="form-group">
<label for="">Select Subject</label>
<select name="subject" class="form-control" id="subject">
<option value="">--Select Subject--</option>
@foreach($subjects as $subject)
<option value="{{ $subject->id }},{{ $subject->subject }}">{{ $subject->subject }}</option>
@endforeach
</select>
</div>   
</div>

<div class="form-group">
    <button type="submit" id="selectmarks" class="btn btn-sm btn-danger form-control d-none">
        PROCEED TO PRODUCE END TERM RESULTS FOR <span id="subjectspan"></span> 
    </button>
</div>

</div>
</form>
</div>


<div class="w3-animate-top" id="response"></div>
<div class="loader d-none"></div>
<!-------Start Computed Table start----->
<div style="background-color: #e6e6e6;" id="computedresultsdiv" class="p-3 d-none">
<div class="table-responsive">
    <button id="printexcel" class="btn btn-sm w3-blue rounded-0 float-right"><i class="fas fa-file-csv"></i>&nbsp; PRINT EXCEL</button>
    <button id="printpdf" class="btn btn-sm w3-red rounded-0"><i class="fas fa-file-pdf"></i>&nbsp; PRINT PDF</button>
        <div style="background-color: white;"  class="mt-3 mb-5 p-3" id="computedresforpdf">
        <h5 class="text-center text-success">{{ $schoolinfo->name }}</h5>
        <div style="height: 100px;" class="d-flex justify-content-center">
        <img style="" src="images/{{ $schoolinfo->logo }}" class="img-fluid img-thumbnail" alt="">
        </div>
        <h6 class="text-center text-danger">{{ $schoolinfo->motto }}</h6>
        <hr>
        <h6 class="text-center w3-red p-2" id="pdfheading"></h6>
        <table class="table" id="computedmarks">
                <thead id="theadings">
                    <!-- <tr>
                        <th scope="col">Adm No</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Final Score</th>
                        <th scope="col">Points</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Remarks</th>
                    </tr> -->
                </thead>
                <tbody id="computedresultstable">
                  
                </tbody>
            </table>
            </div>
</div>
</div>

<!-------Computed Table end----->

<hr>
<!--Start of determinant field--->


<!--Start Results Computation------>
<form id="computesubexamresults" style="" class="p-3 d-none w3-animate-left" action="#">
    <h6 class="w3-green p-1 text-center"><span id="computationheading"></span> RESULTS AUTO COMPUTATIONS</h6>
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
            <tbody id="gradestable">

            </tbody>
        </table>
    </div>


    <h5 class="text-info"><i>Compute Final Results By:</i></h5>
    <div class="row mb-2">
    <div class="col-lg-6 col-md-6 col-sm-6 d-grid">
    <button class="btn btn-sm btn-info" id="sumbtn">SUM</button>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 d-grid">
    <button class="btn btn-sm btn-warning" id="averagebtn">AVERAGE</button>
    </div>
    </div>

    <!---Select type of Average----->
    <div class="w3-red p-2 mt-2 mb-2 d-none w3-animate-top" id="averageselection">
        <h6 class="text-center"><i>How do you want to calculate the average?</i></h6>
        <button class="w3-btn btn-sm w3-green" id="allexamsaverage">All Selected Exams</button>
        <button class="w3-btn btn-sm w3-green" id="perstudentaverage">Exams done by Each Student</button>
    </div>
    <!---Select type of Average End----->
        <div class="form-group d-none">
            <input type="number" id="examcounts" name="examcounts" class="form-control">
        </div>


        <div class="table-responsive">
            <table class="table" id="markscomputetable">
                <thead>
                    <tr>
                        <th scope="col">Eliminate</th>
                        <th scope="col">Adm No</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">
                            <h6>Scores for</h6>
                            <h6 style="font-size: 13px"><span style="color: coral" id="examscon"></span> Respectively</h6>
                        </th>
                        <th scope="col">Final Score</th>
                        <th scope="col">Points</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody id="computeexamresultstable">
                  
                </tbody>
            </table>
        </div>
        <div class="form-group mb-2 d-grid">
        <input id="updatemarks" type="submit" value="UPDATE MARKS" class="form-control btn btn-sm btn-danger d-none">
        </div>
        <div class="form-group mb-2 d-none">
        <input type="number" name="sid" id="sid" class="form-control">
        </div>
        <div class="form-group mb-2 d-none">
        <input type="number" name="cid" id="cid" class="form-control">
        </div>
        <div class="form-group mb-2">
            <label class="text-danger text-bold">Result Thread</label>
            <select name="examthread" id="examthread" class="form-control">

            </select>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group mb-2 d-grid" id="submission">
            
        </div>
        <div id="response1">

        </div>
    </form>
<!--End results computation------->

<!--Report missing marks------->
<h3 class="text-success text-center d-none w3-animate-right" id="reportmissingmark"></h3>
<!--Report missing marks end------->

</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        var remarks = [];
        var minmarks = [];
        var maxmarks = [];
        var grades = [];
        var points = [];
        var filtredmin = [];
        var examinations = "";
        var filename = "";

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        // $('#markscomputetable').DataTable({
        //      order: [0, 'desc']
        // });

        $("#examsselect").chosen()

        //Check for current term
        $('#class').change(function(){
            var classval = $(this).val(); 
            if ($(this).val() != "") {
                $('#termcheck').removeClass('d-none')
                $('#termcheck').text('Checking Current Term.Please Wait....')

              $.ajax({
              method: 'GET',
              url: `/checkcurrentterm/${classval}`,
              contentType: false,
              processData: false,
              success: function(res){
                console.log(res.students.length)

                if (res.students.length == 0) {
                    $('#termcheck').removeClass('d-none')
                    $('#termcheck').text('Sorry! The System found no students in this class. Please make sure you promote students to this class')
                } else {
                    if (res.cterm.current_term != null) {
                    $('#termcheck').addClass('d-none')
                    $('#termcheck').text('') 
                } else {
                    $('#termcheck').removeClass('d-none')
                    $('#termcheck').text('Sorry! The Current Term for This Class is not yet set. Please follow <a href="/terms">this link</a> to set it.')  
                } 
                }
              /*  if (res.cterm.current_term != null) {
                    $('#termcheck').addClass('d-none')
                    $('#termcheck').text('') 
                } else {
                 $('#termcheck').removeClass('d-none')
                 $('#termcheck').text('Sorry! The Current Term for This Class is not yet set. Please follow <a href="/terms">this link</a> to set it.')  
                } */
              }
            })
            }
            else {
              $('#termcheck').addClass('d-none')
              $('#termcheck').text('')   
            }
        })
        
        $('#subject').change(function(){
            if ($(this).val() != "") {
                $('#selectmarks').removeClass('d-none')
                $('#subjectspan').text($(this).val().split(',')[1].toUpperCase())
            } else {
                $('#selectmarks').addClass('d-none')
                $('#subjectspan').text($(this).val()) 
            }
        })

        //Exams select ajax
        $('#selectexams').submit(function(e){
            $('.loader').removeClass('d-none')
            $('#computedresultsdiv').addClass('d-none')
            e.preventDefault()
            $('#subjectgrade').text('')
            $('#computesubexamresults').addClass('d-none');
            var formData = new FormData($(this)[0])
            formData.append('exams',$('#examsselect').val())

            $.ajax({
              method: 'POST',
              url: '/checkmarks',
              contentType: false,
              processData: false,
              data: formData,
              success: function(res){
                $('.loader').addClass('d-none')
                console.log(res)
                remarks = []
                minmarks = []
                maxmarks = []
                grades = [];
                points = [];

                var array = res.grades[0];
                $('#cid').val(res.cid);
                $('#sid').val(res.sid)
                $('#examthread').html('');
                $('#examthread').append('<option value="">--Select Result Thread--</option>')

                if (res.threads.length == 0) {
                    $('#submission').html('<h5 class="text-center text-danger">No Result Threads created yet. Click to <a href="/examresthread">Create Thread</a></h5>')
                } else {
                    $('#submission').html('<button class="btn btn-sm w3-cyan" type="submit" id="saveforfuture">PRINT AND SAVE</button>') 
                }

                $.each(res.threads,function(key,item){
                    $('#examthread').append('<option value="'+item.id+'">'+item.term+' '+item.year+' '+item.name+'</option>')
                })

                $('#computationheading').text(res.class.class.toUpperCase()+' '+res.stream.stream.toUpperCase()+' '+' '+res.subject.subject.toUpperCase())

                for (var key in array) {
                if (array.hasOwnProperty(key)) {
                    if (key.includes('Remarks')) {
                        remarks.push(array[key])
                    }

                    //if (key === ('minE' | 'minD_minus' | 'minC_minus' | 'minB_minus' | 'minA_minus' | 'minD_plus' | 'minC_plus' | 'minB_plus')) {
                    //if (key === 'minE'  'minD_minus') {
                    
                    if (key.includes('minE')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minD_minus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minD')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minD_plus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minC_minus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minC')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minC_plus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minB_minus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minB')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minB_plus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minA_minus')) {
                        minmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('minA')) {
                        minmarks.push(parseInt(array[key]))
                    }

                    if (key.includes('max')) {
                        maxmarks.push(parseInt(array[key]))
                    }
                    if (key.includes('point')) {
                        points.push(parseInt(array[key]))
                    }
                    if (key.includes('grade')) {
                        grades.push(array[key])
                    }

                    //Remove duplicates
                    function removeDuplicates(arr) {
                        //var results = [];
                        for(var i = 0; i < arr.length; i++) {
                            var item = arr[i];
                            if(filtredmin.indexOf(item) === -1) {
                                filtredmin.push(item);
                            }
                        }
                        return filtredmin;
                        }

                        removeDuplicates(minmarks);
                }
                }
                
                $('#examcounts').val(res.examnames.length)

                if (res.marks.length == 0) {
                    $('#reportmissingmark').removeClass('d-none')
                    $('#reportmissingmark').html("<i>We did not find any marks for "+$('#subject').val().split(',')[1]+"</i>")
                    //console.log('Sorry! We did not find any marks')
                } else {
                $('#reportmissingmark').addClass('d-none')
                $('#reportmissingmark').html('')
                $('#computesubexamresults').removeClass('d-none');
                $('#examscon').text(res.examnames);
                examinations = res.examnames;
                $('#computeexamresultstable').html('');

                $.each(res.students,function(key,item){
                    var appenddata = '';
                    appenddata +='<tr sval="'+item.id+'">';
                    appenddata +='<td><input value="'+item.id+'" type="checkbox" name="enableupdate[]" id="removestudent"></td>';
                    appenddata +='<td><input send="send" readonly type="number" value="'+item.AdmissionNo+'" sval2="'+item.id+'" name="viewadmissionnumber[]" id="viewadmissionnumber" class="form-control"></td>';
                    appenddata +='<td><input send="send" readonly type="text" value="'+item.Fname+'" sval2="'+item.id+'" name="viewfirstname[]" id="viewfirstname" class="form-control"></td>';
                    appenddata +='<td><input send="send" readonly type="text" value="'+item.Lname+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" class="form-control"></td>'; 
                    
                    var mark = [];
                    var missingmark = [];
                    
                    $.each(res.marks,function(key,item2){ 
                        for (let i = 0; i < res.exams.length; i++) {
                            if (item2.AdmissionNo == item.AdmissionNo && item2.examid == res.exams[i]) {
                                var examid = res.exams[i];  
                                mark.push(item2.marks)
                                missingmark.push(res.examids[examid])  
                            } 
                        }
                    })
                    
                    if (missingmark.length <= 1) {
                    appenddata +='<td><input send="send" readonly type="text" value="'+mark+'" sval2="'+item.id+'" name="viewmaxscore[]" id="marksscored" id2="updation2" class="form-control"><span class="text-danger" style="font-size: 11px">'+missingmark+'</span></td>';  
                    } else {
                    appenddata +='<td><input send="send" readonly type="text" value="'+mark+'" sval2="'+item.id+'" name="viewmaxscore[]" id="marksscored" id2="updation2" class="form-control"><span class="text-danger" style="font-size: 11px">'+missingmark+'</span><span class="text-success" style="font-size: 11px"> Respectively</span></td>';  
                    }
                    appenddata +='<td class="d-none"><input send="send" readonly type="text" value="'+missingmark+'" sval2="'+item.id+'" name="availableexams[]" id="availableexams" id2="updation2" class="form-control"></td>';  
                    appenddata +='<td class="d-none"><input send="send" readonly type="text" value="'+mark+'" sval2="'+item.id+'" name="scores[]" id="scores" id2="updation2" class="form-control"></td>';  
                    appenddata +='<td><input send="send" readonly type="number" value="" sval2="'+item.id+'" name="finalscore[]" id="finalScore" id2="updation2" class="form-control"></td>';  
                    appenddata +='<td><input send="send" readonly type="number" value="" sval2="'+item.id+'" name="points[]" id="points" id2="updation2" class="form-control"></td>'; 
                    appenddata +='<td><input send="send" readonly type="text" value="" sval2="'+item.id+'" name="grades[]" id="grades" id2="updation2" class="form-control"></td>'; 
                    appenddata +='<td><input send="send" readonly type="text" value="" sval2="'+item.id+'" name="remarks[]" id="remarks" id2="updation2" class="form-control"></td>';
                    
                    appenddata +='</tr>';
                    $("#computeexamresultstable").append(appenddata);
                })
              }
              //Print Grades
              $('#gradestable').html('')
              $('#subjectgrade').text(res.grades.subject)
              if (res.grades.length == 0) {
                $('#gradestable').html('')
                $('#gradestable').html('Grading System not yet set')
              } else {
               $.each(res.grades,function(key,item3){
                   $
                    $('#gradestable').html('')
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
                     $('#gradestable').append(appenddata)
                 })
              }
            

              }
            })
        })
        //Work On Removing Students
        $(document).on('change','#removestudent',function(e){
            var selectedbox = $(this).val()
            $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                $(this).removeClass('bg-danger')
            })

            $('#computesubexamresults').find(`input[sval2='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                $(this).toggleClass('bg-danger')
            })
        })
        //Perform Sum Up
        $(document).on('click','#sumbtn',function(e){
            $('#averageselection').addClass('d-none');
            e.preventDefault();
            $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                $(this).val('') 
                $(this).removeClass('w3-yellow')
            })

            $('#computesubexamresults').find("input[id='remarks']").each(function(i){
                    $(this).val('')
                    $(this).removeClass('w3-yellow') 
                 }) 
                 $('#computesubexamresults').find("input[id='points']").each(function(i){
                    $(this).val('')
                    $(this).removeClass('w3-yellow') 
                 }) 
                 $('#computesubexamresults').find("input[id='grades']").each(function(i){
                    $(this).val('')
                    $(this).removeClass('w3-yellow') 
            })
            var finalScore = 'marksscored';
            var markSum = [];
            var admNos = [];
            $('#computesubexamresults').find(`input[id='${finalScore}']`).each(function(i){
                var markArr = $(this).val().split(',')
                var admNo = $(this).attr('sval2')
                var sum = 0;
                for (let i = 0; i < markArr.length; i++) {
                    sum += parseInt(markArr[i])
                }
                 markSum.push(sum)
                 admNos.push(parseInt(admNo))
                })

                for (let i = 0; i < markSum.length; i++) {
                    $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]) 
                            $(this).addClass('w3-green') 
                        }
                    })
                }

                //Auto-grade
                var computedremarks = [];
                var computedpoints = [];
                var computedadms = [];
                var computedgrades = [];
                var mark = 0;
                $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                    mark = $(this).val();
                    for (let k = 0; k < maxmarks.length; k++) {
                       if (mark >= filtredmin[k] && mark <= maxmarks[k]) {
                        computedremarks.push(remarks[k])
                        computedpoints.push(points[k])
                        computedgrades.push(grades[k]) 
                       } 
                    }
                    })  
                

                for (let i = 0; i < computedremarks.length; i++) {
                 $('#computesubexamresults').find("input[id='remarks']").each(function(i){
                    $(this).val(computedremarks[i])
                    $(this).addClass('w3-green') 
                 }) 
                 $('#computesubexamresults').find("input[id='points']").each(function(i){
                    $(this).val(computedpoints[i])
                    $(this).addClass('w3-green') 
                 }) 
                 $('#computesubexamresults').find("input[id='grades']").each(function(i){
                    $(this).val(computedgrades[i])
                    $(this).addClass('w3-green') 
                 })                             
                }
                     
        })
        //Perform Average
        $(document).on('click','#averagebtn',function(e){
            e.preventDefault();
            $('#averageselection').removeClass('d-none');
        })
        //Compute by all Exams Average
        $(document).on('click','#allexamsaverage',function(e){
            e.preventDefault();
            $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                $(this).val('') 
                $(this).removeClass('w3-green') 
            })
        
            var examcount = parseInt($('#examcounts').val())
            //console.log(examcount)
            var finalScore = 'marksscored';
            var markSum = [];
            var admNos = [];
            $('#computesubexamresults').find(`input[id='${finalScore}']`).each(function(i){
                var markArr = $(this).val().split(',')
                var admNo = $(this).attr('sval2')
                var sum = 0;
                for (let i = 0; i < markArr.length; i++) {
                    sum += parseInt(markArr[i])
                }
                 markSum.push(sum)
                 admNos.push(parseInt(admNo))
                })
            
                for (let i = 0; i < markSum.length; i++) {
                    $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]/examcount) 
                            $(this).addClass('w3-yellow') 
                        }
                    })
                }

                //Auto-grade
                var computedremarks = [];
                var computedpoints = [];
                var computedadms = [];
                var computedgrades = [];
                var mark = 0;
                $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                    mark = $(this).val();
                    for (let k = 0; k < maxmarks.length; k++) {
                       if (mark >= filtredmin[k] && mark <= maxmarks[k]) {
                        computedremarks.push(remarks[k])
                        computedpoints.push(points[k])
                        computedgrades.push(grades[k]) 
                       } 
                    }
                    })  
                

                for (let i = 0; i < computedremarks.length; i++) {
                 $('#computesubexamresults').find("input[id='remarks']").each(function(i){
                    $(this).val(computedremarks[i])
                    $(this).addClass('w3-yellow') 
                 }) 
                 $('#computesubexamresults').find("input[id='points']").each(function(i){
                    $(this).val(computedpoints[i])
                    $(this).addClass('w3-yellow') 
                 }) 
                 $('#computesubexamresults').find("input[id='grades']").each(function(i){
                    $(this).val(computedgrades[i])
                    $(this).addClass('w3-yellow') 
                 })                             
                }
        })
        //Per Student Average
        $(document).on('click','#perstudentaverage',function(e){
            e.preventDefault();
            $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                $(this).val('') 
                $(this).removeClass('w3-green')
            }) 

            var finalScore = 'marksscored';
            var markSum = [];
            var examcounts = [];
            $('#computesubexamresults').find(`input[id='${finalScore}']`).each(function(i){
                var markArr = $(this).val().split(',')
                var examlength = $(this).val().split(',').length
                var admNo = $(this).attr('sval2')
                var sum = 0;
                for (let i = 0; i < markArr.length; i++) {
                    sum += parseInt(markArr[i])
                }
                 markSum.push(sum)
                 //admNos.push(parseInt(admNo))
                 examcounts.push(parseInt(examlength))
                })
            
                for (let i = 0; i < markSum.length; i++) {
                    $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                        if (isNaN(markSum[i])) {
                            $(this).val('')
                            $(this).addClass('bg-danger')
                        } else {
                            $(this).val(markSum[i]/examcounts[i]) 
                            $(this).addClass('w3-yellow') 
                        }
                    })
                }

                //Auto-grade
                var computedremarks = [];
                var computedpoints = [];
                var computedadms = [];
                var computedgrades = [];
                var mark = 0;
                $('#computesubexamresults').find("input[id='finalScore']").each(function(i){
                    mark = $(this).val();
                    for (let k = 0; k < maxmarks.length; k++) {
                       if (mark >= filtredmin[k] && mark <= maxmarks[k]) {
                        computedremarks.push(remarks[k])
                        computedpoints.push(points[k])
                        computedgrades.push(grades[k]) 
                       } 
                    }
                    })  
                

                for (let i = 0; i < computedremarks.length; i++) {
                 $('#computesubexamresults').find("input[id='remarks']").each(function(i){
                    $(this).val(computedremarks[i])
                    $(this).addClass('w3-yellow') 
                 }) 
                 $('#computesubexamresults').find("input[id='points']").each(function(i){
                    $(this).val(computedpoints[i])
                    $(this).addClass('w3-yellow') 
                 }) 
                 $('#computesubexamresults').find("input[id='grades']").each(function(i){
                    $(this).val(computedgrades[i])
                    $(this).addClass('w3-yellow') 
                 })                             
                }
        })
        //Prepare an excel sheet
        $("#computesubexamresults").submit(function(e){
            $('#computedresultsdiv').addClass('d-none')
            $('.loader').removeClass('d-none')
            e.preventDefault();
            $('#response1').addClass('d-none');
            if (grades.length == 0) {
                $('#response1').removeClass('d-none');
                $('#response1').html('<h5 class="text-center p-2 w3-red">Grading System Must Be Set in order to execute this plan. <a href="/gradingsystem">Set Grading System</a></h5>')  
            } else {
            var formData = new FormData($('#computesubexamresults')[0]);
            formData.append('examinations',examinations);

            $.ajax({
                method: 'POST',
                url: '/insfinsubres',
                contentType: false,
                processData: false,
                data: formData,
                success: function(res){
                    $('.loader').addClass('d-none')
                    console.log(res);
                    if (res.status == 400) {
                        showError('examthread', res.messages.examthread);
                    } 
                    else if(res.status == 401){
                        $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')  
                    }
                     else if(res.status == 200){
                        $('#computedresultsdiv').removeClass('d-none')
                        $('#computesubexamresults').addClass('d-none')
                        $('#computedresultstable').html('')
                        //$('#librarianform')[0].reset();
                        $("#computesubexamresults")[0].reset();
                        $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>') 
                        $('#theadings').html('');

                        var theadings = "";
                        theadings +='<tr>';
                        theadings +='<th scope="col">Adm No</th>';
                        theadings +='<th scope="col">First Name</th>';
                        theadings +='<th scope="col">Last Name</th>';

                        var exaheadings = res.examinations.split(',');
                        for (let i = 0; i < exaheadings.length; i++) {
                            theadings +='<th scope="col">'+exaheadings[i]+'</th>'; 
                        }
                        //theadings +='<th scope="col">'+res.examinations+'</th>'
                        theadings +='<th scope="col">Final Score</th>';
                        theadings +='<th scope="col">Points</th>';
                        theadings +='<th scope="col">Grade</th>';
                        theadings +='<th scope="col">Remarks</th>';
                        theadings +='</tr>';
                        $('#theadings').append(theadings);

                         $.each(res.data, function(key,item){
                            var appenddata = '';

                            appenddata +='<tr>';
                            appenddata +='<td>'+item.AdmissionNo+'</td>';
                            appenddata +='<td>'+item.FName+'</td>';
                            appenddata +='<td>'+item.Lname+'</td>';

                            var selexams = res.examinations.split(',');
                            var marks = item.scores.split(',');
                            for (let i = 0; i < selexams.length; i++) {
                                if (marks[i] !== "") {
                                    appenddata +='<td>'+marks[i]+'</td>';  
                                } else {
                                    appenddata +='<td>No marks</td>'; 
                                }
                              
                            }

                            appenddata +='<td>'+item.score+'</td>';
                            appenddata +='<td>'+item.points+'</td>'; 
                            appenddata +='<td>'+item.grade+'</td>'; 
                            appenddata +='<td>'+item.Remarks+'</td>'; 
                            appenddata +='</tr>';

                            $('#computedresultstable').append(appenddata)

                         })
                         filename = res.filename;
                         $('#pdfheading').text(res.filename);   
                            // $("#computedmarks").table2excel({
                            // exclude: ".excludeThisClass",
                            // name: "Student Details",
                            // filename: `${res.filename}.xls`, // do include extension
                            // //preserveColors: false
                            // })
                    }
                }
            })
            }
        })
        //Work on printing excel
        $('#printexcel').click(function(e){
            e.preventDefault();
            $("#computedmarks").table2excel({
                exclude: ".excludeThisClass",
                name: "Student Details",
                filename: `${filename}.xls`, // do include extension
                preserveColors: true
            })
        })
        //Generate PDF
        window.onload = function(){
        document.getElementById('printpdf').addEventListener('click',()=>{
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
<script>
    // window.onload = function(){
    //     document.getElementById('printpdf').addEventListener('click',()=>{
    //         const results = this.document.getElementById('computedmarks');

    //         var opt = {
    //             margin: 0.5,
    //             filename: `${filename}.pdf`,
    //             image: { type: 'jpeg', quality: 0.98 },
    //             html2canvas: { scale: 2 },
    //             jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    //         };

    //         html2pdf().from(results).set(opt).save();
    //     })
    // }
</script>
@endsection