<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
    <!-- Animated Dynamic Background -->
    <div class="absolute inset-0 animated-bg"></div>
    
    <!-- Mesh Gradient Overlay -->
    <div class="absolute inset-0 mesh-gradient"></div>
    
    <!-- Floating Particles -->
    <div class="absolute inset-0 particles"></div>

    <!-- Logo Section with Animation -->
    <div class="mb-8 relative z-10">
        {{ $logo }}
    </div>

    <!-- Company Identity Text -->
    <div class="text-center mb-8 relative z-10">
        <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg">LKTech TN SEREAL</h1>
        <p class="text-blue-100 text-xl drop-shadow-md">Sistem Informasi Inventori dan Penjualan</p>
    </div>

    <!-- Login Form Card with Enhanced Glassmorphism -->
    <div class="w-full max-w-md mx-4 sm:mx-auto sm:max-w-md px-6 sm:px-8 py-10 bg-white/10 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20 relative z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
        <div class="relative z-10">
            {{ $slot }}
        </div>
    </div>

    <!-- CSS for Dynamic Background Effects -->
    <style>
        .animated-bg {
            background: linear-gradient(-45deg, #1e3a8a, #1e40af, #4c1d95, #581c87, #312e81);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 50% 25%;
            }
            50% {
                background-position: 100% 50%;
            }
            75% {
                background-position: 50% 75%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .mesh-gradient {
            background: 
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(99, 102, 241, 0.2) 0%, transparent 50%);
            animation: meshMove 20s ease-in-out infinite;
        }

        @keyframes meshMove {
            0%, 100% {
                opacity: 0.5;
                transform: rotate(0deg) scale(1);
            }
            50% {
                opacity: 0.8;
                transform: rotate(180deg) scale(1.1);
            }
        }

        .particles {
            position: relative;
        }

        .particles::before,
        .particles::after {
            content: '';
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            box-shadow: 
                0 0 10px rgba(255, 255, 255, 0.3),
                20px 30px 0 0 rgba(255, 255, 255, 0.3),
                40px 60px 0 0 rgba(255, 255, 255, 0.3),
                60px 20px 0 0 rgba(255, 255, 255, 0.3),
                80px 50px 0 0 rgba(255, 255, 255, 0.3),
                100px 80px 0 0 rgba(255, 255, 255, 0.3),
                120px 40px 0 0 rgba(255, 255, 255, 0.3),
                140px 70px 0 0 rgba(255, 255, 255, 0.3);
            animation: particleFloat 25s linear infinite;
        }

        .particles::after {
            animation-delay: -12.5s;
            box-shadow: 
                10px 40px 0 0 rgba(255, 255, 255, 0.3),
                30px 70px 0 0 rgba(255, 255, 255, 0.3),
                50px 30px 0 0 rgba(255, 255, 255, 0.3),
                70px 60px 0 0 rgba(255, 255, 255, 0.3),
                90px 20px 0 0 rgba(255, 255, 255, 0.3),
                110px 50px 0 0 rgba(255, 255, 255, 0.3),
                130px 80px 0 0 rgba(255, 255, 255, 0.3),
                150px 40px 0 0 rgba(255, 255, 255, 0.3);
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(0) translateX(-10px);
            }
            75% {
                transform: translateY(20px) translateX(5px);
            }
            100% {
                transform: translateY(0) translateX(0);
            }
        }
    </style>
</div>
