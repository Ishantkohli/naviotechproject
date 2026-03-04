# Task Manager Web Application

This project is a web-based task management system developed as part of my Web Development Internship at Naviotech Solutions.

## Features

- User Signup and Login
- Password Hashing for Security
- User Dashboard
- Add Tasks with Deadline
- Delete Tasks
- Mark Tasks as Completed
- Admin Panel
- View All Users
- View All Tasks
- Delete Users (Admin)
- Role-based Authentication

## Technologies Used

Frontend:
- HTML
- CSS
- JavaScript

Backend:
- PHP

Database:
- MySQL

Server:
- XAMPP

## Database Structure

### Users Table
- id
- name
- email
- password
- role
- created_at

### Tasks Table
- id
- user_id
- title
- description
- deadline
- status
- created_at

## Installation Guide

1. Install XAMPP
2. Start Apache and MySQL
3. Import the database in phpMyAdmin
4. Move project folder into:


htdocs/


5. Open in browser:


http://localhost/task-manager


## Author

Ishant Kohli  
Web Development Intern  
Naviotech Solutions
