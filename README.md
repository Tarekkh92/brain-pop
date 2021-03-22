SchoolApp Rest Api Endpoints


Create Teacher:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/create-teacher
Body: form-data
Keys: fullname, email, username, password

Create Student:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/create-student
Body: form-data
Keys: fullname, username, password, grade

Get All Students:
Method: GET
URL: https://brainpoptk.herokuapp.com/public/api/students/all

Get All Teachers:
Method: GET
URL: https://brainpoptk.herokuapp.com/public/api/teachers/all

Student Login:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/student/login
Body: form-data
Keys: email, password

After login as a student, you get a token in returned json data.
You need to use this token to make teacher related requests. When making student related requests, you need to set these 3 headers to make any request.

Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded


Update student profile:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/student/update
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Body: x-www-form-urlencoded
Keys: fullname, username, grade


Teacher Login:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/teacher/login
Body: form-data
Keys: email, password

After login as a teacher, you get a token in returned json data.
You need to use this token to make teacher related requests. When making teacher related requests, you need to set these  3 headers to make any request.

Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Add Period:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/teacher/period/add
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Body: x-www-form-urlencoded
Keys: name

Update Period:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/teacher/period/update
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Body: x-www-form-urlencoded
Keys: period_id, name

Get all Periods:
Method: GET
URL: https://brainpoptk.herokuapp.com/public/api/teacher/periods
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded

Add student to Period:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/teacher/period/add/student
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Body: x-www-form-urlencoded
Keys: period_id, student_id




Remove student from Period:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/teacher/period/remove/student
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Body: x-www-form-urlencoded
Keys: period_id, student_id


Get all Students related to teachers via period:
Method: GET
URL: https://brainpoptk.herokuapp.com/public/api/teacher/students
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded




Get Students in a Period
Method: GET
URL: https://brainpoptk.herokuapp.com/public/api/teacher/period/{period_id}/students
Replace {period_id} with the actual period id.
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded








Update teacher profile:
Method: POST
URL: https://brainpoptk.herokuapp.com/public/api/teacher/update
Headers: 
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
Content-Type: application/x-www-form-urlencoded
Body: x-www-form-urlencoded
Keys: fullname, username, email


