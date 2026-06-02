<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management - Login & Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* 🎨 Warna dasar krem hangat senada biar gak blink putih */
            background-color: #eadeda; 
            background: url("{{ asset('images/yaya3.png') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;

            /* Animasi menyambung Fade-In pas masuk halaman */
            animation: pageFadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        /* ✨ ANIMASI FADE-IN ELEGAN */
        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: scale(1.01);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* 🌊 GELEMBUNG CAIRAN GLASSMORPHISM SEBENING KACA */
        .auth-container {
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            
            width: 540px; 
            max-width: 100%;
            /* 📐 Lebar & tinggi minimum disesuaikan agar tombol sosial media di bawah tidak berdempetan */
            min-height: 640px; 
            overflow: hidden;
            
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.04), 
                        inset 0 15px 35px rgba(255, 255, 255, 0.25),
                        inset 0 -15px 35px rgba(255, 255, 255, 0.02); 
            
            position: relative;
            z-index: 10;
            margin-right: 15%; 
            padding: 45px 50px;

            /* ⚡ GERAKAN CAIRAN DIPERCEPAT JADI 5 DETIK */
            animation: liquidWater 5s infinite ease-in-out;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @keyframes liquidWater {
            0%, 100% { border-radius: 45% 55% 48% 52% / 52% 45% 55% 48%; }
            33% { border-radius: 54% 46% 52% 48% / 45% 55% 47% 53%; }
            66% { border-radius: 47% 53% 45% 55% / 55% 47% 53% 45%; }
        }

        /* Logo Header */
        .logo-header {
            text-align: center;
            margin-bottom: 22px;
        }

        .logo-icon-wrapper {
            font-size: 3rem;
            color: #bc8a93;
            margin-bottom: 2px;
        }

        .logo-title {
            font-size: 2.2rem;
            font-weight: 500;
            color: #b5838d;
            line-height: 1;
        }

        .logo-subtitle {
            font-size: 0.78rem;
            color: #8a8194;
            font-weight: 500;
            margin-top: 5px;
        }

        /* Switch Form Tab Animation */
        .form-side {
            display: none;
            animation: fadeInGlass 0.4s ease-in-out forwards;
        }

        .form-side.active {
            display: block;
        }

        @keyframes fadeInGlass {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-side h2 {
            font-size: 1.7rem;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }

        .login-side h2 { color: #4fa1cf; }
        .signup-side h2 { color: #d48386; }

        /* Input Form Elements */
        .input-group {
            margin-bottom: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 11px 16px; 
            background: rgba(255, 255, 255, 0.35); 
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            outline: none;
            font-size: 0.9rem;
            transition: 0.3s;
            color: #222;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.6);
            border-color: #b5e2fa;
            box-shadow: 0 0 12px rgba(181, 226, 250, 0.25);
        }

        .input-group input::placeholder {
            color: #444;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 18px;
            color: #333;
            font-weight: 500;
        }

        .form-options input[type="checkbox"] {
            margin-right: 6px;
            vertical-align: middle;
        }

        .form-options a {
            color: #4fa1cf;
            text-decoration: none;
        }

        /* Buttons Styling */
        .btn-submit {
            width: 100%;
            padding: 11px; 
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 16px;
        }

        .login-side .btn-submit { background-color: #92c5f2; }
        .login-side .btn-submit:hover { background-color: #7cb5e4; }

        .signup-side .btn-submit { background-color: #fcaaa4; }
        .signup-side .btn-submit:hover { background-color: #f7938b; }

        .toggle-form-text {
            text-align: center;
            font-size: 0.88rem;
            color: #444;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .toggle-form-text span {
            color: #bc8a93;
            cursor: pointer;
            text-decoration: underline;
            font-weight: 600;
            margin-left: 5px;
            transition: 0.2s;
        }
        
        .toggle-form-text span:hover {
            color: #b5838d;
        }

        .oauth-divider {
            text-align: center;
            font-size: 0.78rem;
            color: #444;
            margin-bottom: 14px;
        }

        /* 📦 DISTANSI JAWATAN OAUTH (GOOGLE & APPLE) */
        .oauth-buttons {
            display: flex;
            gap: 14px;
            margin-top: 5px;
        }

        .btn-oauth {
            flex: 1;
            padding: 11px; /* Sedikit dipertebal biar seimbang dengan form utama */
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            font-weight: 600;
            color: #222;
            transition: 0.3s;
        }
        
        .btn-oauth:hover {
            background: rgba(255, 255, 255, 0.75);
        }

        @media (max-width: 900px) {
            .auth-container {
                margin-right: 0;
                width: 100%;
                animation: none;
                border-radius: 25px;
                padding: 30px;
            }
        }

        /* Ambient Glow Layer */
        .decorations-layer {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 1; 
        }

        .pastel-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.45;
            animation: pulseGlow 12s infinite ease-in-out;
        }

        .glow-pink-pastel { width: 360px; height: 360px; background-color: #ffcad4; top: 18%; left: 20%; }
        .glow-blue-pastel { width: 340px; height: 340px; background-color: #b5e2fa; bottom: 18%; right: 30%; animation-delay: 4s; }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.15) translate(15px, -15px); }
        }
        
        /* BACKEND ALERT STYLE: Styling kotak penampung pesan kesalahan login */
        .alert-danger-glass {
            background: rgba(212, 131, 134, 0.2);
            border: 1px solid rgba(212, 131, 134, 0.4);
            color: #8c3b3e;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.82rem;
            margin-bottom: 18px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="decorations-layer">
        <div class="pastel-glow glow-pink-pastel"></div>
        <div class="pastel-glow glow-blue-pastel"></div>
    </div>

    <div class="auth-container">
        <div class="logo-header">
            <div class="logo-icon-wrapper">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="logo-title">Libra.ry</div>
            <div class="logo-subtitle">Library Management System</div>
        </div>
        
        <div class="form-side login-side active" id="loginFormSide">
            <h2>Log in</h2>
            
            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                @if($errors->has('login_error'))
                    <div class="alert-danger-glass">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first('login_error') }}
                    </div>
                @endif

                <div class="input-group">
                    <input type="text" name="login_input" placeholder="Email Kampus / Username Admin" value="{{ old('login_input', 'putriauliyaamanda22@gmail.com') }}" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" value="123456789" required>
                </div>
                
                <div class="form-options">
                    <label><input type="checkbox" name="remember" checked> Remember Me</label>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-submit">Sign In</button>

                <div class="toggle-form-text">
                    Belum punya akun?<span onclick="switchForm('signup')">Daftar sekarang</span>
                </div>
            </form>

                <div class="oauth-divider">or log in with</div>

                <div class="oauth-buttons">
                    <button type="button" class="btn-oauth">
                        <img src="https://fonts.gstatic.com/s/i/productlogos/googleg/v6/web-24dp/logo_googleg_color_1x_web_24dp.png" width="15" alt="Google"> Google
                    </button>
                    <button type="button" class="btn-oauth">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" width="13" alt="Apple"> Apple
                    </button>
                </div>
            </form>
        </div>

        <div class="form-side signup-side" id="signupFormSide">
            <h2>Sign Up</h2>
            
            <form action="#" method="GET">
                <div class="input-group">
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <div class="form-options">
                    <label><input type="checkbox" required> Terms & Conditions</label>
                </div>

                <button type="submit" class="btn-submit">Sign Up</button>

                <div class="toggle-form-text">
                    Sudah punya akun?<span onclick="switchForm('login')">Masuk di sini</span>
                </div>

                <div class="oauth-divider">or sign up with</div>

                <div class="oauth-buttons">
                    <button type="button" class="btn-oauth">
                        <img src="https://fonts.gstatic.com/s/i/productlogos/googleg/v6/web-24dp/logo_googleg_color_1x_web_24dp.png" width="15" alt="Google"> Google
                    </button>
                    <button type="button" class="btn-oauth">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" width="13" alt="Apple"> Apple
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchForm(formType) {
            const loginSide = document.getElementById('loginFormSide');
            const signupSide = document.getElementById('signupFormSide');
            
            if (formType === 'signup') {
                loginSide.classList.remove('active');
                signupSide.classList.add('active');
            } else {
                signupSide.classList.remove('active');
                loginSide.classList.add('active');
            }
        }
    </script>
</body>
</html>