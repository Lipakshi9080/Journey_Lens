// public/chatroom.js
const socket = io();

// DOM elements
const usernameInput = document.getElementById('username');
const setUsernameButton = document.getElementById('set-username-button');
const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-button');
const messagesList = document.getElementById('messages');

let username = '';
let userType = ''; // 'traveler' or 'guide'

// Set username when the user clicks the "Set Username" button
setUsernameButton.addEventListener('click', () => {
    username = usernameInput.value.trim();
    if (username) {
        // Enable message input and send button
        messageInput.disabled = false;
        sendButton.disabled = false;

        // Hide the username input container
        document.getElementById('username-container').style.display = 'none';
        
        // Ask the user if they are a traveler or guide
        userType = prompt("Are you a Traveler or a Guide?");
        userType = userType.toLowerCase().trim();
        if (userType !== 'traveler' && userType !== 'guide') {
            alert("Please enter 'Traveler' or 'Guide'.");
            return;
        }
    } else {
        alert('Please enter a valid username');
    }
});

// Send message to server
sendButton.addEventListener('click', () => {
    const messageContent = messageInput.value.trim();
    if (messageContent && username) {
        // Send the message with username and userType (Traveler/Guide)
        socket.emit('sendMessage', { username, messageContent, userType });
        messageInput.value = ''; // Clear input field
    }
});

// Receive messages from the server and display them
socket.on('receiveMessage', (data) => {
    const li = document.createElement('li');
    li.classList.add(data.userType); // Add class for Traveler or Guide
    li.innerHTML = `<strong>${data.username}:</strong> ${data.messageContent}`;
    messagesList.appendChild(li);
    messagesList.scrollTop = messagesList.scrollHeight; // Scroll to the bottom
});
