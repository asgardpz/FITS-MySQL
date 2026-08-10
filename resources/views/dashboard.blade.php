<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>

<x-layouts.app :title="__('Dashboard')">
    <link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">
    <!-- KPI -->
    <div class="kpi-row">
        <div class="panel" style="position:relative; overflow:hidden;">
            <!-- 背景 SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.648 391.648"
                style="position:absolute; inset:0; width:100%; height:100%; opacity:0.15; z-index:0;">
                <path fill="#ffffff" d="M43.069,260.824c-4.424-5.571-11.252-9.149-18.919-9.149C10.812,251.675,0,262.488,0,275.824
                    c0,13.338,10.813,24.15,24.15,24.15c7.667,0,14.495-3.578,18.919-9.15h32.672v-30H43.069z M43.069,180.825c-4.424-5.572-11.252-9.15-18.919-9.15
                    C10.812,171.675,0,182.488,0,195.824c0,13.338,10.813,24.15,24.15,24.15c7.667,0,14.495-3.578,18.919-9.15h32.672v-30H43.069z 
                    M43.069,100.825c-4.424-5.572-11.252-9.15-18.919-9.15C10.812,91.675,0,102.488,0,115.825s10.813,24.15,24.15,24.15
                    c7.667,0,14.495-3.578,18.919-9.15h32.672v-30H43.069z M348.579,290.824c4.424,5.572,11.252,9.15,18.919,9.15
                    c13.338,0,24.15-10.812,24.15-24.15c0-13.336-10.813-24.149-24.15-24.149c-7.667,0-14.495,3.578-18.919,9.149h-32.672v30H348.579z 
                    M348.579,210.824c4.424,5.572,11.252,9.15,18.919,9.15c13.338,0,24.15-10.812,24.15-24.15c0-13.336-10.813-24.149-24.15-24.149
                    c-7.667,0-14.495,3.578-18.919,9.15h-32.672v30H348.579z M348.579,130.825c4.424,5.572,11.252,9.15,18.919,9.15
                    c13.338,0,24.15-10.813,24.15-24.15s-10.813-24.15-24.15-24.15c-7.667,0-14.495,3.578-18.919,9.15h-32.672v30H348.579z 
                    M274.617,34.938H117.031c-8.284,0-15,6.716-15,15v291.773c0,8.285,6.716,15,15,15h157.587c8.284,0,15-6.715,15-15V49.938
                    C289.617,41.654,282.902,34.938,274.617,34.938z M248.824,85.704c-6.352,0-11.5-5.148-11.5-11.5s5.148-11.5,11.5-11.5
                    s11.5,5.148,11.5,11.5S255.176,85.704,248.824,85.704z"/>
            </svg>
            <div class="panel-title">今日工單量</div>
            <div class="total-power">
                <span class="value">{{ $todayOrders }}</span>
                <span class="unit">(Pcs)</span>
            </div>
        </div>
        <div class="panel" style="position:relative; overflow:hidden;">
            <!-- 背景 SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.648 391.648"
                style="position:absolute; inset:0; width:100%; height:100%; opacity:0.15; z-index:0;">
                <path fill="#ffffff" d="M43.069,260.824c-4.424-5.571-11.252-9.149-18.919-9.149C10.812,251.675,0,262.488,0,275.824
                    c0,13.338,10.813,24.15,24.15,24.15c7.667,0,14.495-3.578,18.919-9.15h32.672v-30H43.069z M43.069,180.825c-4.424-5.572-11.252-9.15-18.919-9.15
                    C10.812,171.675,0,182.488,0,195.824c0,13.338,10.813,24.15,24.15,24.15c7.667,0,14.495-3.578,18.919-9.15h32.672v-30H43.069z 
                    M43.069,100.825c-4.424-5.572-11.252-9.15-18.919-9.15C10.812,91.675,0,102.488,0,115.825s10.813,24.15,24.15,24.15
                    c7.667,0,14.495-3.578,18.919-9.15h32.672v-30H43.069z M348.579,290.824c4.424,5.572,11.252,9.15,18.919,9.15
                    c13.338,0,24.15-10.812,24.15-24.15c0-13.336-10.813-24.149-24.15-24.149c-7.667,0-14.495,3.578-18.919,9.149h-32.672v30H348.579z 
                    M348.579,210.824c4.424,5.572,11.252,9.15,18.919,9.15c13.338,0,24.15-10.812,24.15-24.15c0-13.336-10.813-24.149-24.15-24.149
                    c-7.667,0-14.495,3.578-18.919,9.15h-32.672v30H348.579z M348.579,130.825c4.424,5.572,11.252,9.15,18.919,9.15
                    c13.338,0,24.15-10.813,24.15-24.15s-10.813-24.15-24.15-24.15c-7.667,0-14.495,3.578-18.919,9.15h-32.672v30H348.579z 
                    M274.617,34.938H117.031c-8.284,0-15,6.716-15,15v291.773c0,8.285,6.716,15,15,15h157.587c8.284,0,15-6.715,15-15V49.938
                    C289.617,41.654,282.902,34.938,274.617,34.938z M248.824,85.704c-6.352,0-11.5-5.148-11.5-11.5s5.148-11.5,11.5-11.5
                    s11.5,5.148,11.5,11.5S255.176,85.704,248.824,85.704z"/>
            </svg>
            <div class="panel-title">今日產量</div>
            <div class="max-demand">
                <div class="a1">OK-{{ $todayOk }}</div>
                <div class="a2">NG-{{ $todayNg }}</div>
                <div class="kw">(Pcs)</div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="chart-panel">
        <div id="chart"></div>
    </div>

    <!-- Scripts -->
    <script>
        var chart = echarts.init(document.getElementById('chart'));
        chart.setOption({
            backgroundColor:'transparent',
            legend:{ top:'2%', textStyle:{color:'#ffffff',fontSize:'clamp(12px, 2vw, 18px)'} },
            tooltip:{ trigger:'axis' },
            grid:{ left:'7%', right:'7%', top:'15%', bottom:'15%' },
            xAxis:{
                type:'category',
                data:@json($chartLabels),
                axisLabel:{ color:'#ffffff', fontSize:'clamp(12px, 2vw, 18px)', margin:20 },
                axisTick:{ show:true, length:8, lineStyle:{ color:'#8fb8e8' }},
                axisLine:{ lineStyle:{ color:'#8fb8e8' }},
            },
            yAxis:[
                { type:'value', max:12000, axisLabel:{ color:'#ffffff', formatter:'{value} Pcs', fontSize:'clamp(12px, 2vw, 18px)' }, splitLine:{ lineStyle:{ color:'#8fb8e8' }} },
                { type:'value', max:1200, axisLabel:{ color:'#ffffff', formatter:'{value} Pcs', fontSize:'clamp(12px, 2vw, 18px)' }, splitLine:{ show:false } }
            ],
            series:[
                { name:'當日最大NG', type:'bar', stack:'demand', data:@json($chartData['ng']), itemStyle:{ color:'#00a2ff' }},
                { name:'當日最大OK', type:'bar', stack:'demand', data:@json($chartData['ok']), itemStyle:{ color:'#7cff00' }},
                { name:'當日最大總產量', type:'bar', stack:'demand', data:@json($chartData['total']), itemStyle:{ color:'#ffb02e' }},
                { name:'當日總產量', type:'line', yAxisIndex:1, symbolSize:10,
                  lineStyle:{ width:3, color:'#1eff59' }, itemStyle:{ color:'#1eff59' },
                  data:@json($chartData['line']) }
            ]
        });
        window.addEventListener('resize',()=>chart.resize());
    </script>
</x-layouts.app>
