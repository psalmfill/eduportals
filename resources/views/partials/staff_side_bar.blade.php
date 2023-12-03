 <nav class="sidebar sidebar-offcanvas " id="sidebar">
     {{-- {{ dd(in_array(Route::currentRouteName(), ['staff.index', 'staff.create', 'staff.assign_classes', 'staff.assign_subjects']) ? 'active' : '') }} --}}
     <ul class="nav">
         <li class="nav-item">
             <div class="d-flex sidebar-profile">
                 <div class="sidebar-profile-image">

                     <img src="{{ user()->avatar ?? 'https://placehold.it/200x150' }}" alt="image">
                     <span class="sidebar-status-indicator"></span>
                 </div>
                 <div class="sidebar-profile-name">
                     <p class="sidebar-name">
                         {{ user()->first_name }} {{ user()->last_name }}
                     </p>
                     <p class="sidebar-designation">
                         Welcome
                     </p>
                 </div>
             </div>
             <p class="sidebar-menu-title">Dashboard menu</p>
         </li>
         <li class="nav-item">
             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.dashboard']) ? 'active' : '' }}"
                 href="{{ route('staff.dashboard') }}">
                 <i class="typcn typcn-device-desktop menu-icon"></i>
                 <span class="menu-title">Dashboard</span>
             </a>
         </li>
         @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
             <li
                 class="nav-item {{ in_array(Route::currentRouteName(), ['staff.index', 'staff.create', 'staff.assign_classes', 'staff.assign_subjects']) ? 'active' : '' }}">
                 <a class="nav-link" data-toggle="collapse" href="#staff-basic" aria-expanded="false"
                     aria-controls="staff-basic">
                     <i class="mdi mdi-folder-account menu-icon"></i>
                     <span class="menu-title">Staff</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse  {{ in_array(Route::currentRouteName(), ['staff.index', 'staff.create', 'staff.assign_classes', 'staff.assign_subjects']) ? 'show' : '' }}"
                     id="staff-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.index']) ? 'active' : '' }}"
                                 href="{{ route('staff.index') }}">
                                 <span class="title">All Staff</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.create']) ? 'active' : '' }}"
                                 href="{{ route('staff.create') }}">
                                 <span class="title">New Staff</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.assign_classes']) ? 'active' : '' }}"
                                 href="{{ route('staff.assign_classes') }}">
                                 <span class="title">Assign Class</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.assign_subjects']) ? 'active' : '' }}"
                                 href="{{ route('staff.assign_subjects') }}">
                                 <span class="title">Assign Subject</span>
                             </a>
                         </li>
                         {{-- <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.create') }}">
                                 <span class="title">Designations</span>
                             </a>
                         </li> --}}
                     </ul>
                 </div>
             </li>
         @endif
         <li class="nav-item">
             <a class="nav-link {{ in_array(Route::currentRouteName(), [
                 'students.index',
                 'students.create',
                 'students.promotion',
                 'students.attendance',
                 'students.attendance.view',
                 'staff.students.alumni',
             ])
                 ? 'active'
                 : '' }}"
                 data-toggle="collapse" href="#student-basic" aria-expanded="false" aria-controls="student-basic">
                 <i class="mdi mdi-folder-account menu-icon"></i>
                 <span class="menu-title">Students</span>
                 <i class="typcn typcn-chevron-right menu-arrow"></i>
             </a>
             <div class="collapse {{ in_array(Route::currentRouteName(), [
                 'students.index',
                 'students.create',
                 'students.promotion',
                 'students.attendance',
                 'students.attendance.view',
                 'staff.students.alumni',
             ])
                 ? 'show'
                 : '' }}"
                 id="student-basic">

                 <ul class="nav flex-column sub-menu">

                     @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['students.index']) ? 'active' : '' }}"
                                 href="{{ route('students.index') }}">
                                 <span class="title">All Students</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['students.create']) ? 'active' : '' }}"
                                 href="{{ route('students.create') }}">
                                 <span class="title">Admit Student</span>
                             </a>
                         </li>
                     @endif
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['students.promotion']) ? 'active' : '' }}"
                             href="{{ route('students.promotion') }}">
                             <span class="title">Promote Students</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['students.attendance']) ? 'active' : '' }}"
                             href="{{ route('students.attendance') }}">
                             <span class="title">Take Attendances</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['students.attendance.view']) ? 'active' : '' }}"
                             href="{{ route('students.attendance.view') }}">
                             <span class="title">View Attendances</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.students.alumni']) ? 'active' : '' }}"
                             href="{{ route('staff.students.alumni') }}">
                             <span class="title">Alumni </span>
                         </a>
                     </li>
                     {{-- <li class="nav-item">
                         <a class="nav-link" href="{{ route('staff.students.alumni') }}">
                             <span class="title">Transfer </span>
                         </a>
                     </li> --}}
                 </ul>
             </div>
         </li>
         @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Route::currentRouteName(), ['section.index', 'classes.index', 'classes.subjects']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#classes-basic" aria-expanded="false" aria-controls="classes-basic">
                     <i class="mdi mdi-hospital-building menu-icon"></i>
                     <span class="menu-title">Classes</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse {{ in_array(Route::currentRouteName(), ['section.index', 'classes.index', 'classes.subjects']) ? 'show' : '' }}"
                     id="classes-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link{{ in_array(Route::currentRouteName(), ['section.index']) ? 'active' : '' }}"
                                 href="{{ route('sections.index') }}">
                                 <span class="title">All Sections</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['classes.index']) ? 'active' : '' }}"
                                 href="{{ route('classes.index') }}">
                                 <span class="title">All Classes</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['classes.subjects']) ? 'active' : '' }}"
                                 href="{{ route('classes.subjects') }}">
                                 <span class="title">Assign Subjects</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Route::currentRouteName(), ['subjects.index']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#subjects-basic" aria-expanded="false"
                     aria-controls="subjects-basic">
                     <i class="mdi mdi-library-books menu-icon"></i>
                     <span class="menu-title">Subjects</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse  {{ in_array(Route::currentRouteName(), ['subjects.index']) ? 'show' : '' }}"
                     id="subjects-basic">
                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link  {{ in_array(Route::currentRouteName(), ['subjects.index']) ? 'active' : '' }}"
                                 href="{{ route('subjects.index') }}">
                                 <span class="title">All Subjects</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Route::currentRouteName(), ['terms.index']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#terms-basic" aria-expanded="false" aria-controls="terms-basic">
                     <i class="typcn typcn-briefcase menu-icon"></i>
                     <span class="menu-title">Terms</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse {{ in_array(Route::currentRouteName(), ['terms.index']) ? 'show' : '' }}"
                     id="terms-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['terms.index']) ? 'active' : '' }}"
                                 href="{{ route('terms.index') }}">
                                 <span class="title">All Terms</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
         @endif

         <li class="nav-item">
             <a class="nav-link {{ in_array(Route::currentRouteName(), ['learning-resoures.index', 'assignments.index']) ? 'active' : '' }}"
                 data-toggle="collapse" href="#academics-basic" aria-expanded="false"
                 aria-controls="academics-basic">
                 <i class="mdi mdi-library-books menu-icon"></i>
                 <span class="menu-title">Academics</span>
                 <i class="typcn typcn-chevron-right menu-arrow"></i>
             </a>
             <div class="collapse {{ in_array(Route::currentRouteName(), ['learning-resoures.index', 'assignments.index']) ? 'show' : '' }}"
                 id="academics-basic">

                 <ul class="nav flex-column sub-menu">
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['learning-resoures.index']) ? 'active' : '' }}"
                             href="{{ route('learning-resources.index') }}">
                             <span class="title">Learning Resources</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['assignments.index']) ? 'active' : '' }}"
                             href="{{ route('assignments.index') }}">
                             <span class="title">Assignments</span>
                         </a>
                     </li>
                 </ul>
             </div>
         </li>
         <li class="nav-item">
             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.cbt', 'staff.results.view', 'staff.broadsheet-results.view', 'exams-setup.index', 'staff.examination.pychomotor', 'staff.examination.affectiveTrait', 'staff.comment_result.setup', 'staff.comment_result.grades', 'grades.index', 'staff.result_remarks', 'staff.marks_register', 'staff.examination.psychomotor.result', 'staff.examination.affectiveTrait.result', 'staff.comment_result']) ? 'active' : '' }}"
                 data-toggle="collapse" href="#examination-basic" aria-expanded="false"
                 aria-controls="examination-basic">
                 <i class="mdi mdi-table-edit menu-icon"></i>
                 <span class="menu-title">Examination</span>
                 <i class="typcn typcn-chevron-right menu-arrow"></i>
             </a>
             <div class="collapse  {{ in_array(Route::currentRouteName(), ['staff.cbt', 'staff.results.view', 'staff.broadsheet-results.view', 'exams-setup.index', 'staff.examination.pychomotor', 'staff.examination.affectiveTrait', 'staff.comment_result.setup', 'staff.comment_result.grades', 'grades.index', 'staff.result_remarks', 'staff.marks_register', 'staff.examination.psychomotor.result', 'staff.examination.affectiveTrait.result', 'staff.comment_result']) ? 'show' : '' }}"
                 id="examination-basic">

                 <ul class="nav flex-column sub-menu">

                     <li class="nav-item">
                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.cbt']) ? 'active' : '' }}"
                             data-toggle="collapse" href="#cbt-basic" aria-expanded="false"
                             aria-controls="cbt-basic">
                             <i class="mdi mdi-laptop menu-icon"></i>
                             <span class="menu-title">CBT</span>
                             <i class="typcn typcn-chevron-right menu-arrow"></i>
                         </a>
                         <div class="collapse  {{ in_array(Route::currentRouteName(), ['staff.cbt']) ? 'show' : '' }}"
                             id="cbt-basic">
                             <ul class="nav flex-column sub-menu">
                                 <li class="nav-item">
                                     <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.cbt']) ? 'active' : '' }}"
                                         href="{{ route('staff.cbt') }}">
                                         <span class="title">CBT</span>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.results.view', 'staff.broadsheet-results.view']) ? 'active' : '' }}"
                             data-toggle="collapse" href="#view-results-basic" aria-expanded="false"
                             aria-controls="view-results-basic">
                             <i class="typcn typcn-briefcase menu-icon"></i>
                             <span class="menu-title">View Results</span>
                             <i class="typcn typcn-chevron-right menu-arrow"></i>
                         </a>
                         <div class="collapse  {{ in_array(Route::currentRouteName(), ['staff.results.view', 'staff.broadsheet-results.view']) ? 'show' : '' }}"
                             id="view-results-basic">

                             <ul class="nav flex-column sub-menu">

                                 <li class="nav-item">
                                     <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.results.view']) ? 'active' : '' }}"
                                         href="{{ route('staff.results.view') }}">
                                         <span class="title">Class Results</span>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.broadsheet-results.view']) ? 'active' : '' }}"
                                         href="{{ route('staff.broadsheet-results.view') }}">
                                         <span class="title">Class Broadsheet</span>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </li>
                     @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                         <li class="nav-item">
                             <a class="nav-link  {{ in_array(Route::currentRouteName(), ['exams-setup.index', 'staff.examination.pychomotor', 'staff.examination.affectiveTrait', 'staff.comment_result.setup', 'staff.comment_result.grades', 'grades.index', 'staff.result_remarks']) ? 'active' : '' }}"
                                 data-toggle="collapse" href="#setup-basic" aria-expanded="false"
                                 aria-controls="setup-basic">
                                 <i class="typcn typcn-briefcase menu-icon"></i>
                                 <span class="menu-title">Setup</span>
                                 <i class="typcn typcn-chevron-right menu-arrow"></i>
                             </a>
                             <div class="collapse {{ in_array(Route::currentRouteName(), ['exams-setup.index', 'staff.examination.pychomotor', 'staff.examination.affectiveTrait', 'staff.comment_result.setup', 'staff.comment_result.grades', 'grades.index', 'staff.result_remarks']) ? 'show' : '' }}"
                                 id="setup-basic">

                                 <ul class="nav flex-column sub-menu">

                                     <li class="nav-item">
                                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['exams-setup.index']) ? 'active' : '' }}"
                                             href="{{ route('exams-setup.index') }}">
                                             <span class="title">Exams</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.examination.pychomotor']) ? 'active' : '' }}"
                                             href="{{ route('staff.examination.psychomotor') }}">
                                             <span class="title">Psychomotors</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.examination.affectiveTrait']) ? 'active' : '' }}"
                                             href="{{ route('staff.examination.affectiveTrait') }}">
                                             <span class="title">Affective Trait</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.comment_result.setup']) ? 'active' : '' }}"
                                             href="{{ route('staff.comment_result.setup') }}">
                                             <span class="title">Comment Results</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.comment_result.grades']) ? 'active' : '' }}"
                                             href="{{ route('staff.comment_result.grades') }}">
                                             <span class="title">Comment Result Grades</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['grades.index']) ? 'active' : '' }}"
                                             href="{{ route('grades.index') }}">
                                             <span class="title">Grades</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.result_remarks']) ? 'active' : '' }}"
                                             href="{{ route('staff.result_remarks') }}">
                                             <span class="title">Result Remarks</span>
                                         </a>
                                     </li>
                                     {{-- <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.result_remarks') }}">
                                             <span class="title">Exams Schedule</span>
                                         </a>
                                     </li> --}}
                                 </ul>
                             </div>
                         </li>
                     @endif
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.marks_register']) ? 'active' : '' }}"
                             href="{{ route('staff.marks_register') }}">
                             <span class="title">Marks Register</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.examination.psychomotor.result']) ? 'active' : '' }}"
                             href="{{ route('staff.examination.psychomotor.result') }}">
                             <span class="title">Psycomotor Results</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.examination.affectiveTrait.result']) ? 'active' : '' }}"
                             href="{{ route('staff.examination.affectiveTrait.result') }}">
                             <span class="title">Affective Trait Results</span>
                         </a>
                     </li>
                     <li
                         class="nav-item {{ in_array(Route::currentRouteName(), ['staff.comment_result']) ? 'active' : '' }}">
                         <a class="nav-link" href="{{ route('staff.comment_result') }}">
                             <span class="title">Comment Results</span>
                         </a>
                     </li>
                 </ul>
             </div>
         </li>
         @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
             <li class="nav-item">
                 <a class="nav-link  {{ in_array(Route::currentRouteName(), ['staff.finances.transactions', 'staff.finances.fees', 'staff.finances.expenditures']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#finance-basic" aria-expanded="false"
                     aria-controls="finance-basic">
                     <i class="mdi mdi-cash menu-icon"></i>
                     <span class="menu-title">Finance Management</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse {{ in_array(Route::currentRouteName(), ['staff.finances.transactions', 'staff.finances.fees', 'staff.finances.expenditures']) ? 'show' : '' }}"
                     id="finance-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.finances.transactions']) ? 'active' : '' }}"
                                 href="{{ route('staff.finances.transactions') }}">
                                 <span class="title">Transactions</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.finances.fees']) ? 'active' : '' }}"
                                 href="{{ route('staff.finances.fees') }}">
                                 <span class="title">Fees</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.finances.expenditures']) ? 'active' : '' }}"
                                 href="{{ route('staff.finances.expenditures') }}">
                                 <span class="title">Expenditures</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.hostels']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#hostels-basic" aria-expanded="false"
                     aria-controls="hostels-basic">
                     <i class="mdi mdi-hotel menu-icon"></i>
                     <span class="menu-title">Hostels Management</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse {{ in_array(Route::currentRouteName(), ['staff.hostels']) ? 'show' : '' }}"
                     id="hostels-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.hostels']) ? 'active' : '' }}"
                                 href="{{ route('staff.hostels') }}">
                                 <span class="title">Hostels</span>
                             </a>
                         </li>
                         {{-- <li class="nav-item">
                             <a class="nav-link" href="{{ route('roles.index') }}">
                                 <span class="title">Assign Hostel</span>
                             </a>
                         </li> --}}
                     </ul>
                 </div>
             </li>
             {{-- <li class="nav-item">
                 <a class="nav-link" data-toggle="collapse" href="#cbt-basic" aria-expanded="false"
                     aria-controls="cbt-basic">
                     <i class="mdi mdi-phone menu-icon"></i>
                     <span class="menu-title">SMS & Emails</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="cbt-basic">
                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.cbt') }}">
                                 <span class="title">SMS</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.hostels') }}">
                                 <span class="title">Emails</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li> --}}
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Route::currentRouteName(), ['settings.index', 'roles.index']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#settings-basic" aria-expanded="false"
                     aria-controls="settings-basic">
                     <i class="mdi mdi-settings menu-icon"></i>
                     <span class="menu-title">Configuration</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse {{ in_array(Route::currentRouteName(), ['settings.index', 'roles.index']) ? 'show' : '' }}"
                     id="settings-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link{{ in_array(Route::currentRouteName(), ['settings.index']) ? 'active' : '' }}"
                                 href="{{ route('settings.index') }}">
                                 <span class="title">General Settings</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link{{ in_array(Route::currentRouteName(), ['roles.index']) ? 'active' : '' }}"
                                 href="{{ route('roles.index') }}">
                                 <span class="title">Role</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.pins.index', 'staff.pin.collections', 'staff.pins.collections.payments']) ? 'active' : '' }}"
                     data-toggle="collapse" href="#pins-basic" aria-expanded="false" aria-controls="pins-basic">
                     <i class="mdi mdi-folder-account menu-icon"></i>
                     <span class="menu-title">Pins</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse {{ in_array(Route::currentRouteName(), ['staff.pins.index', 'staff.pin.collections', 'staff.pins.collections.payments']) ? 'show' : '' }}"
                     id="pins-basic">
                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link{{ in_array(Route::currentRouteName(), ['staff.pins.index']) ? 'active' : '' }}"
                                 href="{{ route('staff.pins.index') }}">
                                 <span class="title">Buy Pins</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link{{ in_array(Route::currentRouteName(), ['staff.pin.collections']) ? 'active' : '' }}"
                                 href="{{ route('staff.pins.collections') }}">
                                 <span class="title">Collections</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ in_array(Route::currentRouteName(), ['staff.pins.collections.payments']) ? 'active' : '' }}"
                                 href="{{ route('staff.pins.collections.payments') }}">
                                 <span class="title">Payments</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
         @endif


         <li class="nav-item">
             <a class="nav-link {{ in_array(Route::currentRouteName(), ['account.setting']) ? 'active' : '' }}"
                 href="{{ route('account.setting') }}" aria-controls="cbt-basic">
                 <i class="mdi mdi-account menu-icon"></i>
                 <span class="menu-title">My Account</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="{{ route('staff.logout') }}">
                 <i class="mdi mdi-logout menu-icon"></i>
                 <span class="menu-title">Logout</span>
             </a>
         </li>
     </ul>

 </nav>
