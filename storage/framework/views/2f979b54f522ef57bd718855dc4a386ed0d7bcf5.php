<?php if(Session::has('notifier.notice')): ?>
    <script>
        new PNotify(<?php echo Session::get('notifier.notice'); ?>);
    </script>
<?php endif; ?><?php /**PATH /var/www/school/vendor/jorgejavierleon/laravelpnotify/src/views/notify.blade.php ENDPATH**/ ?>