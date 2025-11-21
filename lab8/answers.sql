-- 7. List all students by different orders
-- a) By RIN
SELECT * FROM students ORDER BY rin;

--OUTPUT
662071234 	bbitd01 	Ben 	Bitdiddle 	bbitd 	1234567890 	123 Elm St 	    Troy 	NY 	12180
662072345 	tmjun01 	Thilanka 	mango 	thilm 	2345678901 	456 Oak Ave 	Troy 	NY 	12180
662073456 	nhuan01 	Juniper 	Huang 	jhuan 	3456789012 	789 Pine Rd 	Troy 	NY 	12180
62074567 	ndang01 	Nathan 	    Dang 	ndang 	4567890123 	101 Maple Ln 	Troy 	NY 	12180


-- b) By last name
SELECT * FROM students ORDER BY last_name;

--OUTPUT
662071234 	bbitd01 	Ben 	Bitdiddle 	bbitd 	1234567890 	123 Elm St 	    Troy 	NY 	12180
662074567 	ndang01 	Nathan 	    Dang 	ndang 	4567890123 	101 Maple Ln 	Troy 	NY 	12180
662073456 	nhuan01 	Juniper 	Huang 	jhuan 	3456789012 	789 Pine Rd 	Troy 	NY 	12180
662072345 	tmjun01 	Thilanka 	mango 	thilm 	2345678901 	456 Oak Ave 	Troy 	NY 	12180


-- c) By RCSID
SELECT * FROM students ORDER BY rcsID;

--OUTPUT
662071234 	bbitd01 	Ben 	Bitdiddle 	bbitd 	1234567890 	123 Elm St 	    Troy 	NY 	12180
662074567 	ndang01 	Nathan 	    Dang 	ndang 	4567890123 	101 Maple Ln 	Troy 	NY 	12180
662073456 	nhuan01 	Juniper 	Huang 	jhuan 	3456789012 	789 Pine Rd 	Troy 	NY 	12180
662072345 	tmjun01 	Thilanka 	mango 	thilm 	2345678901 	456 Oak Ave 	Troy 	NY 	12180


-- d) By first name
SELECT * FROM students ORDER BY first_name;

--OUTPUT
662071234 	bbitd01 	Ben 	Bitdiddle 	bbitd 	1234567890 	123 Elm St 	Troy 	NY 	12180
662073456 	nhuan01 	Juniper 	Huang 	jhuan 	3456789012 	789 Pine Rd 	Troy 	NY 	12180
662074567 	ndang01 	Nathan 	Dang 	ndang 	4567890123 	101 Maple Ln 	Troy 	NY 	12180
662072345 	tmjun01 	Thilanka 	mango 	thilm 	2345678901 	456 Oak Ave 	Troy 	NY 	12180


-- 8. List students with any grade > 90
SELECT DISTINCT s.rin, s.first_name, s.last_name, s.street, s.city, s.state, s.zip
FROM students s
JOIN grades g ON s.rin = g.rin
WHERE g.grade > 90;

--OUTPUT	
662071234 	Ben Bitdiddle 	123 Elm St 	    Troy 	NY 	12180
662074567 	Nathan 	Dang 	101 Maple Ln 	Troy 	NY 	12180


-- 9. Average grade in each course
SELECT c.crn, c.prefix, c.number, c.title, AVG(g.grade) AS average_grade
FROM courses c
JOIN grades g ON c.crn = g.crn
GROUP BY c.crn, c.prefix, c.number, c.title;

--OUTPUT
36053 	Algo 	2300 	Introduction To Algorithms 	88.3333
37367 	PSof 	2600 	Principles Of Software 	    83.3333
37564 	HCI 	2210 	Introduction To Hci 	    81.5000
38945 	AQC 	4960 	Applied Quantum Computing 	90.5000


-- 10. Number of students in each course
SELECT c.crn, c.prefix, c.number, c.title, COUNT(DISTINCT g.rin) AS num_students
FROM courses c
JOIN grades g ON c.crn = g.crn
GROUP BY c.crn, c.prefix, c.number, c.title;

--OUTPUT
36053 	Algo 	2300 	Introduction To Algorithms 	3
37367 	PSof 	2600 	Principles Of Software 	    3
37564 	HCI 	2210 	Introduction To Hci 	    2
38945 	AQC 	4960 	Applied Quantum Computing 	2