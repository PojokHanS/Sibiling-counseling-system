<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SIBILING UBBG | Layanan Konseling Mahasiswa</title>
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
  <style>
    :root {
      --primary-green: #2E8B57;
      --primary-light: #3CB371;
      --primary-dark: #23865F;
      --primary-darker: #1A6B4B;
      --bg-cream: #FFFCF9;
      --bg-green-light: #EAF7F2;
      --bg-green-lighter: #F0FAF7;
      --text-dark: #1A1A1A;
      --text-gray: #4A4A4A;
      --text-light: #9E9E9E;
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.06);
      --shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-cream);
      color: var(--text-dark);
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* === Enhanced Background Shapes === */
    .bg-shapes {
      position: fixed;
      inset: 0;
      z-index: -1;
      overflow: hidden;
    }

    .shape-top-right {
      position: absolute;
      top: -15%;
      right: -10%;
      width: 60%;
      height: 50%;
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-green) 100%);
      border-bottom-left-radius: 60% 40%;
      opacity: 0.08;
      animation: float 8s ease-in-out infinite;
    }

    .shape-bottom-left {
      position: absolute;
      bottom: -15%;
      left: -10%;
      width: 60%;
      height: 50%;
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
      border-top-right-radius: 60% 40%;
      opacity: 0.08;
      animation: float 10s ease-in-out infinite reverse;
    }

    .shape-center {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 40%;
      height: 40%;
      background: linear-gradient(135deg, var(--bg-green-light) 0%, var(--bg-green-lighter) 100%);
      border-radius: 50%;
      opacity: 0.05;
      animation: pulse 6s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(1deg); }
    }

    @keyframes pulse {
      0%, 100% { opacity: 0.05; transform: translate(-50%, -50%) scale(1); }
      50% { opacity: 0.08; transform: translate(-50%, -50%) scale(1.1); }
    }

    /* === Enhanced Main Container === */
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 2rem 1.5rem;
      gap: 3rem;
      position: relative;
    }

    /* === Enhanced Logo === */
    .logo {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 2rem;
      animation: slideDown 0.8s ease-out;
    }

    .logo-img {
      width: 3.5rem;
      height: 3.5rem;
      filter: drop-shadow(var(--shadow-sm));
      transition: transform 0.3s ease;
    }

    .logo-img:hover {
      transform: scale(1.1) rotate(5deg);
    }

    .logo-text {
      font-size: 2rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.5px;
    }

    /* === Enhanced Content === */
    .content {
      text-align: center;
      max-width: 600px;
      animation: slideUp 0.8s 0.2s both;
    }

    h1 {
      font-size: 3rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 1.5rem;
      background: linear-gradient(135deg, var(--text-dark) 0%, var(--primary-dark) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .subtitle {
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--primary-green);
      margin-bottom: 1.5rem;
      letter-spacing: -0.2px;
    }

    .desc {
      font-size: 1.1rem;
      color: var(--text-gray);
      margin-bottom: 3rem;
      line-height: 1.7;
    }

    /* === Enhanced Button === */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
      color: white;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.2rem;
      padding: 1.25rem 2.5rem;
      border-radius: 1rem;
      box-shadow: var(--shadow-md);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .btn:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lg);
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn:active {
      transform: translateY(-1px);
    }

    .btn-icon {
      width: 1.25rem;
      height: 1.25rem;
      transition: transform 0.3s ease;
    }

    .btn:hover .btn-icon {
      transform: translateX(3px);
    }

    /* === Enhanced Illustration === */
    .illustration {
      display: flex;
      justify-content: center;
      align-items: center;
      animation: slideUp 0.8s 0.4s both;
    }

    .illustration-img {
      width: 100%;
      max-width: 400px;
      height: auto;
      filter: drop-shadow(var(--shadow-lg));
      transition: transform 0.5s ease;
    }

    .illustration-img:hover {
      transform: scale(1.05) rotate(1deg);
    }

    /* === Animations === */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* === Enhanced Mobile Responsive === */
    @media (max-width: 767px) {
      .container {
        padding: 1.5rem 1rem;
        gap: 2rem;
        min-height: 100dvh;
      }

      .logo {
        margin-bottom: 1.5rem;
      }

      .logo-img {
        width: 3rem;
        height: 3rem;
      }

      .logo-text {
        font-size: 1.75rem;
      }

      h1 {
        font-size: 2.2rem;
        margin-bottom: 1rem;
      }

      .subtitle {
        font-size: 1.2rem;
        margin-bottom: 1rem;
      }

      .desc {
        font-size: 1rem;
        margin-bottom: 2.5rem;
      }

      .btn {
        font-size: 1.1rem;
        padding: 1.1rem 2.2rem;
        border-radius: 0.875rem;
      }

      .illustration-img {
        max-width: 280px;
      }

      .shape-top-right,
      .shape-bottom-left {
        opacity: 0.06;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 1rem 0.75rem;
        gap: 1.5rem;
      }

      .logo {
        gap: 0.75rem;
        margin-bottom: 1rem;
      }

      .logo-img {
        width: 2.5rem;
        height: 2.5rem;
      }

      .logo-text {
        font-size: 1.5rem;
      }

      h1 {
        font-size: 1.8rem;
      }

      .subtitle {
        font-size: 1.1rem;
      }

      .desc {
        font-size: 0.95rem;
        margin-bottom: 2rem;
      }

      .btn {
        font-size: 1rem;
        padding: 1rem 2rem;
      }

      .illustration-img {
        max-width: 240px;
      }
    }

    @media (max-width: 360px) {
      h1 {
        font-size: 1.6rem;
      }
      
      .subtitle {
        font-size: 1rem;
      }
      
      .desc {
        font-size: 0.9rem;
      }
    }

    /* === Enhanced Desktop Layout === */
    @media (min-width: 1024px) {
      .container {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 0 4rem;
        gap: 4rem;
      }

      .content {
        text-align: left;
        flex: 1;
        max-width: none;
        animation: slideRight 0.8s 0.2s both;
      }

      .illustration {
        flex: 1;
        justify-content: flex-end;
        animation: slideLeft 0.8s 0.4s both;
      }

      h1 {
        font-size: 4rem;
      }

      .subtitle {
        font-size: 1.6rem;
      }

      .desc {
        font-size: 1.2rem;
        max-width: 500px;
      }

      .illustration-img {
        max-width: 600px;
      }

      @keyframes slideRight {
        from {
          opacity: 0;
          transform: translateX(-50px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      @keyframes slideLeft {
        from {
          opacity: 0;
          transform: translateX(50px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }
    }

    @media (min-width: 1440px) {
      .container {
        padding: 0 6rem;
        gap: 6rem;
      }

      h1 {
        font-size: 4.5rem;
      }

      .subtitle {
        font-size: 1.8rem;
      }

      .desc {
        font-size: 1.3rem;
        max-width: 550px;
      }

      .illustration-img {
        max-width: 700px;
      }
    }

    @media (min-width: 1920px) {
      .container {
        padding: 0 8rem;
        max-width: 1800px;
        margin: 0 auto;
      }

      h1 {
        font-size: 5rem;
      }

      .illustration-img {
        max-width: 800px;
      }
    }

    /* === Reduced Motion Support === */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }
  </style>
</head>

<body>
  <div class="bg-shapes">
    <div class="shape-top-right"></div>
    <div class="shape-bottom-left"></div>
    <div class="shape-center"></div>
  </div>

  <div class="container">
    <div class="content">
      <div class="logo">
        <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG" class="logo-img">
        <span class="logo-text">SIBILING</span>
      </div>
      <h1>Selamat Datang di SIBILING UBBG</h1>
      <p class="subtitle">Layanan Konseling Mahasiswa Universitas Bina Bangsa Getsempena</p>
      <p class="desc">
        Kami hadir untuk mendampingi mahasiswa menghadapi berbagai tantangan akademik, pribadi, dan karier.  
        Dapatkan ruang curhat yang aman, nyaman, dan penuh empati bersama konselor profesional kami.
      </p>
      <a href="{{ route('login') }}" class="btn">
        Mari Konseling
        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>

    <div class="illustration">
      <img src="{{ asset('images/konseling.png') }}" alt="Ilustrasi Konseling" class="illustration-img">
    </div>
  </div>

  <script>
    // Enhanced interactive effects
    document.addEventListener('DOMContentLoaded', function() {
      const btn = document.querySelector('.btn');
      const illustration = document.querySelector('.illustration-img');
      
      // Button ripple effect
      btn.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = btn.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
          position: absolute;
          width: ${size}px;
          height: ${size}px;
          background: rgba(255,255,255,0.3);
          border-radius: 50%;
          top: ${y}px;
          left: ${x}px;
          animation: ripple 0.6s ease-out;
          pointer-events: none;
        `;
        
        btn.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
      });

      // Add CSS for ripple animation
      const style = document.createElement('style');
      style.textContent = `
        @keyframes ripple {
          from { transform: scale(0); opacity: 1; }
          to { transform: scale(2); opacity: 0; }
        }
      `;
      document.head.appendChild(style);
    });
  </script>
</body>
</html>