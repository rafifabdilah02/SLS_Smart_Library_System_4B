<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Libra.ry</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth; /* Membuat guliran mouse ke bawah jadi halus */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5eff1;
            color: #333;
            overflow-x: hidden;
        }

        /* 🎬 EFEK TRANSISI PERPINDAHAN HALAMAN (DIPERCEPAT BIAR GA LAMA) */
        .page-transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* 🌟 Gradasi pastel transparan dengan blur agar menyatu dengan background login */
            background: linear-gradient(135deg, #eadeda 0%, #ffcad4 50%, #b5e2fa 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            
            z-index: 9999;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.25s ease-in-out; /* ⚡ Dipercepat dari 0.5s ke 0.25s */
        }

        .page-transition-overlay.fade-out {
            opacity: 1;
        }

        /* ==================== SECTION 1: HERO VIDEO ==================== */
        .hero-section {
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.65) 0%, rgba(227, 213, 202, 0.45) 100%);
            backdrop-filter: blur(2px);
            z-index: -1;
        }

        .content-box {
            text-align: center;
            color: #ffffff;
            max-width: 800px;
            padding: 20px;
            animation: fadeInUp 1.2s ease-out;
        }

        .title-welcome {
            font-size: 1.8rem;
            font-weight: 300;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 5px;
            color: #f5eff1;
        }

        .title-brand {
            font-family: 'Playfair Display', serif;
            font-size: 5.5rem;
            font-weight: 600;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(to right, #ffffff, #ffe5ec);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 1.1rem;
            font-weight: 300;
            color: #f5eff1;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .btn-enter {
            display: inline-block;
            text-decoration: none;
            padding: 14px 40px;
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(219, 114, 137, 0.85); /* Pink pastel solid agar kontras */
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 50px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-enter:hover {
            background: #ffffff;
            color: #db7289;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        /* 🖱️ INDIKATOR SCROLL DOWN ESTETIK */
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: #ffffff;
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.7;
            animation: bounce 2s infinite;
            cursor: pointer;
        }

        /* ==================== SECTION 2: FEATURES ==================== */
        .features-section {
            padding: 100px 50px;
            background-color: #f5eff1; /* Menyamai warna background sidebar/dashboard kamu */
            text-align: center;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: #4a3f35;
            margin-bottom: 15px;
        }

        .section-divider {
            width: 60px;
            height: 3px;
            background-color: #db7289;
            margin: 0 auto 50px auto;
            border-radius: 2px;
        }

        .features-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .feature-card {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 20px;
            flex: 1;
            min-width: 280px;
            box-shadow: 0 10px 30px rgba(165, 146, 134, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(165, 146, 134, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            color: #4a3f35;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .feature-card p {
            font-size: 0.95rem;
            color: #7a6e65;
            line-height: 1.6;
        }

        /* ANIMASI */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translate(-50%, 0); }
            40% { transform: translate(-50%, -10px); }
            60% { transform: translate(-50%, -5px); }
        }
    </style>
</head>
<body>

    <div class="page-transition-overlay" id="transition-overlay"></div>

    <section class="hero-section">
        <video class="video-bg" autoplay loop muted playsinline>
            <source src="{{ asset('videos/bg-library.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay"></div>

        <div class="content-box">
            <h3 class="title-welcome">Welcome to</h3>
            <h1 class="title-brand">Libra.ry</h1>
            <p class="subtitle">Where knowledge meets modern experience. Discover thousands of stories inside.</p>
            
            <a href="{{ route('login') }}" class="btn-enter" id="btn-explore">Explore Library</a>
        </div>

        <div class="scroll-indicator" onclick="document.getElementById('features').scrollIntoView();">
            Scroll Down ↓
        </div>
    </section>

    <section class="features-section" id="features">
        <h2 class="section-title">Kenapa Libra.ry?</h2>
        <div class="section-divider"></div>

        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">📖</span>
                <h3>Katalog Digital</h3>
                <p>Akses cepat ke berbagai macam buku populer. Temukan bacaan favoritmu dalam hitungan detik tanpa ribet.</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">⏱️</span>
                <h3>Monitoring Cerdas</h3>
                <p>Sistem notifikasi pelacakan peminjaman terintegrasi, meminimalisir keterlambatan pengembalian buku.</p>
            </div>

            <div class="feature-card">
                <span class="feature-icon">✨</span>
                <h3>Desain Modern</h3>
                <p>Nikmati pengalaman mengelola dan membaca buku dengan antarmuka pastel yang bersih, tenang, dan nyaman di mata.</p>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('btn-explore').addEventListener('click', function(e) {
            e.preventDefault(); // Menahan link asli pindah langsung secara kasar
            const targetUrl = this.getAttribute('href');
            const overlay = document.getElementById('transition-overlay');

            // Munculkan efek screen fade out
            overlay.classList.add('fade-out');

            // ⚡ Diturunkan jadi 250ms agar klop dengan durasi CSS baru
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 250); 
        });
    </script>

</body>
</html>