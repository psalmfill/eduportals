 <nav class="sidebar sidebar-offcanvas bg-dark" id="sidebar">
     <ul class="nav">
         <li class="nav-item">
             <div class="d-flex sidebar-profile">
                 <div class="sidebar-profile-image">

                     <img src="{{ user()->avatar ?? 'http://placehold.it/200x150' }}" alt="image">
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
             <a class="nav-link" href="{{ route('staff.dashboard') }}">
                 <i class="typcn typcn-device-desktop menu-icon"></i>
                 <span class="menu-title">Dashboard</span>
             </a>
         </li>
         @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
             <li class="nav-item">
                 <a class="nav-link" data-toggle="collapse" href="#staff-basic" aria-expanded="false"
                     aria-controls="staff-basic">
                     <i class="mdi mdi-folder-account menu-icon"></i>
                     <span class="menu-title">Staff</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="staff-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.index') }}">
                                 <span class="title">All Staff</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.create') }}">
                                 <span class="title">New Staff</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.assign_classes') }}">
                                 <span class="title">Assign Class</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.assign_subjects') }}">
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
             <a class="nav-link" data-toggle="collapse" href="#student-basic" aria-expanded="false"
                 aria-controls="student-basic">
                 <i class="mdi mdi-folder-account menu-icon"></i>
                 <span class="menu-title">Students</span>
                 <i class="typcn typcn-chevron-right menu-arrow"></i>
             </a>
             <div class="collapse" id="student-basic">

                 <ul class="nav flex-column sub-menu">

                     @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('students.index') }}">
                                 <span class="title">All Students</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('students.create') }}">
                                 <span class="title">Admit Student</span>
                             </a>
                         </li>
                     @endif
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('students.promotion') }}">
                             <span class="title">Promote Students</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('students.attendance') }}">
                             <span class="title">Take Attendances</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('students.attendance.view') }}">
                             <span class="title">View Attendances</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('staff.students.alumni') }}">
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
                 <a class="nav-link" data-toggle="collapse" href="#classes-basic" aria-expanded="false"
                     aria-controls="classes-basic">
                     <i class="mdi mdi-hospital-building menu-icon"></i>
                     <span class="menu-title">Classes</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="classes-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('sections.index') }}">
                                 <span class="title">All Sections</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('classes.index') }}">
                                 <span class="title">All Classes</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('classes.subjects') }}">
                                 <span class="title">Assign Subjects</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link" data-toggle="collapse" href="#subjects-basic" aria-expanded="false"
                     aria-controls="subjects-basic">
                     <i class="mdi mdi-library-books menu-icon"></i>
                     <span class="menu-title">Subjects</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="subjects-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('subjects.index') }}">
                                 <span class="title">All Subjects</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link" data-toggle="collapse" href="#terms-basic" aria-expanded="false"
                     aria-controls="terms-basic">
                     <i class="typcn typcn-briefcase menu-icon"></i>
                     <span class="menu-title">Terms</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="terms-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('terms.index') }}">
                                 <span class="title">All Terms</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
         @endif
         <li class="nav-item">
             <a class="nav-link" data-toggle="collapse" href="#examination-basic" aria-expanded="false"
                 aria-controls="examination-basic">
                 <i class="mdi mdi-table-edit menu-icon"></i>
                 <span class="menu-title">Examination</span>
                 <i class="typcn typcn-chevron-right menu-arrow"></i>
             </a>
             <div class="collapse" id="examination-basic">

                 <ul class="nav flex-column sub-menu">

                     <li class="nav-item">
                         <a class="nav-link" data-toggle="collapse" href="#cbt-basic" aria-expanded="false"
                             aria-controls="cbt-basic">
                             <i class="mdi mdi-laptop menu-icon"></i>
                             <span class="menu-title">CBT</span>
                             <i class="typcn typcn-chevron-right menu-arrow"></i>
                         </a>
                         <div class="collapse" id="cbt-basic">
                             <ul class="nav flex-column sub-menu">
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('staff.cbt') }}">
                                         <span class="title">CBT</span>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('staff.hostels') }}">
                                         <span class="title">Questions Setup</span>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link" data-toggle="collapse" href="#view-results-basic" aria-expanded="false"
                             aria-controls="view-results-basic">
                             <i class="typcn typcn-briefcase menu-icon"></i>
                             <span class="menu-title">View Results</span>
                             <i class="typcn typcn-chevron-right menu-arrow"></i>
                         </a>
                         <div class="collapse" id="view-results-basic">

                             <ul class="nav flex-column sub-menu">

                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('staff.results.view') }}">
                                         <span class="title">Class Results</span>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('staff.broadsheet-results.view') }}">
                                         <span class="title">Class Broadsheet</span>
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </li>
                     @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                         <li class="nav-item">
                             <a class="nav-link" data-toggle="collapse" href="#setup-basic" aria-expanded="false"
                                 aria-controls="setup-basic">
                                 <i class="typcn typcn-briefcase menu-icon"></i>
                                 <span class="menu-title">Setup</span>
                                 <i class="typcn typcn-chevron-right menu-arrow"></i>
                             </a>
                             <div class="collapse" id="setup-basic">

                                 <ul class="nav flex-column sub-menu">

                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('exams-setup.index') }}">
                                             <span class="title">Exams</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.examination.psychomotor') }}">
                                             <span class="title">Psychomotors</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.examination.affectiveTrait') }}">
                                             <span class="title">Affective Trait</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.comment_result.setup') }}">
                                             <span class="title">Comment Results</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.comment_result.grades') }}">
                                             <span class="title">Comment Result Grades</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('grades.index') }}">
                                             <span class="title">Result Remarks</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.result_remarks') }}">
                                             <span class="title">Result Remarks</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('staff.result_remarks') }}">
                                             <span class="title">Exams Schedule</span>
                                         </a>
                                     </li>
                                 </ul>
                             </div>
                         </li>
                     @endif
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('staff.marks_register') }}">
                             <span class="title">Marks Register</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('staff.examination.psychomotor.result') }}">
                             <span class="title">Psycomotor Results</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('staff.examination.affectiveTrait.result') }}">
                             <span class="title">Affective Trait Results</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('staff.comment_result') }}">
                             <span class="title">Comment Results</span>
                         </a>
                     </li>
                 </ul>
             </div>
         </li>
         @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
             <li class="nav-item">
                 <a class="nav-link" data-toggle="collapse" href="#finance-basic" aria-expanded="false"
                     aria-controls="finance-basic">
                     <i class="mdi mdi-cash menu-icon"></i>
                     <span class="menu-title">Finance Management</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="finance-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.finances.transactions') }}">
                                 <span class="title">Transactions</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.finances.fees') }}">
                                 <span class="title">Fees</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.finances.expenditures') }}">
                                 <span class="title">Expenditures</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item">
                 <a class="nav-link" data-toggle="collapse" href="#hostels-basic" aria-expanded="false"
                     aria-controls="hostels-basic">
                     <i class="mdi mdi-hotel menu-icon"></i>
                     <span class="menu-title">Hostels Management</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="hostels-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('staff.hostels') }}">
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
                 <a class="nav-link" data-toggle="collapse" href="#settings-basic" aria-expanded="false"
                     aria-controls="settings-basic">
                     <i class="mdi mdi-settings menu-icon"></i>
                     <span class="menu-title">Configuration</span>
                     <i class="typcn typcn-chevron-right menu-arrow"></i>
                 </a>
                 <div class="collapse" id="settings-basic">

                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('settings.index') }}">
                                 <span class="title">General Settings</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('roles.index') }}">
                                 <span class="title">Role</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
         @endif


         <li class="nav-item">
             <a class="nav-link" href="{{ route('account.setting') }}" aria-controls="cbt-basic">
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
