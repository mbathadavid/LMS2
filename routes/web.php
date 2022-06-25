<?php
use App\Http\Controllers\{StudentController,AdminController,};
use App\Http\Controllers\SchoolDataController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\FinalGradeController;
use App\Http\Controllers\ResultThreadController;
use App\Http\Controllers\OverallGradeSystemController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RegrequestController;
use App\Http\Controllers\FeestructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
}); */

/*Admin Routes start*/
Route::get('/',[AdminController::class, 'landingpage']);
 Route::get('/adminlogin',[AdminController::class, 'index']);
 Route::get('/adminregister',[AdminController::class, 'register'])->name('adminregister');
 Route::get('/adminresetpass',[AdminController::class, 'resetpass']);
 Route::get('/resetpass',[AdminController::class, 'newpassreset']);
 Route::get('/admindashboard',[AdminController::class, 'dashboard'])->name('admindashboard');
 Route::get('/adminprofile',[AdminController::class, 'profile'])->name('adminprofile');
 Route::get('/students',[AdminController::class, 'students'])->name('students');
 Route::get('/teachers',[AdminController::class, 'teachers'])->name('teachers');
 Route::get('/parents',[AdminController::class, 'parents'])->name('parents');
 Route::get('/staff',[AdminController::class, 'staff'])->name('staff');
 Route::get('/subjects',[AdminController::class, 'subjects'])->name('subjects');
 Route::get('/clubs',[AdminController::class, 'clubs'])->name('clubs');
 Route::get('/classes',[AdminController::class, 'classes'])->name('classes');
 Route::get('/departments',[AdminController::class, 'departments'])->name('departments');
 Route::get('/expenses',[AdminController::class, 'expenses'])->name('expenses');
 Route::get('/feestructure',[AdminController::class, 'feeStructure']);
 Route::get('/feecollection',[AdminController::class, 'feeCollection']);
 Route::get('/financereport',[AdminController::class, 'financialReport']);
 Route::get('/procurements',[AdminController::class, 'procurements'])->name('procurements');
 Route::get('/suppliers',[AdminController::class, 'suppliers'])->name('suppliers');
 Route::get('/library',[AdminController::class,'library']);
 Route::get('/books',[AdminController::class,'books']);
 Route::get('/terms',[AdminController::class,'terms']);
 Route::get('/currentterm',[AdminController::class, 'currentTerm']);
 Route::post('/register',[AdminController::class, 'saveAdmin'])->name('admin.register');
 Route::post('/adminlogin',[AdminController::class, 'loginAdmin'])->name('admin.login');
 Route::get('/adminlogout',[AdminController::class, 'logoutAdmin'])->name('admin.logout');
 Route::get('/examinations',[AdminController::class, 'examinations']);
 Route::get('/finalresults',[AdminController::class, 'finalresults']);
 Route::get('/gradingsystem',[AdminController::class, 'gradingsystem']);
 Route::get('/classresults/{examid}/{classid}',[AdminController::class,'getClassCompResults']);
 /*Admin Routes end*/

/*Fee structure modelling start*/
Route::post('/registerfeestructure',[FeestructureController::class, 'createFeeStructure']);
Route::get('/fetchfeestructures/{sid}',[FeestructureController::class, 'fetchFeestructures']);
/*Fee structure modelling end*/


 /*School Details start*/
Route::get('/schoolreg',[SchoolDataController::class, 'index']);
Route::post('/schoolreg',[SchoolDataController::class, 'saveSchool'])->name('school.register');
/*School Details end*/

/* Messages and Register Request Start */
Route::post('/regrequest',[RegrequestController::class, 'registerrequest'])->name('reg.req');
Route::post('/regmessage',[MessagesController::class, 'regmessage']);
/* Messages and Register Request End */

