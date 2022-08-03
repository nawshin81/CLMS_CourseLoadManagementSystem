## Course load Management Systems
---

### Features

- Curriculum Management
-- Curriculum (Create, Read, Update)
-- Course Offering

- Users Management
-- Instructor
-- Administrator

- Reports Generation
--Pdf generation on:
	-- Teaching load per Instructor
	-- Course load per Semester
- Other Functionalities
-- Ability to Override the no. of units loaded depending on the employees status.

# Installation
---
- Open Terminal and run ```composer install``` from the root folder of the project.
- Create a database.
- Copy **.env.example** to **.env** and setup your database.
- Run ```php artisan key:generate``` to generate application key.
- Run ```php artisan migrate```  without quote to import all the existing tables.
- Run ```php artisan db:seed``` to seed your database.
- Run ```php artisan serve``` to start application.

# Requirements
---
- PHP 5 or higher
- MySQL
- Composer (To install Laravel and Other Dependencies)
- Pusher Account (*NotImplemented*) for realtime notifications.

### Note
---
The Default user for admin is:
User: admin@gmail.com
Password: password1234


