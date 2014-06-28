#StoryEngine
##About
StoryEngine is a PHP based Engine to create and play online CYOA utilising Code Igniter (http://ellislab.com/codeigniter) and Twitter Bootstrap (http://getbootstrap.com/).

The initial version of the engine was created during a multi-linear storytelling course at the Zurich University of the Arts (http://www.zhdk.ch).

##Installation
1. Download the newest version of the engine from the master branch
2. Copy everything except the `_database` folder, `README.md` and `.gitignore` onto your webserver
3. Use `/_database/storyengine.sql` (MySQL) to setup the database for the engine
4. Edit `/application/config/database.php` to match your database connection
5. If you want to change the engines language edit `$config['language']` inside `/application/config/config.php` (only english and german are supported at the moment)
6. Make sure that the `assets` folder and its subfolders have writing access
7. Replace the files in `/img/ico` with your favicons
8. The installation is complete and you can now log into the engine with the default account (username: `administrator`, password: `password`)

##Using the engine
- Only administrators can manage users
- Only authors can manage the story
- Create pages and add options to the pages
- Pages can have consequences that affect the attributes you defined
- Options can have conditions. If a condition is not met the option will not be displayed
- Options can have consequences that affect the attributes you defined
- Options can have checks based on attributes or random checks. If these checks are met a random success page will be chosen to go to. If they're not met a random fail page will be chosen
- Add achievements based on the attributes you defined
