# Install dependencies

Run the followwing commands to install dependencies:

```
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

# Create an admin user

```
root@ubuntu:/var/www/youfood# php app/console fos:user:create
Please choose a username:AdrienBrault
Please choose an email:adrien.brault@gmail.com
Please choose a password:xxxx

root@ubuntu:/var/www/youfood# php app/console fos:user:promote
Please choose a username:AdrienBrault
Please choose a role:ROLE_SUPER_ADMIN
Role "ROLE_SUPER_ADMIN" has been added to user "AdrienBrault".
```