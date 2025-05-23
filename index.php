<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journey Lens</title>
    <style>
        /* Base Styles */
        body {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #af7ac5;
            color: #2c3e50;
            scroll-behavior: smooth;
        }

        /* Header */
        header {
            background: #884ea0;
            color: white;
            text-align: center;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            letter-spacing: 2px;
            animation: typing 3s steps(30, end);
            overflow: hidden;
            white-space: nowrap;
            border-right: 3px solid white;
            display: inline-block;
        }

        header p {
            margin: 5px 0 0;
            font-size: 1rem;
            font-style: italic;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        /* Navigation */
        nav {
            background-color: #ffffff;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin: 0;
            gap: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: #6c5ce7;
            font-weight: bold;
            padding: 10px 15px;
            transition: all 0.3s;
            border: 2px solid transparent;
            border-radius: 5px;
        }

        nav ul li a:hover {
            color: white;
            background-color: #6c5ce7;
            border-color: #00b894;
            animation: bounce 0.5s;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Hero Section */
        .hero {
            text-align: center;
            background: url('https://i.pinimg.com/736x/6c/96/91/6c9691adef6243818b4053e4b4767134.jpg') center/cover no-repeat;
            color: white;
            padding: 100px 20px;
            position: relative;
        }


        .hero button:hover {
            background-color: #bb8fce;
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 10px #6c5ce7; }
            50% { box-shadow: 0 0 20px #bb8fce; }
        }

        /* Destinations Section */
        .destinations {
            text-align: center;
            padding: 50px 20px;
        }

        .destination-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .destination-card {
            background-color: white;
            width: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            transition: transform 0.5s, opacity 0.5s;
        }

        .destination-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .destination-card img:hover {
            transform: scale(1.1);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
        }

        .destination-card h3, .destination-card p {
            margin: 15px;
        }

        .destination-card h3 {
            font-size: 1.2rem;
            color: #6c5ce7;
        }

        .destination-card p {
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #2c3e50;
            color: white;
        }

        footer .social-icons {
            margin: 10px 0;
        }

        footer .social-icons a {
            margin: 0 10px;
            font-size: 1.5rem;
            color: white;
            transition: transform 0.3s;
        }

        footer .social-icons a:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <header>
        <h1>Journey Lens</h1>
        <p>Your Virtual Travel Guide</p>
    </header>

    <nav>
        <ul>
            <li><a href="guide_signup.php"> Guide Login/Signup</a></li>
            <li><a href="traveler_signup.php">Traveler Login/Signup</a></li> 
            <li><a href="Herosection.php">Travel Destinations</a></li>
        </ul>
    </nav>

    <section class="hero" id="hero">
        <h2>Discover Your Next Adventure</h2>
        <p>Explore breathtaking destinations across the globe.</p>
    </section>

    <section class="destinations" id="destinations">
        <h2>Popular Destinations</h2>
        <div class="destination-grid">
            <div class="destination-card">
                <img src="https://i.pinimg.com/736x/43/2c/a3/432ca30c40256a2494857ba4ae8a2edb.jpg" alt="Agra">
                <h3>Agra,Uttar Pradesh</h3>
                <p>The Taj Mahal: A timeless masterpiece of love and architecture</p>
            </div>
            <div class="destination-card">
                <img src="https://i.pinimg.com/736x/74/85/6c/74856cbd0fc48944eee4eec60831b861.jpg" alt="Jaisalmer">
                <h3> Jaisalmer,Rajasthan</h3>
                <p>Rajasthan: Where vibrant colors, majestic forts, and royal history collide.</p>
            </div>
            <div class="destination-card">
                <img src="https://i.pinimg.com/736x/f2/8d/ee/f28deed5516d14e10cc243cf65784a07.jpg" alt="Munnar">
                <h3>Munnar,Kerala</h3>
                <p>Munnar: A spice-scented escape in the Kerala hills.</p>
            </div>
            <div class="destination-card">
                <img src="https://i.pinimg.com/736x/cf/32/e5/cf32e5580d3314f443518fe82ed30686.jpg" alt="Baga Beach">
                <h3>Baga Beach,Goa </h3>
                <p>Baga Beach: A beach for all seasons.</p>
            </div>
        </div>
    </section>

    <footer id="footer">
        <p>&copy; 2024 Journey Lens. All Rights Reserved.</p>
        <div class="social-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </footer>

    <script>
        const cards = document.querySelectorAll('.destination-card');

        window.addEventListener('scroll', () => {
            const triggerBottom = window.innerHeight * 0.9;

            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;

                if (cardTop < triggerBottom) {
                    card.classList.add('visible');
                }
            });
        });
    </script>
</body>
</html>
