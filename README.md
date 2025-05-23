# Journey_Lens
Journey Lens is a web-based platform designed to connect travelers with local guides through real-time chat communication. This project facilitates seamless interaction between travelers and guides, helping travelers get personalized assistance and local insights for their trips.
Features:

1)User registration and login for travelers and guides
2)Destination-based guide selection with ratings and reviews
3)Real-time two-way chat between travelers and guides using WebSockets (Socket.IO)
4)Persistent chat history stored in MySQL database
5)Secure session management and input validation
6)Responsive and user-friendly interface

Tech Stack:

1:Backend: PHP, MySQL
2:Frontend: HTML, CSS, JavaScript
3:Real-time communication: Node.js with Socket.IO

Database:

1)Separate tables for travelers, guides, chat sessions, and chat messages
2)Foreign key constraints to maintain referential integrity

Usage:

1)Clone the repository
2)Set up MySQL database with provided schema
3)Configure database connection in db_connect.php
4)Start the PHP server (e.g., via XAMPP)
5)Start the Node.js Socket.IO server for real-time messaging
6)Access the application via browser and start chatting!

