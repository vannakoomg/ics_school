<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="<?php echo e(route("admin.home")); ?>" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    <?php echo e(trans('global.dashboard')); ?>

                </a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        <?php echo e(trans('cruds.userManagement.title')); ?>

                    </a>
                    <ul class="nav-dropdown-items">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.permissions.index")); ?>" class="nav-link <?php echo e(request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.permission.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.roles.index")); ?>" class="nav-link <?php echo e(request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.role.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.users.index")); ?>" class="nav-link <?php echo e(request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.user.title')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.users.index")); ?>?role=3" class="nav-link <?php echo e(request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    Teachers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.users.index")); ?>?role=4" class="nav-link <?php echo e(request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    Students
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dlp-menu')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route("admin.dlp.index")); ?>" class="nav-link <?php echo e(request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : ''); ?>">
                        <i class="fa-fw fas fa-tv nav-icon">

                        </i>
                        <?php echo e(trans('DLP Dashboard')); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('school_class_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route("admin.school-classes.index")); ?>" class="nav-link <?php echo e(request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : ''); ?>">
                        <i class="fa-fw fas fa-school nav-icon">

                        </i>
                        <?php echo e(trans('cruds.schoolClass.title')); ?>

                    </a>
                </li>
            <?php endif; ?>
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('announcement')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route("admin.announcement.index")); ?>" class="nav-link <?php echo e(request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : ''); ?>">
                        <i class="fa-fw fas fa-bullhorn nav-icon">

                        </i>
                        <?php echo e(trans('Announcement')); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_access')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route("admin.lessons.index")); ?>" class="nav-link <?php echo e(request()->is('admin/lessons') || request()->is('admin/lessons/*') ? 'active' : ''); ?>">
                        <i class="fa-fw fas fa-clock nav-icon">

                        </i>
                        <?php echo e(trans('cruds.lesson.title')); ?>

                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="<?php echo e(route("admin.calendar.index")); ?>" class="nav-link <?php echo e(request()->is('admin/calendar') || request()->is('admin/calendar/*') ? 'active' : ''); ?>">
                    <i class="fa-fw fas fa-calendar nav-icon">

                    </i>
                    Calendar
                </a>
            </li>
            <li class="nav-item">
                <a href="#" id='link_logout' class="nav-link" onclick="event.preventDefault();go_logout();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    <?php echo e(trans('global.logout')); ?>

                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<?php /**PATH /var/www/icsapp/resources/views/partials/menu.blade.php ENDPATH**/ ?>