/**class routes start*/
Route::post('/registerclass',[ClassesController::class,'saveclass'])->name('class.register');
Route::get('/fetchclasses/{sid}',[ClassesController::class,'fetchclasses'])->name('class.fetch');
Route::post('/editclass',[ClassesController::class,'editClass'])->name('class.edit');
Route::post('/setterm',[ClassesController::class,'setterm'])->name('class.currentterm');
Route::get('/deleteclass/{id}',[ClassesController::class,'deleteClasses']);
Route::get('/getclass/{id}',[ClassesController::class,'getClass']);
//Route::get('/classresults/{id}',[ClassesController::class,'getClass']);
/**class routes end */

/*Teacher routes */
Route::post('/registerteacher',[TeacherController::class,'saveTeacher'])->name('teacher.register');
Route::post('/registersurpportstaff',[TeacherController::class,'saveSupportStaff'])->name('staff.register');
Route::post('/editteacher',[TeacherController::class,'editTeacher'])->name('teacher.edit');
Route::get('/fetchteachers/{sid}/{uid}/{stype}',[TeacherController::class,'fetchteachers'])->name('teacher.fetch');
Route::get('/teachersexcelimport',[TeacherController::class,'excelimportview']);
Route::post('/importteachers',[TeacherController::class,'importTeachers'])->name('teacher.import');
Route::post('/assignpriviledges',[TeacherController::class,'assignpriviledges']);
Route::get('/downloadteachers',[TeacherController::class,'exportTeachers']);
Route::get('/getteacher/{id}',[TeacherController::class,'getTeacher']);
Route::get('/deleteteacher/{id}',[TeacherController::class,'deleteTeacher']);
Route::get('/deactivateteacher/{id}',[TeacherController::class,'deactivateTeacher']);
Route::get('/activateteacher/{id}',[TeacherController::class,'activateTeacher']);
Route::get('/downloadteacherstemplate',[TeacherController::class,'teachersImportTemplate']);
/*Teacher routes */

/***Student Routes */
//Route::get('/',[StudentController::class, 'index']);
Route::post('/registerstudent',[StudentController::class, 'registerStudent'])->name('student.register');
Route::post('/editstudent',[StudentController::class, 'editStudent'])->name('student.edit');
Route::get('/fetchstudents/{sid}',[StudentController::class, 'fetchStudents']);
Route::get('/filterStudents/{filter}/{sid}',[StudentController::class, 'filterStudents'])->name('filter.students');
Route::get('/excelstudents',[StudentController::class, 'excelStudents']);
Route::get('/deletestudent/{id}',[StudentController::class, 'deleteStudents']);
Route::get('/clearstudent/{id}',[StudentController::class, 'clearStudents']);
Route::get('/deactivatestudent/{id}',[StudentController::class, 'deactivateStudents']);
Route::get('/activatestudent/{id}',[StudentController::class, 'activateStudents']);
Route::get('/getstudent/{id}',[StudentController::class, 'getStudent']);
Route::get('/promotestudent/{id}/{nextclass}',[StudentController::class, 'promoteStudents']);
Route::get('/downloadstudents',[StudentController::class, 'produceStudentsExcel']);
/**Student routes end */

/**Subjects Routes*/
Route::post('/registersubject',[SubjectController::class, 'saveSubject'])->name('subject.register');
Route::post('/updatesubject',[SubjectController::class, 'updateSubject'])->name('subject.update');
Route::get('/fetchsubjects/{sid}',[SubjectController::class, 'fetchSubjects'])->name('subject.fetch');
Route::get('/deletesubject/{sid}',[SubjectController::class, 'deleteSubject']);
Route::get('/subdetails/{sid}',[SubjectController::class, 'subDetails']);
/**SubjectsRoutes */

/**Grading routes */
Route::post('/registerGrade',[GradeController::class, 'registerGrade'])->name('grade.register');
/**Grading routes end */

