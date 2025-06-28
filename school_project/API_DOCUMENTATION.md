# School Management System API Documentation

## Overview
This API provides comprehensive CRUD operations for all modules in the school management system. All endpoints return JSON responses and require authentication (except public endpoints).

## Base URL
```
http://your-domain.com/api/v1
```

## Authentication
The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:
```
Authorization: Bearer your-access-token
```

## Response Format
All API responses follow this format:
```json
{
    "success": true/false,
    "message": "Response message",
    "data": {}, // Response data
    "errors": {} // Validation errors (if any)
}
```

---

## Authentication Endpoints

### POST /login
Login user and get access token
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

### POST /register
Register new user
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### POST /logout
Logout user (requires authentication)

### POST /refresh
Refresh access token (requires authentication)

---

## Student Management

### GET /students
Get all students with pagination and search
- Query params: `search`, `class`, `section`, `per_page`

### POST /students
Create new student
```json
{
    "full_name": "John Doe",
    "parent_name": "Jane Doe",
    "gender": "Male",
    "dob": "2010-01-01",
    "blood_group": "A+",
    "religion": "Christianity",
    "class": "5",
    "section": "A",
    "teacher_name": "Mr. Smith",
    "email": "john@example.com",
    "phone": "1234567890",
    "address": "123 Main St"
}
```

### GET /students/{id}
Get specific student

### PUT /students/{id}
Update student

### DELETE /students/{id}
Delete student

### GET /students/{id}/details
Get detailed student information with related data

### POST /students/{id}/promote
Promote student to next class
```json
{
    "new_class": "6",
    "new_section": "A"
}
```

---

## Teacher Management

### GET /teachers
Get all teachers with pagination and search
- Query params: `search`, `subject`, `class`, `per_page`

### POST /teachers
Create new teacher
```json
{
    "first_name": "John",
    "last_name": "Smith",
    "gender": "Male",
    "date_of_birth": "1985-01-01",
    "blood_group": "A+",
    "religion": "Christianity",
    "email": "john.smith@school.com",
    "phone": "1234567890",
    "address": "123 Teacher St",
    "qualification": "M.Ed",
    "experience": "5 years",
    "subject": "Mathematics",
    "class": "5",
    "section": "A",
    "salary": 50000
}
```

### GET /teachers/{id}
Get specific teacher

### PUT /teachers/{id}
Update teacher

### DELETE /teachers/{id}
Delete teacher

### GET /teachers/{id}/details
Get detailed teacher information

### GET /teachers/{id}/payments
Get teacher payment history

### POST /teachers/{id}/payment
Add payment for teacher
```json
{
    "amount": 50000,
    "payment_date": "2024-01-01",
    "payment_method": "Bank Transfer",
    "description": "Monthly salary"
}
```

---

## Parent Management

### GET /parents
Get all parents with pagination and search
- Query params: `search`, `occupation`, `per_page`

### POST /parents
Create new parent
```json
{
    "full_name": "Jane Doe",
    "gender": "Female",
    "parent_occupation": "Engineer",
    "spouse_name": "John Doe",
    "spouse_occupation": "Doctor",
    "cnic": "12345-6789012-3",
    "blood_group": "B+",
    "religion": "Christianity",
    "email": "jane@example.com",
    "phone": "1234567890",
    "address": "123 Parent St"
}
```

### GET /parents/{id}
Get specific parent

### PUT /parents/{id}
Update parent

### DELETE /parents/{id}
Delete parent

### GET /parents/{id}/children
Get children of specific parent

### GET /parents/{id}/details
Get detailed parent information

---

## Class Management

### GET /classes
Get all classes with pagination and search
- Query params: `search`, `per_page`

### POST /classes
Create new class
```json
{
    "class_name": "Grade 5",
    "section": "A",
    "teacher_name": "Mr. Smith",
    "room_number": "101",
    "capacity": 30,
    "description": "Grade 5 Section A"
}
```

### GET /classes/{id}
Get specific class

### PUT /classes/{id}
Update class

### DELETE /classes/{id}
Delete class

### GET /classes/{id}/students
Get students in specific class

### GET /classes/{id}/subjects
Get subjects for specific class

### GET /classes/{id}/routine
Get class routine

### POST /classes/{id}/routine
Create class routine
```json
{
    "routines": [
        {
            "day_of_week": "Monday",
            "subject": "Mathematics",
            "teacher": "Mr. Smith",
            "start_time": "09:00",
            "end_time": "10:00",
            "room": "101"
        }
    ]
}
```

---

## Fee Management

### GET /fees
Get all fees with pagination and search
- Query params: `search`, `class`, `section`, `per_page`

### POST /fees
Create new fee
```json
{
    "fee_name": "Tuition Fee",
    "fee_type": "Monthly",
    "amount": 5000,
    "class": "5",
    "section": "A",
    "due_date": "2024-01-31",
    "description": "Monthly tuition fee"
}
```

### GET /fees/{id}
Get specific fee

### PUT /fees/{id}
Update fee

### DELETE /fees/{id}
Delete fee

### GET /fees/class/{class_id}
Get fees by class

### GET /fees/student/{student_id}
Get fees by student

---

## Challan Management

### GET /challans
Get all challans with pagination and search
- Query params: `search`, `class`, `section`, `status`, `month`, `year`, `per_page`

