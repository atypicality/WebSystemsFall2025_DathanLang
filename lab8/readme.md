# ITWS2110-S25 LAB 8| Dathan Lang 

## Answers to PHP Questions
Overall I though this lab went pretty straightforward after download apache and mysql. I would say that I did find some of the directions vague so I made the variables to the best of my knowledge and also assumed that the course prefix would be some small four letter acronym.

here is a list of commands i used to generate in order.

//COMMANDS TO GET STUFF RUNNING
sudo apt install apache2 
sudo systemctl start apache2
sudo cp index.html /var/www/html/
sudo apt install phpmyadmin
sudo mysql 
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'MY PASSWORD';  *WAS REPLACED WITH MY ACTUAL PASSWORD
PRIVILEGES;
EXIT;

//PROCEEDED TO USE ONLINE SITE  
PART 1:
CREATE TABLE courses (
    crn INT(11) NOT NULL PRIMARY KEY,
    prefix VARCHAR(4) NOT NULL,
    number SMALLINT(4) NOT NULL,
    title VARCHAR(255) NOT NULL
) 
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_unicode_ci;

CREATE TABLE students (
    rin INT(9) NOT NULL PRIMARY KEY,
    rcsID CHAR(7),
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    alias VARCHAR(100) NOT NULL,
    phone BIGINT(10)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_unicode_ci;



PART 2:
ALTER TABLE students
ADD COLUMN street VARCHAR(255) AFTER alias,
ADD COLUMN city VARCHAR(100) AFTER street,
ADD COLUMN state CHAR(2) AFTER city,
ADD COLUMN zip CHAR(10) AFTER state

ALTER TABLE courses
ADD COLUMN section VARCHAR(10) AFTER title,
ADD COLUMN year YEAR AFTER section
CHARACTER SET utf8

FOR INSERTING I ESSENTIALLY JUST ADDED IT MANUALLY THROUGH INSERT TAB IN MYSQL (FOR SPECIFIC COMMANDS see websyslab8.sql)
FOR ANSWERS TO LAST 4 PROBLEMS: LOOK AT answers.sql