/**Parents management routes */
Route::post('/registerParent',[GuardianController::class, 'registerParent'])->name('guardian.register');
Route::post('/editParent',[GuardianController::class, 'editParent'])->name('guardian.edit');
Route::get('/fetchparents/{sid}',[GuardianController::class, 'fetchParents'])->name('parent.fetch');
Route::get('/getparent/{id}',[GuardianController::class, 'fetchParent']);
Route::get('/deactivateparent/{id}',[GuardianController::class, 'deactivateParent']);
Route::get('/activateparent/{id}',[GuardianController::class, 'activateParent']);
Route::get('/deleteparent/{id}',[GuardianController::class, 'deleteParent']);
Route::get('/getparentspdf',[GuardianController::class, 'parentsPDF']);
Route::get('/downloadtranscript',[GuardianController::class, 'downloadTranscript']);
/**Parents management routes end */  

/**Library management */
Route::post('/regLibrarian',[LibrarianController::class, 'addNewLibarian'])->name('librian.register');
Route::get('/fetchlibarians',[LibrarianController::class, 'fetchLibrarians']);
Route::post('/registerbook',[BookController::class, 'registerBook']);
Route::post('/updatebook',[BookController::class, 'updateBook']);
Route::get('/fetchbooks/{sid}',[BookController::class, 'fetchBooks']);
Route::get('/getBook/{id}',[BookController::class, 'getBookDetails']);
Route::post('/issuebook',[BookController::class, 'issueBook']);
Route::get('/collectbook/{ids}',[BookController::class, 'collectBook']);
Route::get('/deletebook/{id}',[BookController::class, 'deleteBook']);
/**Library management End */

/**Terms Handling */
Route::post('/addterm',[TermController::class, 'addTerm']);
Route::get('/fetchterms',[TermController::class, 'fetchTerms']);
Route::get('/fetchterm/{class}',[TermController::class, 'fetchTerm']);
Route::post('/updatecurrentterm',[TermController::class, 'updateTerm']);
/**Terms Handling end */

/**Examination Routes */
Route::post('/registerexam',[ExamController::class, 'registerExam'])->name('exam.register');
Route::post('/editexam',[ExamController::class, 'editExam'])->name('exam.edit');
Route::get('/fetchexams',[ExamController::class, 'fetchExams']);
Route::get('/deleteexam/{id}',[ExamController::class, 'deleteExams']);
Route::get('/getExam/{id}',[ExamController::class, 'getExam']);
/**Examination Routes End */
/**Marks handling routes */
Route::post('/addmarks',[MarkController::class, 'addMarks']);
Route::post('/updatemarks',[MarkController::class, 'updateMarks']);
Route::post('/checkmarks',[MarkController::class, 'checkMarks']);
Route::get('/checkcurrentterm/{classval}',[MarkController::class, 'checkTerm']);
Route::get('/fetchmarks/{exam}/{classid}/{sub}',[MarkController::class, 'fetchMarks']);
/**Marks handling routes end*/
/**Auto Results Computation */
Route::get('/autoresults',[AdminController::class, 'autoresults']);
/**Auto Results Computation End */

/**Final Grade */
Route::post('/insfinsubres',[FinalGradeController::class, 'insertResults']);
Route::post('/fetchfinalgrades',[FinalGradeController::class, 'fetchGrades']);
Route::get('/fetchsubgrades/{cid}/{subid}',[FinalGradeController::class, 'fetchSubGrades']);
/**Final Grade */

/**Examination Threads */
Route::get('/examresthread',[AdminController::class, 'resultThread']);
Route::get('/fetchthreads',[ResultThreadController::class, 'resultThreads']);
Route::post('/registerthread',[ResultThreadController::class, 'registerThread']);
/**Examination Threads */

// Overall Grading system start
Route::post('/addoverallgrading',[OverallGradeSystemController::class, 'registeroverallgrading']);
Route::get('/fetchOverallgrading/{cid}',[OverallGradeSystemController::class, 'fetchFinalResult']);
// Overall Grading system start