<x-layouts.app :title="__('Defect Chart')">

<head>
    <link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">
</head>

<body>
<div >
    <!-- 查詢區塊 -->
    <div class="query-row">
    <div class="field">
        <label>工單</label>
        <input type="text" id="workorder" class="input" style="width:200px;">
    </div>
    <div class="field">
        <label>料號</label>
        <input type="text" id="material" class="input" style="width:200px;">
    </div>
    <div class="field">
        <label>狀態</label>
        <select id="status" class="select" style="width:200px;">
        <option value="">請選擇</option>
        <option value="進行中">進行中</option>
        <option value="已完成">已完成</option>
        </select>
    </div>
    <div class="field">
        <label>機種</label>
        <input type="text" id="model" class="input" style="width:200px;">
    </div>
    </div>

    <div class="query-row">
    <div class="field">
        <label>開始日期</label>
        <input type="date" id="startDate" class="input"
        value="{{ request('start_date') ?? \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
    </div>
    <div class="field">
        <label>結束日期</label>
        <input type="date" id="endDate" class="input"
        value="{{ request('end_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
    </div>
    <div class="field" style="display:flex;align-items:flex-end;gap:12px;">
        <button id="btnApply" class="btn btn-primary">Apply</button>
        <button id="btnReset" class="btn btn-clear">Reset</button>
    </div>
    </div>


    <!-- 第一行 -->
    <div class="chart-row">
        <!-- 工單表格 -->
        <table class="result-table">
            <thead><tr><th>工單編號</th><th>機種</th><th>料號</th><th>工單數</th><th>入庫數</th><th>狀態</th><th>開工日</th><th>完工日</th></tr></thead>
            <tbody id="tableBody"></tbody>
        </table>
        <div id="chart-yield" class="chart-block"></div>
        <div id="chart-cause" class="chart-block"></div>
    </div>

    <!-- 第二行 -->
    <div class="chart-row">
        <div id="chart-percent" class="chart-block"></div>
        <div id="chart-cumulative" class="chart-block"></div>
        <table class="result-table" id="positionTable">
            <thead><tr><th>位置</th><th>反向</th><th>倒置</th><th>短路</th><th>缺件</th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
