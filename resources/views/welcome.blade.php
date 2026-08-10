<!DOCTYPE html>
<html lang="zh-Hant">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>智能工廠管理系統</title>
<link rel="icon" href="/favicon.ico" />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet" />

<style>
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body {
    font-family:"Microsoft JhengHei", sans-serif;
    margin:0;
    background:linear-gradient(180deg,#0f2c66 0%,#123c81 40%,#0b2554 100%);
    color:#ffffff;
    overflow-x:hidden;
}

/* Header */
header {
    background:linear-gradient(90deg,#1697d9,#d8eefc,#1697d9);
    color:#313a74;
    padding:1rem 2rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-radius:0 0 6px 6px;
}

nav a {
    color:#ffffff;
    margin-left:1rem;
    text-decoration:none;
    font-weight:600;
    transition:transform 0.3s ease, box-shadow 0.3s ease;
}

nav a:hover {
    transform:scale(1.2);
    box-shadow:0 0 12px rgba(0,200,255,0.7);
}

/* 主區塊 */
.wrap {
    display:flex;
    justify-content:center;
    align-items:stretch;
    padding:3rem 2rem;
    gap:2rem;
}

.left {
    flex:2;
    background:linear-gradient(180deg,rgba(20,55,120,.95),rgba(30,55,110,.95));
    border:3px solid #42d9ff;
    box-shadow:0 0 15px rgba(0,255,255,.4);
    border-radius:12px;
    padding:2rem;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.right {
    flex:8;
    background:linear-gradient(180deg,rgba(22,104,170,.85),rgba(10,48,105,.95));
    border:3px solid #228fd3;
    box-shadow:0 0 15px rgba(0,255,255,.4);
    border-radius:12px;
    padding:2rem;
    color:#ffffff;
}

/* 輪播區塊 */
.wrap2 {
    display:flex;
    justify-content:center;
    align-items:stretch;
    padding:3rem 2rem;
    gap:2rem;
    height:350px; /* 原本 340px 改成一半 */
}
.left2, .right2 {
    height:350px; /* 保持一致 */
}


.left2 {
    flex:4;
    overflow:hidden;
}

.left2 img {
    width:100%;
    height:100%;
    object-fit:cover;
    border:3px solid #42d9ff;
    box-shadow:0 0 12px rgba(0,255,255,.4);
}

.right2 {
    flex:6;
    background:linear-gradient(180deg,rgba(22,104,170,.85),rgba(10,48,105,.95));
    border:3px solid #228fd3;
    box-shadow:0 0 15px rgba(0,255,255,.4);
    border-radius:12px;
    padding:2rem;
    color:#ffffff;
}

/* 輪播 */
.carousel {
    position:relative;
    width:100%;
    overflow:hidden;
}

.carousel-track {
    display:flex;
    transition:transform 0.5s ease;
}

.carousel-slide {
    min-width:50%;
    padding:10px;
    position:relative;
}

.carousel-slide img {
    width:100%;
    border:3px solid #42d9ff;
    box-shadow:0 0 12px rgba(0,255,255,.4);
    border-radius:8px;
}

.caption {
    position:absolute;
    bottom:10px;
    left:10px;
    right:10px;
    background:rgba(0,0,0,0.5);
    color:#fff;
    padding:8px 12px;
    border-radius:6px;
    font-size:0.9rem;
}

.carousel-dots {
    display:flex;
    justify-content:center;
    margin-top:10px;
}

.carousel-dot {
    width:10px;
    height:10px;
    border-radius:50%;
    background-color:#ccc;
    margin:0 5px;
    cursor:pointer;
}

.carousel-dot.active {
    background-color:#00a2ff;
}

footer {
    text-align:center;
    padding:2rem;
    background:linear-gradient(90deg,#1697d9,#d8eefc,#1697d9);
    color:#313a74;
    font-size:0.875rem;
    border-radius:6px 6px 0 0;
    position:fixed;   /* 固定位置 */
    bottom:0;         /* 貼在底部 */
    left:0;
    width:100%;       /* 佔滿整個寬度 */
}
#typingText{
    white-space:pre-wrap;
}
</style>
</head>

<body>
<header>
    <h1>智能工廠管理系統</h1>
    <nav>
        @auth
        <script>
            window.location.href = "{{ route('dashboard') }}";
        </script>
        @endauth
        <a href="{{ route('login') }}">Log In</a>
        <a href="{{ route('register') }}">Sign Up</a>
    </nav>
</header>

<div class="wrap">
    <section class="left">
        <img src="{{ asset('assets/images/FITS.png') }}" alt="FITS Icon" style="width:60%;"/>
    </section>
    <section class="right">
        <p id="typingText"></p>
    </section>
</div>

<div class="wrap2">
    <section class="left2">
        <img src="{{ asset('assets/images/Back.png') }}" alt="FITS Full" />
    </section>
    <section class="right2">
        <div class="carousel">
            <div class="carousel-track" id="carouselTrack">
                <div class="carousel-slide"><img src="{{ asset('assets/images/1.jpg') }}" /><div class="caption">Log In</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/2.jpg') }}" /><div class="caption">IC燒錄設備管控</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/3.jpg') }}" /><div class="caption">IC燒錄紀錄查詢</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/4.jpg') }}" /><div class="caption">IC燒錄統計圖表</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/5.jpg') }}" /><div class="caption">Dashboard</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/6.jpg') }}" /><div class="caption">IC燒錄工單查詢</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/7.jpg') }}" /><div class="caption">IC燒錄設備資訊</div></div>
                <div class="carousel-slide"><img src="{{ asset('assets/images/8.jpg') }}" /><div class="caption">Register</div></div>

            </div>
            <div class="carousel-dots" id="carouselDots"></div>
        </div>
    </section>
