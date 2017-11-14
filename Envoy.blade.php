@servers(["live" => "app@flopspot.de -p 222"])

@task("deploy-dev", ["on" => "live"])
cd /var/www/flopspot.de/dev.flopspot.de
git pull
composer install
php artisan migrate
@endtask

@task('parse-dev', ['on' => 'live'])
cd /var/www/flopspot.de/dev.flopspot.de
php artisan migrate
php artisan xml:parse
@endtask

@task("deploy-live", ["on" => "live"])
cd /var/www/flopspot.de/www.flopspot.de
git pull
composer install
php artisan migrate
@endtask

@task('parse-live', ['on' => 'live'])
cd /var/www/flopspot.de/www.flopspot.de
php artisan migrate
php artisan xml:parse
@endtask