<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('school-setup')
                <li class="nav-title">{{ 'Setup Menu' }}</li>
            @endcan
            @can('permission_access')
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}"
                        class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-unlock-alt nav-icon">

                        </i>
                        {{ trans('cruds.permission.title') }}
                    </a>
                </li>
            @endcan
            @can('role_access')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}"
                        class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-briefcase nav-icon">

                        </i>
                        {{ trans('cruds.role.title') }}
                    </a>
                </li>
            @endcan
            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index', ['role' => 0]) }}"
                        class="nav-link {{ (request()->is('admin/users') && request()->role == 0 && !request()->has('teacher') && !request()->has('student')) || (request()->is('admin/users/create') && !request()->has('teacher') && !request()->has('student')) || (request()->is('admin/users/*/edit') && !$user->roles->contains(3) && !$user->roles->contains(4)) ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        {{ trans('cruds.user.title') }}
                    </a>
                </li>
            @endcan
            @can('school-setup')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index', ['role' => 3]) }}"
                        class="nav-link {{ (request()->is('admin/users') && request()->role == 3) || (request()->is('admin/users/create') && request()->has('teacher')) || (request()->is('admin/users/*/edit') && $user->roles->contains(3)) ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        Teachers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index', ['role' => 4]) }}"
                        class="nav-link {{ (request()->is('admin/users') && request()->role == 4) || (request()->is('admin/users/create') && request()->has('student')) || (request()->is('admin/users/*/edit') && $user->roles->contains(4)) ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        Students
                    </a>
                </li>
            @endcan
            @can('course')
                <li class="nav-item">
                    <a href="{{ route('admin.course.index') }}"
                        class="nav-link {{ request()->is('admin/course/') || request()->is('admin/course/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-book-open nav-icon">

                        </i>
                        Course
                    </a>
                </li>
            @endcan

            @can('school-setup')
                <li class="nav-item">
                    <a href="{{ route('admin.scheduletemplate.index') }}"
                        class="nav-link {{ request()->is('admin/scheduletemplate') || request()->is('admin/scheduletemplate/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clock nav-icon">
                        </i>
                        Schedule Template
                    </a>
                </li>
            @endcan
            {{-- </ul>
                </li> --}}
            {{-- @endcan --}}
            @can('dlp-menu')
                <li class="nav-item">
                    <a href="{{ route('admin.dlp.index') }}"
                        class="nav-link {{ request()->is('admin/dlpreport') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-tv nav-icon">

                        </i>
                        {{ trans('DLP Dashboard') }}
                    </a>
                </li>
            @endcan
            @can('school_class_access')
                <li class="nav-item">
                    <a href="{{ route('admin.school-classes.index') }}"
                        class="nav-link {{ request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-school nav-icon">

                        </i>
                        {{ trans('cruds.schoolClass.title') }}
                    </a>
                </li>
            @endcan

            <li class="nav-title">{{ 'APP MENU' }}</li>



            @can('teacher-homework')
                <li class="nav-item">
                    <a href="{{ route('admin.homework.create') }}"
                        class="nav-link {{ request()->is('admin/homework/create/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        {{ trans('Create Assignment') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.homework.index') }}"
                        class="nav-link {{ request()->is('admin/homework') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        {{ trans('Assignment List') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.homework.completed') }}"
                        class="nav-link {{ request()->is('admin/homework/completed') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        {{ trans('Completed List') }}
                    </a>
                </li>
            @endcan

            @can('calling-backend')
                <li class="nav-item">
                    <a href="{{ route('admin.calling.dashboard', ['MC', '1']) }}"
                        class="nav-link {{ request()->is('admin/calling_dashboard/*/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        {{ trans(' Calling System') }}
                    </a>
                </li>
            @endcan
            @can('attendance')
                <li class="nav-item">
                    <a href="{{ route('admin.attendance.index') }}"
                        class="nav-link {{ request()->is('admin/attendance/*') || request()->is('admin/school-classes/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">

                        </i>
                        {{ trans('Attendance') }}
                    </a>
                </li>
            @endcan
            @can('exam_schedule')
                <li class="nav-item">
                    <a href="{{ route('admin.examschedule.create') }}"
                        class="nav-link {{ request()->is('admin/examschedule/*') || request()->is('admin/examschedule/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-calendar-check nav-icon">

                        </i>
                        {{ trans('Exam Schedule') }}
                    </a>
                </li>
            @endcan
            @can('elearning')
                <li class="nav-item">
                    <a href="{{ route('admin.elearning.create') }}"
                        class="nav-link {{ request()->is('admin/elearning/create') || request()->is('admin/elearning/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-graduation-cap nav-icon">

                        </i>
                        {{ trans('E-Learning') }}
                    </a>
                </li>
            @endcan
            @can('announcement')
                <li class="nav-item">
                    <a href="{{ route('admin.announcement.index') }}"
                        class="nav-link {{ request()->is('admin/announcement/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-bullhorn nav-icon">

                        </i>
                        {{ trans('News') }}
                    </a>
                </li>
            @endcan
            @can('feedback')
                <li class="nav-item">
                    <a href="{{ route('admin.feedback.index') }}"
                        class="nav-link {{ request()->is('admin/feedback/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-comment-dots nav-icon">

                        </i>
                        {{ trans('Feedback') }}
                    </a>
                </li>
            @endcan
            @can('notification')
                <li class="nav-item">
                    <a href="{{ route('admin.message.index') }}"
                        class="nav-link {{ request()->is('admin/notify/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-envelope nav-icon">
                        </i>
                        {{ trans('Notification') }}
                    </a>
                </li>
            @endcan
            @can('lesson_access')
                <li class="nav-item">
                    <a href={{ route('admin.events.index') }}
                        class="nav-link {{ request()->is('admin/timetable') || request()->is('admin/timetable/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clock nav-icon">
                        </i>
                        {{ trans('events') }}
                    </a>
                </li>
            @endcan
            @can('lesson_access')
                <li class="nav-item">
                    <a href={{ route('admin.gallary.index') }}
                        class="nav-link {{ request()->is('admin/timetable') || request()->is('admin/timetable/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clock nav-icon">
                        </i>
                        {{ trans('gallary') }}
                    </a>
                </li>
            @endcan
            @can('lesson_access')
                <li class="nav-item">
                    <a href="{{ route('admin.timetable.create') }}"
                        class="nav-link {{ request()->is('admin/timetable') || request()->is('admin/timetable/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clock nav-icon">

                        </i>
                        {{ trans('cruds.lesson.title') }}
                    </a>
                </li>
            @endcan
            <li class="nav-title">{{ 'System Menu' }}</li>
            <li class="nav-item">
                <a href="#" id='link_logout' class="nav-link" onclick="event.preventDefault();go_logout();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
