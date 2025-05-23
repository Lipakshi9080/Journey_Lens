// server.js

const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Serve static files (HTML, CSS, JS for chatroom)
app.use(express.static('public'));

// Route for serving the chatroom page
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/public/chatroom.html');
});

// Handle incoming socket connections
io.on('connection', (socket) => {
    console.log('A user connected:', socket.id);

    // Listen for incoming messages
    socket.on('sendMessage', (data) => {
        console.log('Message received:', data);
        // Emit the message to all connected clients
        io.emit('receiveMessage', data);
    });

    // Handle disconnections
    socket.on('disconnect', () => {
        console.log('User disconnected:', socket.id);
    });
});

// Start the server on port 3000
server.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});
