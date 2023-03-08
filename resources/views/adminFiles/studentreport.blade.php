@extends('layouts.layout')

@section('title','Student Reporting')

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
<!---Student subjects report modal start--->
<div class="modal w3-animate-zoom" id="studentsubjectreportModal" tabindex="-1" aria-labelledby="studentsubjectreportModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center">Subjects Report for <span class="text-danger" id="studenttosubreport"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       <form method="POST" action="#" id="subjectsreportform" enctype="multipart/form-data">
        <input type="number" name="studentid" id="studentid" hidden>
            <div class="table-responsive">
            <table class="table">
                <thead class="w3-green">
                <tr>
                    <th scope="col">Select (Report)</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Report</th>
                </tr>
            </thead>
                <tbody id="subreporttable">
                    
                </tbody>
            </table>
            </div>
        <input type="submit" value="SAVE REPORT" id="submitsubjectreportbtn" class="form-control btn btn-sm btn-rounded-0 w3-green d-none">
       </form>
        </div>
    </div>
    </div>
</div>
<!---Student subjects report modal end--->

<!---Student general report modal start--->
<div class="modal w3-animate-zoom" id="studentgeneralreportModal" tabindex="-1" aria-labelledby="studentgeneralreportModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <!-- <h5 class="modal-title text-success text-center">General Report for <span class="text-danger" id="studenttogereport"></span></h5> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       <form method="POST" action="#" id="generalreportform" enctype="multipart/form-data">
        <!-- <input type="number" name="studentid" id="studentid" hidden> -->
            <div class="table-responsive">
            <table class="table">
                <thead class="w3-green">
                <tr>
                    <th scope="col">Select (Report)</th>
                    <th scope="col">Student</th>
                    <th scope="col">Report</th>
                </tr>
            </thead>
                <tbody id="genreporttable">
                    
                </tbody>
            </table>
            </div>
        <input type="submit" value="SAVE REPORT" id="submitgeneralreportbtn" class="form-control btn btn-sm btn-rounded-0 w3-green d-none">
       </form>
        </div>
    </div>
    </div>
</div>
<!---Student general report modal end--->

<div class="row justify-content-center align-item-center">
    <div class="col-lg-10 col-md-10 col-sm-12">
        <form action="#" id="selectclassesform" class="p-2" method="POST" enctype="multipart/form-data">
           <div class="form-group mb-2">
            <label><h6 class="text-info">SELECT CLASS TO RETRIEVE STUDENTS</h6></label>
            <select name="studentsclass" id="studentsclass" class="form-control">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    @if ($class['stream'] == NULL)
                        <option value="{{ $class['id'] }}">{{ $class['class'] }}</option>
                    @else
                        <option value="{{ $class['id'] }}">{{ $class['class'] }} {{ $class['stream'] }}</option>
                    @endif
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
           </div> 

           <input type="submit" value="SELECT STUDENTS" id="submitclassbtn" class="form-control btn btn-sm btn-rounded-0 w3-green">
        </form>

        <hr>
        <div id="actionbtns" class="mb-2">
            <button id="subjectsreporting" class="btn btn-sm btn-danger m-1 float-end">Subjects Report</button>
            <button id="overallreporting" class="btn btn-sm btn-success m-1 float-end">Overall Report</button>
        </div> 
        <div class="table-responsive">
        <table id="studentstable" class="table">
            <thead class="w3-green">
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Adm/UPI No.</th>
                <th scope="col">Name</th>
            </tr>
        </thead>
        <tbody id="studentstablebody">
            
        </tbody>
        </table>
        </div>

    </div>
</div>
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
function preview(){
    chosenprof.src=URL.createObjectURL(event.target.files[0]);
}
</script>