<script>
    // 模擬資料（之後可改成 Controller 帶入）
    const workOrders = [
        {work_order_code:'240201.8SM', model:'T340-152AB', part_number:'RS-232', work_order_qty:100, stock_qty:95, status:'進行中', start_date:'2026-06-01', completion_date:'2026-06-02'},
        {work_order_code:'240201.8BM', model:'T340-152AB', part_number:'U66零件不良', work_order_qty:200, stock_qty:198, status:'已完成', start_date:'2026-06-03', completion_date:'2026-06-04'}
    ];
    const yieldRecords = [
        {work_order_no:'240201.8SM', production_date:'2026-06-01', order_qty:100, yield_rate:97.3},
        {work_order_no:'240201.8BM', production_date:'2026-06-03', order_qty:200, yield_rate:96.5}
    ];
    const defects = [
        {defect_type:'良品', count:90},
        {defect_type:'不良', count:10}
    ];
    const positions = [
        {defect_position:'U66', count:2},
        {defect_position:'U30', count:1},
        {defect_position:'U64', count:1}
    ];

    function renderTable(data) {
        const tbody = document.getElementById("tableBody");
        tbody.innerHTML = "";
        data.forEach(r=>{
            tbody.innerHTML += `<tr>
                <td>${r.work_order_code}</td>
                <td>${r.model}</td>
                <td>${r.part_number}</td>
                <td>${r.work_order_qty}</td>
                <td>${r.stock_qty}</td>
                <td>${r.status}</td>
                <td>${r.start_date}</td>
                <td>${r.completion_date}</td>
            </tr>`;
        });
    }

    function renderPositionTable(data) {
        const tbody = document.querySelector("#positionTable tbody");
        tbody.innerHTML = "";
        data.forEach(r=>{
            tbody.innerHTML += `<tr>
                <td>${r.defect_position}</td>
                <td>${r.count}</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>`;
        });
    }

    function refreshAllCharts(filters) {
        // 篩選工單
        const filteredOrders = workOrders.filter(row => {
            return (!filters.workorder || row.work_order_code.includes(filters.workorder)) &&
                   (!filters.material  || row.part_number.includes(filters.material)) &&
                   (!filters.status    || row.status === filters.status) &&
                   (!filters.model     || row.model.includes(filters.model)) &&
                   (!filters.startDate || new Date(row.start_date) >= new Date(filters.startDate)) &&
                   (!filters.endDate   || new Date(row.completion_date) <= new Date(filters.endDate));
        });
        renderTable(filteredOrders);

        // 良率追蹤
        const filteredYield = yieldRecords.filter(r=>{
            return (!filters.startDate || new Date(r.production_date) >= new Date(filters.startDate)) &&
                   (!filters.endDate   || new Date(r.production_date) <= new Date(filters.endDate));
        });
        echarts.init(document.getElementById('chart-yield')).setOption({
            title:{text:'測試良率追蹤',left:'center',textStyle:{color:'#fff'}},
            tooltip:{trigger:'axis'},
            legend:{data:['良率','數量'],textStyle:{color:'#fff'}},
            xAxis:{type:'category',data:filteredYield.map(r=>r.work_order_no),axisLabel:{color:'#fff'}},
            yAxis:[
                {type:'value',name:'良率(%)',min:90,max:100,axisLabel:{color:'#fff'}},
                {type:'value',name:'數量',axisLabel:{color:'#fff'}}
            ],
            series:[
                {name:'良率',type:'line',yAxisIndex:0,data:filteredYield.map(r=>r.yield_rate),lineStyle:{color:'#ff0000'}},
                {name:'數量',type:'bar',yAxisIndex:1,data:filteredYield.map(r=>r.order_qty),itemStyle:{color:'#00a2ff'}}
            ]
        });

        // 不良原因比率
        echarts.init(document.getElementById('chart-cause')).setOption({
            title:{text:'不良原因比率',left:'center',textStyle:{color:'#fff'}},
            series:[{type:'pie',radius:'60%',data:defects.map(d=>({value:d.count,name:d.defect_type}))}]
        });

        // 不良百分比一覽表
        echarts.init(document.getElementById('chart-percent')).setOption({
            title:{text:'不良百分比一覽表',left:'center',textStyle:{color:'#fff'}},
            series:[{type:'pie',radius:'65%',data:defects.map(d=>({value:d.count,name:d.defect_type}))}]
        });

        // 不良累积分布圖
        echarts.init(document.getElementById('chart-cumulative')).setOption({
            title:{text:'不良累积分布圖',left:'center',textStyle:{color:'#fff'}},
            xAxis:{type:'category',data:positions.map(p=>p.defect_position),axisLabel:{color:'#fff'}},
            yAxis:[{type:'value',axisLabel:{color:'#fff'}},{type:'value',axisLabel:{color:'#fff'}}],
            series:[
                {type:'bar',data:positions.map(p=>p.count),itemStyle:{color:'#00a2ff'}},
                {type:'line',yAxisIndex:1,data:positions.map(p=>p.count),lineStyle:{color:'#ff0000'}}
            ]
        });

        // 不良位置表格
        renderPositionTable(positions);
    }

    // Apply 綁定
    document.getElementById('btnApply').addEventListener('click', function() {
        const filters = {
            workorder: document.getElementById('workorder').value.trim(),
            material:  document.getElementById('material').value.trim(),
            status:    document.getElementById('status').value.trim(),
            model:     document.getElementById('model').value.trim(),
            startDate: document.getElementById('startDate').value,
            endDate:   document.getElementById('endDate').value
        };
        refreshAllCharts(filters);
    });

    // Reset 綁定
    document.getElementById('btnReset').addEventListener('click', function() {
        // 清空其他欄位
        document.querySelectorAll('.query-section input, .query-section select').forEach(el=>{
            if(el.type !== 'date') el.value='';
        });

        // 重設日期為 Blade 預設（三個月前 ~ 今天）
        const today = new Date();
        const threeMonthsAgo = new Date();
        threeMonthsAgo.setMonth(today.getMonth() - 3);

        document.getElementById('startDate').value = threeMonthsAgo.toISOString().split('T')[0];
        document.getElementById('endDate').value = today.toISOString().split('T')[0];

        // 重新渲染
        refreshAllCharts({});
    });

    // 初始渲染
    window.addEventListener('DOMContentLoaded', () => {
        refreshAllCharts({});
    });
</script>
</body>
</x-layouts.app>