</div>

<footer>
    © IBASE Technology Inc. All Rights Reserved. 
</footer>

<script>
// 輪播邏輯
const track = document.getElementById('carouselTrack');
const dotsContainer = document.getElementById('carouselDots');
const totalSlides = document.querySelectorAll('.carousel-slide').length;
const slidesPerPage = 2;
const totalPages = Math.ceil(totalSlides / slidesPerPage);
let currentPage = 0;

function updateCarousel() {
    track.style.transform = `translateX(-${currentPage * 100}%)`;
    Array.from(dotsContainer.children).forEach((dot, i) => {
        dot.classList.toggle('active', i === currentPage);
    });
}

for (let i = 0; i < totalPages; i++) {
    const dot = document.createElement('div');
    dot.classList.add('carousel-dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => {
        currentPage = i;
        updateCarousel();
    });
    dotsContainer.appendChild(dot);
}

updateCarousel();
setInterval(() => {
    currentPage = (currentPage + 1) % totalPages;
    updateCarousel();
}, 5000);

// 打字效果
const text = `
FITS — 智能工廠管理系統 🚀
🔗 整合數據｜🔍 全程追溯
📊 智慧決策｜🏭 智能製造
📡 **Factory Integration**：MES、ERP 與產線設備資料即時匯流至中央平台，打破資訊孤島，打造統一且高效的數據中樞。
🔍 **Traceability System**：從原料、製程、生產到出貨，全流程資訊完整記錄，快速追蹤每一項產品歷程，提升品質管理與問題分析效率。
✨ FITS，不只是管理系統，更是企業邁向工業 4.0 與智慧製造的重要引擎，讓每一筆數據創造價值，讓每一道流程更加卓越。
`;

let index = 0;
const typingElement = document.getElementById("typingText");

function typeEffect() {
    if (index < text.length) {
        typingElement.innerHTML += text.charAt(index);
        index++;
        setTimeout(typeEffect, 30); // 每 30ms 打一個字
    }
}
typeEffect();
</script>
</body>
</html>
