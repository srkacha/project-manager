yii2-basic-template
===================

Yii2-basic-template is based on yii2-app-basic created by yii2 core developers, but it also uses some of the features presented in their advanced template too.
There are several upgrades made to this template.

1. This template comes with almost all features that default yii2-app-advanced has.
2. It has additional features listed in the next section of this guide.
3. Application structure has been changed to be 'shared hosting friendly'.

Features
-------------------

- Signup with/without account activation
    - You can chose whether or not new users need to activate their account using email account activation system before they can log in.
- Login using email/password or username/password combo.
    - You can chose how users will login into system. They can log in either by using their username|password combo or email|password.
- Rbac tables are installed with other migrations when you run ```yii migrate``` command.
    - RbacController's init() action will insert 5 roles and 2 permissions in our rbac tables created by migration.
    - Roles can be easily assigned to users by administrators of the site.
- Session data is stored in _protected/session folder.
- System setting are stored in config/params.php file.
- Theming is supported out of the box.
- Translation is supported out of the box.
- Administrator+ roles can manage users.
- Password strength validation and strength meter are included out of the box.
- Simple role management is included out of the box.
- Code is heavily commented out.

Installation
-------------------
>I am assuming that you know how to: install and use Composer, and install additional packages/drivers that may be needed for you to run everything on your system. In case you are new to all of this, you can check my guides for installing default yii2 application templates, provided by yii2 developers, on Windows 8 and Ubuntu based Linux operating systems, posted on www.freetuts.org.

1. Create database that you are going to use for your application (you can use phpMyAdmin or any other tool that you like).

2. Now open up your console and ```cd``` to your web root directory, for example: ``` cd /var/www/html/ ```

3. Run the Composer ```create-project``` command:

   ``` composer create-project nenad/yii2-basic-template basic ```

4. Now you need to tell your application to use database that you have previously created.
Open up db.php config file in ```basic/_protected/config/db.php``` and adjust your connection credentials.

5. Back to the console. Inside your newly installed application, ```cd``` to the ```_protected``` folder.

7. Execute yii migration command that will install necessary database tables:

   ``` ./yii migrate ``` or if you are on Windows ``` yii migrate ```

8. Execute _rbac_ controller _init_ action that will populate our rbac tables with default roles and
permissions:

   ``` ./yii rbac/init ``` or if you are on Windows ``` yii rbac/init ```


You are done, you can start your application in your browser.

> Note: First user that signs up will get 'theCreator' (super admin) role. This is supposed to be you. This role have all possible super powers :-) . Every other user that signs up after the first one will NOT get any role by default. This is because authenticated user (@ by default) is same like our member role. 

Testing
-------------------

If you want to run tests you should create additional database that will be used to store 
your testing data. Usually testing database will have the same structure like the production one.
I am assuming that you have Codeception installed globally, and that you know how to use it.
Here is how you can set up everything easily:

1. Let's say that you have created database called ```basic```. Go create the testing one called ```basic_tests```.

2. Inside your ```db.php``` config file change database you are going to use to ```basic_tests```.

3. Open up your console and ```cd``` to the ```_protected``` folder of your application.

4. Run the migrations again: ``` ./yii migrate ``` or if you are on Windows ```yii migrate```

5. Run rbac/init again: ``` ./yii rbac/init ``` or if you are on Windows ```yii rbac/init```

6. Now you can tell your application to use your ```basic``` database again instead of ```basic_tests```.
Adjust your ```db.php``` config file again.

7. Now you are ready to tell Codeception to use ```basic_tests``` database.
   
   Inside: ``` _protected/tests/codeception/config/config.php ``` file tell your ```db``` to use 
```basic_tests``` database.

8. Start your php server inside the root of your application: ``` php -S localhost:8080 ``` 
(if the name of your application is _basic_, then root is ```basic``` folder) 

9. Move to ```_protected/tests``` , run ```codecept build``` and then run your tests.

Directory structure
-------------------

```
_protected
    assets/              contains assets definition
    components/          contains custom made application components
    config/              contains application configurations
    console              contains console commands (controllers and migrations)
    controllers/         contains Web controller classes
    helpers/             contains helper classes
    mail/                contains view files for e-mails
    models/              contains model classes
    rbac/                contains role based access control classes
    runtime/             contains files generated during runtime
    tests/               contains various tests for the basic application
    translations/        contains application translations
    views/               contains view files for the Web application
    widgets/             contains widgets
assets                   contains application assets generated during runtime
themes                   contains your themes
uploads                  contains various files that can be uploaded by application users
```
Version 2.3.0 changes
-------------------
1) Adds `components` folder to the _protected folder, and `Aliases` class in it.  
2) Articles have been removed from the template.  
3) Themes have been changed.    
4) A lot of code improvements have been done.    
5) More translation messages have been added.    

Password strength guide
-----------------------

Since 1.1.1 version has been released, password strength extension has been included as a core part of improved templates. Usage is very simple:

In our signup, user create/update and password reset forms password strength meter is always displayed when users are entering their password. This will give them visual representation of their password strength.  
But this is not all. As The Creator you have option in your settings "Force Strong Password" that you can use. If you turn it on, users will be forced to use strong passwords according to preset you chose. For example if you use normal preset, users will be forced to use at least 8 characters long password, with at least one upper-case and one lower-case letter, plus at least one digit.  

Choosing presets:

By default normal preset is used for signup and user create/update forms. For password reset we are using 'simple' preset. If you want to customize which presets is used, see SignupForm model, User model and ResetPasswordForm model. You will see rules declared for using strong passwords. Presets are located in ```vendor/kartik-v/yii2-password/presets.php```. You can chose some other preset declared in presets.php, or create new ones.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)