### POST /challans
Create new challan
```json
{
    "school_name": "ABC School",
    "class": "5",
    "section": "A",
    "full_name": "John Doe",
    "father_name": "Robert Doe",
    "gr_number": "12345",
    "academic_year": "2024",
    "year": 2024,
    "from_month": "January",
    "from_year": 2024,
    "to_month": "January",
    "to_year": 2024,
    "total_fee": 5000,
    "due_date": "2024-01-31",
    "amount_in_words": "Five Thousand Only"
}
```

### GET /challans/{id}
Get specific challan

### PUT /challans/{id}
Update challan

### DELETE /challans/{id}
Delete challan

### GET /challans/{id}/pdf
Download challan as PDF

### POST /challans/{id}/pay
Mark challan as paid
```json
{
    "payment_date": "2024-01-15",
    "payment_method": "Cash",
    "transaction_id": "TXN123456",
    "remarks": "Payment received"
}
```

### GET /challans/student/{student_id}
Get challans by student

### GET /challans/class/{class_id}
Get challans by class

---

## Attendance Management

### GET /attendance
Get all attendance records with pagination and filters
- Query params: `class`, `section`, `date`, `month`, `year`, `per_page`

### POST /attendance
Record attendance
```json
{
    "student_id": 1,
    "date": "2024-01-15",
    "status": "present",
    "remarks": "On time"
}
```

### GET /attendance/{id}
Get specific attendance record

### PUT /attendance/{id}
Update attendance record

### DELETE /attendance/{id}
Delete attendance record

### GET /attendance/class/{class_id}/date/{date}
Get attendance by class and date

### GET /attendance/student/{student_id}/month/{month}
Get attendance by student and month

### POST /attendance/bulk
Bulk record attendance
```json
{
    "date": "2024-01-15",
    "attendance": [
        {
            "student_id": 1,
            "status": "present",
            "remarks": "On time"
        },
        {
            "student_id": 2,
            "status": "absent",
            "remarks": "Sick"
        }
    ]
}
```

---

## Library Management

### Books

### GET /books
Get all books with pagination and search
- Query params: `search`, `category`, `available`, `per_page`

### POST /books
Add new book
```json
{
    "title": "Mathematics Grade 5",
    "author": "John Author",
    "isbn": "978-1234567890",
    "category": "Textbook",
    "publisher": "ABC Publishers",
    "publication_year": 2023,
    "total_copies": 10,
    "available_copies": 10,
    "price": 500,
    "description": "Grade 5 Mathematics textbook"
}
```

### GET /books/{id}
Get specific book

### PUT /books/{id}
Update book

### DELETE /books/{id}
Delete book

### GET /books/available
Get available books

### Book Issues

### GET /book-issues
Get all book issues with pagination and search
- Query params: `search`, `status`, `class`, `per_page`

### POST /book-issues
Issue book to student
```json
{
    "book_id": 1,
    "student_id": 1,
    "issue_date": "2024-01-15",
    "due_date": "2024-02-15",
    "remarks": "Textbook for semester"
}
```

### GET /book-issues/{id}
Get specific book issue

### PUT /book-issues/{id}
Update book issue

### DELETE /book-issues/{id}
Delete book issue

### GET /book-issues/student/{student_id}
Get book issues by student

### POST /book-issues/{id}/return
Return book
```json
{
    "return_date": "2024-02-10",
    "condition": "good",
    "fine_amount": 0,
    "remarks": "Returned in good condition"
}
```

---

## Dashboard

### GET /dashboard/stats
Get dashboard statistics

### GET /dashboard/recent-activities
Get recent activities

### GET /dashboard/notifications
Get notifications

---

## Error Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

---

## Usage Examples

### JavaScript/Axios
```javascript
// Login
const response = await axios.post('/api/v1/login', {
    email: 'user@example.com',
    password: 'password'
});

const token = response.data.data.access_token;

// Set default authorization header
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// Get students
const students = await axios.get('/api/v1/students?search=john&class=5');

// Create student
const newStudent = await axios.post('/api/v1/students', {
    full_name: 'John Doe',
    parent_name: 'Jane Doe',
    // ... other fields
});
```

### PHP/Curl
```php
// Login
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://your-domain.com/api/v1/login');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => 'user@example.com',
    'password' => 'password'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$data = json_decode($response, true);
$token = $data['data']['access_token'];

// Get students with token
curl_setopt($ch, CURLOPT_URL, 'http://your-domain.com/api/v1/students');
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);

$students = curl_exec($ch);
curl_close($ch);
```

---

## Notes

1. All endpoints require authentication except `/login`, `/register`, and public endpoints
2. File uploads (photos, documents) should be sent as multipart/form-data
3. Dates should be in YYYY-MM-DD format
4. Pagination is available on list endpoints with `page` and `per_page` parameters
5. Search functionality is available on most list endpoints
6. All monetary amounts are in the base currency unit
7. Status fields have predefined values - check validation rules in controllers

---

## Installation Requirements

1. Laravel Sanctum for API authentication
2. Laravel framework 7.x or higher
3. MySQL database
4. PHP 7.4 or higher

## Setup Instructions

1. Install Laravel Sanctum:
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

2. Add Sanctum middleware to `app/Http/Kernel.php`:
```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

3. Update User model to use HasApiTokens trait:
```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    // ...
}
```

This completes the comprehensive API documentation for your school management system!