<script>
$(document).ready(function(){
    //set csrf
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        //Select Students per class
        $("#selectclassesform").submit(function(e){
            e.preventDefault();
            $('#regresponse').addClass('d-none');
            $('#submitclassbtn').val('PLEASE WAIT...');

            var cid = $("#studentsclass").val();

            $.ajax({
                method: 'GET',
                url: `getstudents/${cid}`,
                contentType: false,
                processData: false,
                //data: formData,
               //dataType: 'json',
                success: function(res){
                    $('#submitclassbtn').val('SELECT STUDENTS');
                    if (res.students.length == 0) {
                        $('#studentstablebody').html('<h5 class="text-center text-danger">No students found for this class</h5>');
                    } else {
                         $('#studentstablebody').html('');
                         $.each(res.students, function(key,item){
                        $('#studentstablebody').append('<tr>\
                            <td><input value="'+item.id+'" subslearns="'+item.suborlearningpaths+'" subids="'+item.subids+'" stuname="'+item.Fname+' '+item.Lname+'" type="checkbox" class="checkboxid" name="studentcheckbox" id="studentcheckbox"></td>\
                            <td>'+(item.AdmissionNo == null ? item.UPI : item.AdmissionNo)+'</td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                        </tr>');
                    });  

                    $("#studentstable").DataTable().fnDestroy()

                        $('#studentstable').DataTable({
                            ordering: false,
                            paging: false,
                            searching: true
                         });

                    }
               }
            });
        });
        
    //Submit Subject Reporting 
    $("#subjectsreportform").submit(function(e){
            e.preventDefault();
            $('#submitsubjectreportbtn').val('PLEASE WAIT...');
            var sid = "{{ session()->get('schooldetails.id') }}";
            var formData = new FormData($('#subjectsreportform')[0]);
            formData.append('sid',sid);

            $.ajax({
                method: 'POST',
                url: '/savesubjectreport',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                    $('#submitsubjectreportbtn').val('SAVE REPORT');
                    //console.log(res); 
                    
                    if (res.status == 400) {
                        swal({
                            icon: "warning",
                            text: "You must select at least one subject to produce a report",
                            button: "Close",
                        }); 
                    } else if (res.status == 401) {
                        swal({
                            icon: "warning",
                            text: `${res.messages}`,
                            button: "Close",
                        }); 
                    } else if (res.status == 200) {
                        $("#studentsubjectreportModal").modal('hide');
                        
                        swal({
                            className: 'green-bg',
                            icon: "success",
                            text: `${res.messages}`,
                            button: "Close",
                        });
                    }
               }
            })
        });

    //Submit General Reporting 
    $("#generalreportform").submit(function(e){
            e.preventDefault();
            $('#submitgeneralreportbtn').val('PLEASE WAIT...');
            var sid = "{{ session()->get('schooldetails.id') }}";

            var formData = new FormData($('#generalreportform')[0]);
            formData.append('sid',sid);

            $.ajax({
                method: 'POST',
                url: '/savegeneralreport',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                    $('#submitgeneralreportbtn').val('SAVE REPORT');
                    
                    if (res.status == 400) {
                        swal({
                            icon: "warning",
                            text: "You must select at least one student to produce a report",
                            button: "Close",
                        }); 
                    } else if (res.status == 401) {
                        swal({
                            icon: "warning",
                            text: `${res.messages}`,
                            button: "Close",
                        }); 
                    } else if (res.status == 200) {
                        //$("#studentsubjectreportModal").modal('hide');
                        $("#studentgeneralreportModal").modal("hide");
                        
                        swal({
                            className: 'green-bg',
                            icon: "success",
                            text: `${res.messages}`,
                            button: "Close",
                        });
                    }
               }
            })
        });
        
    //Check on general reporting
    $(document).on('click', '#overallreporting',function(e){
         e.preventDefault();
         var ids = [];
         var stunames = [];
        // var sublearns = [];

         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val();
            stunames[i] = $(this).attr('stuname');
        })

        if (ids.length < 1) {
            alert('You must select a Student(s) to report')
        } else {
            $("#genreporttable").html('');
            $("#submitgeneralreportbtn").removeClass('d-none');

            for (let i = 0; i < ids.length; i++) {
                    //const element = subids[i];
                var html = "";
                html += '<tr>';
                html += '<td><input value="'+ids[i]+'" type="checkbox" name="genreportcheckbox[]" id="genreportcheckbox" checked></td>';
                html += '<td><input stuid="'+ids[i]+'" value="'+stunames[i]+'" type="text" class="form-control" name="generalreportname[]" id="generalreportname" readonly></td>';
                html += '<td><textarea stuid="'+ids[i]+'" name="thegeneralreport[]" id="thegeneralreport" cols="30" rows="10" class="form-control"></textarea></td>';
                html += '</tr>';
                html += '<hr>';

                $("#genreporttable").append(html);
            }

            $("#studentgeneralreportModal").modal("show");
        }
        
     })

    //Check on subjects reporting
    $(document).on('click', '#subjectsreporting',function(e){
         e.preventDefault();
         var ids = [];
         var subids = [];
         var sublearns = [];
         var name = [];

         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val();
            subids[i] = $(this).attr('subids');
            sublearns[i] = $(this).attr('subslearns');
            name[i] = $(this).attr('stuname');
        })

        if (ids.length < 1) {
            alert('You must select a Student(s) to report');
        } else if (ids.length > 1) {
            alert('You must select only one student to give subject report')
        } else {
            $("#studenttosubreport").text(name);
            $("#studentid").val(ids);

            if (subids[0] == "null") {
                $("#submitsubjectreportbtn").addClass('d-none');
                $("#subreporttable").html('<h6 class="text-center text-danger">The students has not been enrolled in any subject.</h6>');
            } else {
                $("#subreporttable").html('');
                $("#submitsubjectreportbtn").removeClass('d-none');

                for (let i = 0; i < subids[0].split(',').length; i++) {
                    //const element = subids[i];
                    var html = "";
                    html += '<tr>';
                    html += '<td><input value="'+subids[0].split(',')[i]+'" type="checkbox" class="" name="subjectcheckbox[]" id="subjectcheckbox"></td>';
                    html += '<td><input subjectid="'+subids[0].split(',')[i]+'" value="'+sublearns[0].split(',')[i]+'" type="text" class="form-control" name="subjecttobereported[]" id="subjecttobereported" readonly disabled></td>';
                    html += '<td><textarea subjectid="'+subids[0].split(',')[i]+'" name="subjectreport[]" id="subjectreport" cols="30" rows="10" class="form-control" disabled></textarea></td>';
                    html += '</tr>';
                    html += '<hr>';

                    $("#subreporttable").append(html);
                }
            }

            $("#studentsubjectreportModal").modal('show');
        }
        
     })

     //Work On Removing Subjects
     $(document).on('change','#subjectcheckbox',function(e){
            var selectedbox = $(this).val();

            $('#subjectsreportform').find(`input[subjectid='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                //$(this).toggleClass('bg-danger')
            })

            $('#subjectsreportform').find(`textarea[subjectid='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                //$(this).toggleClass('bg-danger')
            })
        })

    //Work On Removing Students
    $(document).on('change','#genreportcheckbox',function(e){
            var selectedbox = $(this).val();

            $('#generalreportform').find(`input[stuid='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                //$(this).toggleClass('bg-danger')
            })

            $('#generalreportform').find(`textarea[stuid='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                //$(this).toggleClass('bg-danger')
            })
    })
})
</script>
@endsection