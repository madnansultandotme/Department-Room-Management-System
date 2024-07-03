#  Department Room Reservation System

This project is a  Department Room Reservation System that allows users to reserve rooms for specific time slots on a selected date. Users can log in to the system, view available slots, and book rooms. Additionally, it shows which user has booked a slot when a booked slot is clicked.
#Case Study
Department rooms reservation system: The workflow of the process is as follows:
a) Registered user can reserve any of the lecture rooms of the department.
b) User id, name, and password.
c) Registered users data is saved in MySQL database server.
d) Once authenticated user can select the room, date, and time from the displayed table along with checkboxes table (disabled).
e) Once user selects the required room, date, and time from the table, the checkboxes are enabled except for those selected by another user.
f) User can check box reserve with fields "id, date, time, room" from table "server" and press OK button.
g) Accordingly to implemented data (saved) the room is reserved by user.

## Features

- User authentication (login/logout)
- Room reservation with time slots
- Display of booked slots with user names
- Responsive design with interactive UI

## Technologies Used

- HTML/CSS/JavaScript for the frontend
- PHP for the backend
- MySQL for the database

## Prerequisites

- XAMPP or any other local server environment with PHP and MySQL support
- Web browser (Chrome, Firefox, etc.)

## Setup Instructions

### Step 1: Clone the Repository

Open your terminal or command prompt and run the following command to clone the repository:

```bash
git clone https://github.com/yourusername/room-reservation-system.git
cd room-reservation-system
