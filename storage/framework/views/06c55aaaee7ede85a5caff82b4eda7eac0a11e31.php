<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a href="<?php echo e(route('admin.home'), false); ?>" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    <?php echo e(trans('global.dashboard'), false); ?>

                </a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school-setup')): ?>
                <li class="nav-title"><?php echo e('Setup Menu', false); ?></li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.permissions.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-unlock-alt nav-icon">

                        </i>
                        <?php echo e(trans('cruds.permission.title'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.roles.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-briefcase nav-icon">

                        </i>
                        <?php echo e(trans('cruds.role.title'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.users.index', ['role' => 0]), false); ?>"
                        class="nav-link <?php echo e((request()->is('admin/users') && request()->role == 0 && !request()->has('teacher') && !request()->has('student')) || (request()->is('admin/users/create') && !request()->has('teacher') && !request()->has('student')) || (request()->is('admin/users/*/edit') && !$user->roles->contains(3) && !$user->roles->contains(4)) ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        <?php echo e(trans('cruds.user.title'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school-setup')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.users.index', ['role' => 3]), false); ?>"
                        class="nav-link <?php echo e((request()->is('admin/users') && request()->role == 3) || (request()->is('admin/users/create') && request()->has('teacher')) || (request()->is('admin/users/*/edit') && $user->roles->contains(3)) ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        Teachers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.users.index', ['role' => 4]), false); ?>"
                        class="nav-link <?php echo e((request()->is('admin/users') && request()->role == 4) || (request()->is('admin/users/create') && request()->has('student')) || (request()->is('admin/users/*/edit') && $user->roles->contains(4)) ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-user nav-icon">

                        </i>
                        Students
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.course.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/course/') || request()->is('admin/course/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-book-open nav-icon">

                        </i>
                        Course
                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school-setup')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.scheduletemplate.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/scheduletemplate') || request()->is('admin/scheduletemplate/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clock nav-icon">
                        </i>
                        Schedule Template
                    </a>
                </li>
            <?php endif; ?>
            
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dlp-menu')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.dlp.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/dlpreport') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-tv nav-icon">

                        </i>
                        <?php echo e(trans('DLP Dashboard'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.school-classes.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-school nav-icon">

                        </i>
                        <?php echo e(trans('cruds.schoolClass.title'), false); ?>

                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-title"><?php echo e('APP MENU', false); ?></li>



            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('teacher-homework')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.homework.create'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/homework/create/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        <?php echo e(trans('Create Assignment'), false); ?>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.homework.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/homework') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        <?php echo e(trans('Assignment List'), false); ?>

                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('admin.homework.completed'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/homework/completed') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        <?php echo e(trans('Completed List'), false); ?>

                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('calling-backend')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.calling.dashboard', ['MC', '1']), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/calling_dashboard/*/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">
                        </i>
                        <?php echo e(trans(' Calling System'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('attendance')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.attendance.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/attendance/*') || request()->is('admin/school-classes/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clipboard-list nav-icon">

                        </i>
                        <?php echo e(trans('Attendance'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exam_schedule')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.examschedule.create'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/examschedule/*') || request()->is('admin/examschedule/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-calendar-check nav-icon">

                        </i>
                        <?php echo e(trans('Exam Schedule'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('elearning')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.elearning.create'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/elearning/create') || request()->is('admin/elearning/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-graduation-cap nav-icon">

                        </i>
                        <?php echo e(trans('E-Learning'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('announcement')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.announcement.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/announcement/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-bullhorn nav-icon">

                        </i>
                        <?php echo e(trans('News'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('feedback')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.feedback.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/feedback/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-comment-dots nav-icon">

                        </i>
                        <?php echo e(trans('Feedback'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('notification')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.message.index'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/notify/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-envelope nav-icon">
                        </i>
                        <?php echo e(trans('Notification'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_access')): ?>
                <li class="nav-item">
                    <a href=<?php echo e(route('admin.events.index'), false); ?>

                        class="nav-link <?php echo e(request()->is('admin/timetable') || request()->is('admin/timetable/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clock nav-icon">
                        </i>
                        <?php echo e(trans('events'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_access')): ?>
                <li class="nav-item">
                    <a href=<?php echo e(route('admin.gallary.index'), false); ?>

                        class="nav-link <?php echo e(request()->is('admin/timetable') || request()->is('admin/timetable/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clock nav-icon">
                        </i>
                        <?php echo e(trans('gallary'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.timetable.create'), false); ?>"
                        class="nav-link <?php echo e(request()->is('admin/timetable') || request()->is('admin/timetable/*') ? 'active' : '', false); ?>">
                        <i class="fa-fw fas fa-clock nav-icon">

                        </i>
                        <?php echo e(trans('cruds.lesson.title'), false); ?>

                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-title"><?php echo e('System Menu', false); ?></li>
            <li class="nav-item">
                <a href="#" id='link_logout' class="nav-link" onclick="event.preventDefault();go_logout();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    <?php echo e(trans('global.logout'), false); ?>

                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<?php /**PATH D:\wrok_in_ics\web_backend\resources\views/partials/menu.blade.php ENDPATH**/ ?>