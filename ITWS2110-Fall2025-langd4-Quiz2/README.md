##  3.1. Any design decisions that you took in completing this quiz.
Decided to add a link on login page to registration because you should be able to only go there if you type in a user and password that doesn't exist. Also I decided that the color would mimic semi-lms/blackboard so I used a darker shade and easy hover animations. Also for fun and clarity, made new projects glow green if they were just created.

##  3.2. Describe how you would handle a situation where a user came to the site for the very first time and no database existed 
If a new user came to the site for the first time an no database existed, I would have db.php first check to connect to database, if it didnt exist I could query code to essentially remake the data for instance i could call the following code to connect to my sql server and create database 

### Example query:
$conn = new mysqli($servername, $username, $password);
$conn->query("CREATE DATABASE \`$dbname\`");

### Example query to make a table:
'$conn->query("
    CREATE TABLE users (
        userId INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(50) NOT NULL,
        lastName VARCHAR(50) NOT NULL,
        nickName VARCHAR(50),
        password_hash CHAR(64) NOT NULL,
        password_salt CHAR(32) NOT NULL
    ) ENGINE=InnoDB;
    ");

The User could then just click the link to register.php and creates the first account, and from there the login/registration should work in theory.

## 3.3. How could you add functionality to prevent duplicate entries for the same project?
My code already does this but basically I check if there is any projects with the same name with the following code, if the rows of that list is not zero then I give out an error message and force users to try again.

### Example code:
$stmt = $conn->prepare("SELECT projectId FROM projects WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $error = "A project with this name already exists!";
} else {
    // safe to insert
}

##  3.4. Suppose you want to include functionality to let people vote on the final in-class project presentations.
###  3.4.1. What additional table(s) will you include to support this?
I think I would just need a votes table.
###  3.4.2. How will you structure the data in these table(s)?
It would be structured so that the votes table would have a userId (INT) which would correlate to our list of users, a  projectId (INT) which would correlate to the given project, and	an int for the project being voted on, which would be an the userId for whatever project said user thought was best

We could then use a sql script for later use to go through and essentally tally up average scores on each project, whoever had the most would be final in-class presentation, as well add UNIQUE(userId, projectId) to tables to avoid duplicate votes.
###  3.4.3. How could you add functionality to prevent users from submitting a vote to their own project?
One way I could add functionality would be to check the projectMembership TABLE and check if the user is a member of the given projectid if they are I would just ignore the addition.
