<?php opcache_reset(); ?>

<?php apcu_clear_cache(); ?>

<pre><?php echo date('d.m.Y H:i:s e'); ?></pre>

<pre><?php echo getenv('HOSTNAME'); ?></pre>

<pre><?php echo getenv('APP_ENV'); ?></pre>

<?php phpinfo(); ?>
