<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>FITS - App</title>

<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>

<link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">
</head>

<body x-data="{ isDark:false, settingsOpen:false }" :class="{ 'dark': isDark }">
<div class="dashboard">
    <div class="header-top">
        <div class="logo" style="padding:80px;">
          <a href="https://www.ibase.com.tw/"><img src="{{ asset('assets/images/ibase-logo.svg') }}" style="transform: scale(0.8); display:block; margin:auto;"></a>
        </div>
        <div class="title-cn">
          智能工廠管理系統
            <!-- 圖片按鈕 -->
            <button @click="settingsOpen = true"
                    style="margin-left:20px; padding:0; background:none; border:none; cursor:pointer;">
                <img src="{{ asset('assets/images/FITS.png') }}" alt="設定" class="fits-btn" >
            </button>
            <style>
            .fits-btn {
              width: 100px;
              height: 50px;
              transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .fits-btn:hover {
              transform: scale(1.5);
              bo
              x-shadow: 0 0 12px rgba(0, 200, 255, 0.7);
            }
            </style>          
        </div>
        
        <div class="factory">
          廣積科技平鎮廠
          <!-- Logout -->
          <a href="{{ route('logout') }}" role="menuitem"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="menu-icon-box">
              <!-- SVG Icon -->
              <svg class="logout-icon" xmlns="http://www.w3.org/2000/svg" width="46" height="46"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <!-- 門框 -->
                <path d="M3 3h12v18H3z"/>
                <!-- 箭頭 -->
                <path d="M13 12h8m-4-4l4 4-4 4"/>
              </svg>
            </span>

          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>

        </div>
    </div>

    <div class="header-en">
      Factory Integration Traceability System
    </div>

    <!-- 主內容區塊 -->
    <div class="main-slot">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </div>
</div>

<!-- Settings Panel -->
<div x-show="settingsOpen" class="settings-panel" @click.away="settingsOpen=false">
     <h2 style="font-size:20px; font-weight:bold; margin-bottom:15px; display:flex; align-items:center; justify-content:space-between;color:#ff0000">
      Dashboard
        <a href="{{ route('dashboard') }}" class="menu-item {{ Request::is('dashboard*') ? 'active' : '' }}">
          <span class="menu-icon-box">
            <svg width="48" height="48" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M31.1912 6.40256C28.9654 4.17668 25.8955 2.83694 22.5016 2.76566C21.9005 2.7527 21.3611 3.18686 21.3611 3.80246V15.1894C21.3611 15.7645 21.8276 16.2295 22.4027 16.2295H33.7897C34.36 16.2295 34.8265 15.7564 34.8265 15.1878C34.8265 11.7534 33.4366 8.64788 31.1896 6.40094L31.1912 6.40256Z"/>
              <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M33.3428 17.8639H19.7299V4.24945C19.7299 3.67921 19.2569 3.21265 18.6882 3.21265C14.3531 3.21265 10.4295 4.96873 7.59125 7.80535C1.47089 13.9257 1.47089 23.879 7.59125 29.9993C14.3855 36.7936 25.7612 35.7973 31.3518 28.1704C33.2375 25.5994 34.3131 22.4291 34.3779 18.9995C34.3893 18.3985 33.9551 17.8607 33.3411 17.8607L33.3428 17.8639ZM29.6767 26.944C24.8248 33.5617 14.959 34.4252 9.06221 28.53C3.75023 23.2164 3.75023 14.5915 9.06221 9.27955C11.2978 7.04395 14.3061 5.58109 17.6466 5.32675V18.904C17.6466 19.4791 18.1131 19.944 18.6866 19.944H32.2638C32.0662 22.549 31.1347 24.9514 29.6751 26.944H29.6767Z"/>
            </svg>
          </span>
        </a>
     </h2>
  <div x-data="{ openMenu:true }">
    <h2 style="font-size:20px; font-weight:bold; margin-bottom:15px; display:flex; align-items:center; justify-content:space-between;color:#ff0000">
      IC燒錄功能清單
        <button @click="openMenu = !openMenu"
                style="background:none; border:none; cursor:pointer; margin-left:10px;color:#ffffff">
        <svg x-show="!openMenu" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
        <svg x-show="openMenu" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 15l7-7 7 7" />
        </svg>
        </button>
    </h2>

    <div x-show="openMenu" style="margin-bottom:20px;" x-transition>
      <nav class="menu">
          <a href="{{ route('WorkOrderSearch') }}"><img src="{{ asset('assets/images/Query.jpg') }}" title="IC燒錄工單查詢" class="menu-icon"></a>
          <a href="{{ route('IcWorkDetail') }}"><img src="{{ asset('assets/images/Detail.jpg') }}"  title="IC燒錄工單資訊" class="menu-icon"></a>
          <a href="{{ route('IcBurnOperations') }}"><img src="{{ asset('assets/images/IC_Check.jpg') }}"  title="IC燒錄設備操作管控" class="menu-icon"></a>
          <a href="{{ route('BurnRecord') }}"><img src="{{ asset('assets/images/IC_Query.jpg') }}" title="IC燒錄記錄查詢" class="menu-icon"></a>
          <a href="{{ route('Defect') }}"><img src="{{ asset('assets/images/IC_Chart.jpg') }}" title="IC燒錄統計圖表" class="menu-icon"></a>
      </nav>
    </div>
  </div>
</div>
</body>
</html>
