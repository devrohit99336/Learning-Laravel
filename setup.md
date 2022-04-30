# install laravel project in root fiolder ubuntu

refrance => https://www.hostinger.in/tutorials/how-to-install-laravel-on-ubuntu-18-04-with-apache-and-php/



### After install grant permission for command
    sudo chmod -R 755 /var/www/html/leaveapp
    sudo chmod -R 755 /var/www/html/leaveapp/public
    sudo chmod -R 755 /var/www/html/leaveapp/storage

posiblity not run

    sudo chown -R /var/www/html/leaveapp
    sudo chown -R /var/www/html/leaveapp/public
    sudo chown -R /var/www/html/leaveapp/storage

if facing this error - The stream or file **"/var/www/html/example/storage/logs/laravel.log"** could not be opened in append mode: Failed to open stream: Permission denied" run commnd -
Refrance => [www.codegrepper.com](https://www.codegrepper.com/code-examples/shell/laravel.log%22+could+not+be+opened+in+append+mode%3A+failed+to+open+stream%3A+Permission+denied)

    $ chmod -R 775 storage bootstrap/cache