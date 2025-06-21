<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="styles.css">
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js', 'resources/css/adit.css'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="grid-overlay"></div>
    <!-- Custom cursor -->
    <div class="custom-cursor"></div>

    <!-- Header / Navbar -->
    <header class="header">
        <div class="container">
            <div class="logo title-sec">
                <i class="fas fa-trophy"></i>
                <span>GORJYA</span>
            </div>
            <nav class="nav">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('user.lapangan') }}"
                    class="nav-link {{ request()->routeIs('user.lapangan') ? 'active' : '' }}">
                    <i class="fas fa-running"></i>
                    <span>Lapangan</span>
                </a>
                <a href="{{ route('user.pesanan') }}"
                    class="nav-link {{ request()->routeIs('user.pesanan') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('user.pembayaran') }}"
                    class="nav-link {{ request()->routeIs('user.pembayaran') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Pembayaran</span>
                </a>
                <button class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-sun" id="theme-icon"></i>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </div>
    </header>


    <main class="py-36 px-40 sm:px-36 lg:px-38">
        <div class="">
            @yield('content')
        </div>
    </main>
    @yield('scripts')

    <script>
        // Rainbow cursor trail system
        let mouseX = 0;
        let mouseY = 0;
        let isMouseMoving = false;
        let rainbowColors = [
            '#ff0000', '#ff4500', '#ffa500', '#ffff00',
            '#9acd32', '#00ff00', '#00fa9a', '#00ffff',
            '#0080ff', '#0000ff', '#8a2be2', '#da70d6',
            '#ff1493', '#ff69b4'
        ];
        let colorIndex = 0;

        // Custom cursor element
        const customCursor = document.querySelector('.custom-cursor');

        // Mouse movement tracking
        document.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            isMouseMoving = true;

            // Update custom cursor position
            customCursor.style.left = (mouseX - 12.5) + 'px';
            customCursor.style.top = (mouseY - 12.5) + 'px';

            // Create rainbow trail
            createRainbowTrail(mouseX, mouseY);
        });

        // Mouse click effects
        document.addEventListener('mousedown', function() {
            customCursor.classList.add('clicking');
            // Create burst of rainbow particles on click
            createRainbowBurst(mouseX, mouseY);
        });

        document.addEventListener('mouseup', function() {
            customCursor.classList.remove('clicking');
        });

        // Hide custom cursor when mouse leaves window
        document.addEventListener('mouseleave', function() {
            customCursor.style.opacity = '0';
        });

        document.addEventListener('mouseenter', function() {
            customCursor.style.opacity = '1';
        });

        // Rainbow trail creation function
        function createRainbowTrail(x, y) {
            const trail = document.createElement('div');
            trail.className = 'rainbow-trail';
            trail.style.left = (x - 10) + 'px';
            trail.style.top = (y - 10) + 'px';

            // Get current rainbow color
            const currentColor = rainbowColors[colorIndex % rainbowColors.length];
            trail.style.background = `radial-gradient(circle, ${currentColor}, transparent)`;
            trail.style.boxShadow = `0 0 20px ${currentColor}`;

            colorIndex++;

            document.body.appendChild(trail);

            // Remove trail after animation
            setTimeout(() => {
                if (document.body.contains(trail)) {
                    document.body.removeChild(trail);
                }
            }, 1000);
        }

        // Rainbow burst effect for clicks
        function createRainbowBurst(x, y) {
            const burstCount = 12;
            for (let i = 0; i < burstCount; i++) {
                const particle = document.createElement('div');
                particle.style.position = 'fixed';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.width = '8px';
                particle.style.height = '8px';
                particle.style.borderRadius = '50%';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '9998';

                const color = rainbowColors[i % rainbowColors.length];
                particle.style.background = color;
                particle.style.boxShadow = `0 0 15px ${color}`;

                const angle = (i / burstCount) * Math.PI * 2;
                const distance = 60 + Math.random() * 40;
                const dx = Math.cos(angle) * distance;
                const dy = Math.sin(angle) * distance;

                particle.style.animation = `rainbowBurst 0.8s ease-out forwards`;
                particle.style.setProperty('--dx', dx + 'px');
                particle.style.setProperty('--dy', dy + 'px');

                document.body.appendChild(particle);

                setTimeout(() => {
                    if (document.body.contains(particle)) {
                        document.body.removeChild(particle);
                    }
                }, 800);
            }
        }

        // Add rainbow burst animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes rainbowBurst {
                0% {
                    transform: translate(0, 0) scale(1);
                    opacity: 1;
                }
                100% {
                    transform: translate(var(--dx), var(--dy)) scale(0.3);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);


        // Enhanced Explosion Effect
        function createExplosion(x, y) {
            const colors = ['#00f5ff', '#8b5cf6', '#ff1493', '#0066ff', '#10b981', '#f59e0b'];
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                particle.style.boxShadow = `0 0 10px ${colors[Math.floor(Math.random() * colors.length)]}`;

                const angle = (i / particleCount) * Math.PI * 2;
                const velocity = 80 + Math.random() * 120;
                const dx = Math.cos(angle) * velocity + 'px';
                const dy = Math.sin(angle) * velocity + 'px';

                particle.style.setProperty('--dx', dx);
                particle.style.setProperty('--dy', dy);

                const explosion = document.createElement('div');
                explosion.className = 'explosion';
                explosion.appendChild(particle);
                document.body.appendChild(explosion);

                setTimeout(() => {
                    if (document.body.contains(explosion)) {
                        document.body.removeChild(explosion);
                    }
                }, 600);
            }
        }

        // Cyber Sound Effect (Visual feedback)
        function createCyberRipple(element) {
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(0, 245, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.left = '50%';
            ripple.style.top = '50%';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.marginLeft = '-10px';
            ripple.style.marginTop = '-10px';
            ripple.style.pointerEvents = 'none';

            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

            element.style.position = 'relative';
            element.appendChild(ripple);

            setTimeout(() => {
                if (element.contains(ripple)) {
                    element.removeChild(ripple);
                }
            }, 600);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced Card Interactions
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    const rect = card.getBoundingClientRect();
                    const x = rect.left + rect.width / 2;
                    const y = rect.top + rect.height / 2;

                    createExplosion(x, y);
                    createCyberRipple(card);

                    card.style.transform = 'scale(0.98) rotateX(5deg)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 200);
                });

                // Hover sound effect simulation
                card.addEventListener('mouseenter', function() {
                    this.style.filter = 'brightness(1.1) contrast(1.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.filter = '';
                });
            });

            // Enhanced Nav Link Effects
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // e.preventDefault();
                    const rect = link.getBoundingClientRect();
                    const x = rect.left + rect.width / 2;
                    const y = rect.top + rect.height / 2;

                    createExplosion(x, y);
                    createCyberRipple(link);

                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                });
            });

            // Theme Toggle Enhancement
            const themeToggle = document.querySelector('.theme-toggle');
            themeToggle.addEventListener('click', function(e) {
                const rect = themeToggle.getBoundingClientRect();
                const x = rect.left + rect.width / 2;
                const y = rect.top + rect.height / 2;

                createExplosion(x, y);
                createCyberRipple(themeToggle);
            });

            // Logout Button Enhancement
            const logoutBtn = document.querySelector('.logout-btn');
            logoutBtn.addEventListener('click', function(e) {
                // e.preventDefault();
                const href = this.getAttribute('href');
                const rect = logoutBtn.getBoundingClientRect();
                const x = rect.left + rect.width / 2;
                const y = rect.top + rect.height / 2;

                createExplosion(x, y);
                createCyberRipple(logoutBtn);

                // Simulate logout process
                setTimeout(() => {
                    alert('Logout initiated! Disconnecting from the matrix...');
                }, 400);
            });

            // Parallax scrolling effect
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const gridOverlay = document.querySelector('.grid-overlay');

                // Update header style using the centralized function
                updateHeaderStyle();

                // Parallax grid effect
                gridOverlay.style.transform = `translateY(${scrolled * 0.1}px)`;
            });

            // Typing effect for title
            const title = document.querySelector('.welcome-title');
            const titleText = title.textContent;
            title.textContent = '';

            let i = 0;
            const typeWriter = () => {
                if (i < titleText.length) {
                    title.textContent += titleText.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                } else {
                    title.classList.add('hologram-text');
                }
            };

            setTimeout(typeWriter, 1000);

            // Random glitch effect
            setInterval(() => {
                const elements = document.querySelectorAll('.card-title, .logo span');
                const randomElement = elements[Math.floor(Math.random() * elements.length)];

                randomElement.style.textShadow = '2px 0 #ff1493, -2px 0 #00f5ff';
                setTimeout(() => {
                    randomElement.style.textShadow = '';
                }, 100);
            }, 5000);
        });

        // Matrix rain effect (optional)
        function createMatrixRain() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.zIndex = '-3';
            canvas.style.opacity = '0.1';

            document.body.appendChild(canvas);

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const characters = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            const fontSize = 14;
            const columns = canvas.width / fontSize;
            const drops = Array(Math.floor(columns)).fill(1);

            function draw() {
                ctx.fillStyle = 'rgba(10, 10, 15, 0.05)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                ctx.fillStyle = '#00f5ff';
                ctx.font = fontSize + 'px monospace';

                for (let i = 0; i < drops.length; i++) {
                    const text = characters.charAt(Math.floor(Math.random() * characters.length));
                    ctx.fillText(text, i * fontSize, drops[i] * fontSize);

                    if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                        drops[i] = 0;
                    }
                    drops[i]++;
                }
            }

            setInterval(draw, 50);
        }

        // Theme Toggle Function

        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const root = document.documentElement;

            if (body.classList.contains("light-mode")) {
                // Switch ke dark mode
                body.classList.remove("light-mode");
                themeIcon.className = "fas fa-sun";
                localStorage.setItem("theme", "dark");

                root.style.setProperty("--bg-dark", "#0a0a0f");
                root.style.setProperty("--bg-darker", "#050508");
                root.style.setProperty("--bg-card", "rgba(15, 15, 25, 0.8)");
                root.style.setProperty("--text-light", "#ffffff");
                root.style.setProperty("--text-muted", "#a0a0b0");
            } else {
                // Switch ke light mode
                body.classList.add("light-mode");
                themeIcon.className = "fas fa-moon";
                localStorage.setItem("theme", "light");

                root.style.setProperty("--bg-dark", "#f8fafc");
                root.style.setProperty("--bg-darker", "#f1f5f9");
                root.style.setProperty("--bg-card", "rgba(255, 255, 255, 0.8)");
                root.style.setProperty("--text-light", "#1e293b");
                root.style.setProperty("--text-muted", "#64748b");
            }

            updateHeaderStyle();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const savedTheme = localStorage.getItem("theme") || "dark";
            const body = document.body;
            const themeIcon = document.getElementById("theme-icon");
            const root = document.documentElement;

            if (savedTheme === "light") {
                body.classList.add("light-mode");
                themeIcon.className = "fas fa-moon";

                root.style.setProperty("--bg-dark", "#f8fafc");
                root.style.setProperty("--bg-darker", "#f1f5f9");
                root.style.setProperty("--bg-card", "rgba(255, 255, 255, 0.8)");
                root.style.setProperty("--text-light", "#1e293b");
                root.style.setProperty("--text-muted", "#64748b");
            } else {
                body.classList.remove("light-mode");
                themeIcon.className = "fas fa-sun";

                root.style.setProperty("--bg-dark", "#0a0a0f");
                root.style.setProperty("--bg-darker", "#050508");
                root.style.setProperty("--bg-card", "rgba(15, 15, 25, 0.8)");
                root.style.setProperty("--text-light", "#ffffff");
                root.style.setProperty("--text-muted", "#a0a0b0");
            }

            updateHeaderStyle();
        });


        // Function to update header style based on current theme and scroll position
        function updateHeaderStyle() {
            const scrolled = window.pageYOffset;
            const header = document.querySelector('.header');
            const isLightMode = document.body.classList.contains('light-mode');

            if (scrolled > 50) {
                if (isLightMode) {
                    header.style.background = 'rgba(255, 255, 255, 0.95)';
                    header.style.borderBottom = '1px solid rgba(139, 92, 246, 0.5)';
                } else {
                    header.style.background = 'rgba(10, 10, 15, 0.95)';
                    header.style.borderBottom = '1px solid rgba(0, 245, 255, 0.4)';
                }
                header.style.backdropFilter = 'blur(30px)';
            } else {
                if (isLightMode) {
                    header.style.background = 'rgba(255, 255, 255, 0.9)';
                    header.style.borderBottom = '1px solid rgba(139, 92, 246, 0.3)';
                } else {
                    header.style.background = 'rgba(10, 10, 15, 0.9)';
                    header.style.borderBottom = '1px solid rgba(0, 245, 255, 0.2)';
                }
                header.style.backdropFilter = 'blur(20px)';
            }
        }

        // Enhanced Explosion Effect
        function createExplosion(x, y) {
            const colors = ['#00f5ff', '#8b5cf6', '#ff1493', '#0066ff', '#10b981', '#f59e0b'];
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                particle.style.boxShadow = `0 0 10px ${colors[Math.floor(Math.random() * colors.length)]}`;

                const angle = (i / particleCount) * Math.PI * 2;
                const velocity = 80 + Math.random() * 120;
                const dx = Math.cos(angle) * velocity + 'px';
                const dy = Math.sin(angle) * velocity + 'px';

                particle.style.setProperty('--dx', dx);
                particle.style.setProperty('--dy', dy);

                const explosion = document.createElement('div');
                explosion.className = 'explosion';
                explosion.appendChild(particle);
                document.body.appendChild(explosion);

                setTimeout(() => {
                    if (document.body.contains(explosion)) {
                        document.body.removeChild(explosion);
                    }
                }, 600);
            }
        }

        // Cyber Sound Effect (Visual feedback)
        function createCyberRipple(element) {
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(0, 245, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.left = '50%';
            ripple.style.top = '50%';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.marginLeft = '-10px';
            ripple.style.marginTop = '-10px';
            ripple.style.pointerEvents = 'none';

            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

            element.style.position = 'relative';
            element.appendChild(ripple);

            setTimeout(() => {
                if (element.contains(ripple)) {
                    element.removeChild(ripple);
                }
            }, 600);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced Card Interactions
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    const rect = card.getBoundingClientRect();
                    const x = rect.left + rect.width / 2;
                    const y = rect.top + rect.height / 2;

                    createExplosion(x, y);
                    createCyberRipple(card);

                    card.style.transform = 'scale(0.98) rotateX(5deg)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 200);
                });

                // Hover sound effect simulation
                card.addEventListener('mouseenter', function() {
                    this.style.filter = 'brightness(1.1) contrast(1.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.filter = '';
                });
            });

            // Enhanced Nav Link Effects
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // e.preventDefault();
                    const rect = link.getBoundingClientRect();
                    const x = rect.left + rect.width / 2;
                    const y = rect.top + rect.height / 2;

                    createExplosion(x, y);
                    createCyberRipple(link);

                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                });
            });

            // Theme Toggle Enhancement
            const themeToggle = document.querySelector('.theme-toggle');
            themeToggle.addEventListener('click', function(e) {
                const rect = themeToggle.getBoundingClientRect();
                const x = rect.left + rect.width / 2;
                const y = rect.top + rect.height / 2;

                createExplosion(x, y);
                createCyberRipple(themeToggle);
            });

            // Logout Button Enhancement
            const logoutBtn = document.querySelector('.logout-btn');
            logoutBtn.addEventListener('click', function(e) {
                // e.preventDefault();
                const href = this.getAttribute('href');
                const rect = logoutBtn.getBoundingClientRect();
                const x = rect.left + rect.width / 2;
                const y = rect.top + rect.height / 2;

                createExplosion(x, y);
                createCyberRipple(logoutBtn);

                // Simulate logout process
                setTimeout(() => {
                    alert('Logout initiated! Disconnecting from the matrix...');
                }, 400);
            });

            // Parallax scrolling effect
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const gridOverlay = document.querySelector('.grid-overlay');

                // Update header style using the centralized function
                updateHeaderStyle();

                // Parallax grid effect
                gridOverlay.style.transform = `translateY(${scrolled * 0.1}px)`;
            });

            // Typing effect for title
            const title = document.querySelector('.welcome-title');
            const titleText = title.textContent;
            title.textContent = '';

            let i = 0;
            const typeWriter = () => {
                if (i < titleText.length) {
                    title.textContent += titleText.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                } else {
                    title.classList.add('hologram-text');
                }
            };

            setTimeout(typeWriter, 1000);

            // Random glitch effect
            setInterval(() => {
                const elements = document.querySelectorAll('.card-title, .logo span');
                const randomElement = elements[Math.floor(Math.random() * elements.length)];

                randomElement.style.textShadow = '2px 0 #ff1493, -2px 0 #00f5ff';
                setTimeout(() => {
                    randomElement.style.textShadow = '';
                }, 100);
            }, 5000);
        });

        // Matrix rain effect (optional)
        function createMatrixRain() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.style.position = 'fixed';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.zIndex = '-3';
            canvas.style.opacity = '0.1';

            document.body.appendChild(canvas);

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const characters = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            const fontSize = 14;
            const columns = canvas.width / fontSize;
            const drops = Array(Math.floor(columns)).fill(1);

            function draw() {
                ctx.fillStyle = 'rgba(10, 10, 15, 0.05)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                ctx.fillStyle = '#00f5ff';
                ctx.font = fontSize + 'px monospace';

                for (let i = 0; i < drops.length; i++) {
                    const text = characters.charAt(Math.floor(Math.random() * characters.length));
                    ctx.fillText(text, i * fontSize, drops[i] * fontSize);

                    if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                        drops[i] = 0;
                    }
                    drops[i]++;
                }
            }

            setInterval(draw, 50);
        }

        // Initialize matrix rain after page load
        setTimeout(createMatrixRain, 2000);
    </script>

</body>

</html>
