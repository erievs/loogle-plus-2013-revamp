
![alt text](https://github.com/erievs/loogle-plus-2013-revamp/blob/main/loogle%20ss.png?raw=true)

** LOOGLE PLUS DOES NOT SUPPORT ANY PUBLIC INSTANCES RAN BY OTHER PEOPLE WE 
WOULD PREFER PEOPLE TO KEEP THEM PRIVATE OF COURSE THAT WILL CHANGE IF LOOGLE
PLUS EVER GETS SHUT DOWN**

About Loogle Plus:

Loogle+ is a recreation/revival of the lost Google+, love it or hate it Loogle+ is here to stay.
It uses PHP for the backend, jQuery (a tint bit of normal javascript), CSS, of course HTML,
with Bootstrap 3 as the CSS framework.

<hr>

Thanks to https://github.com/gaffling/PHP-Grab-Favicon for the base for our metadata grabber.

(Our fork https://github.com/erievs/loogle-plus-site-metadata-grabber)

<hr>

Loogle+ Setup Guide

Info: I use localhost port 8090 for testing (localhost:8090).

Default DB Password

Root
Password

Note: PHP 7 and 8 should run it, idk about other stuff.

https://ubuntu.com/server/docs/databases-mysql (I tested it on Ubuntu 23.10 and Fedora 39, php-mysql must be installed for myphpadmin)

1. Download myphpadmin and put it in the myphpadmin folder, https://www.phpmyadmin.net/

2. Create a database and input the SQL file.

3. Fill in the info in db.php.

4. Make sure you properly update all the URLs for the url, for the index.php and others. It will be added to a config file soon.

5. The mobile app will also need to be patched.
