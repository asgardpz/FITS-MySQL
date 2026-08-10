<x-layouts.app :title="__('BurnRecord')">

@if(session('success'))
<script>
alert("{{ session('success') }}");
</script>
@endif

<link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">

<div id="report-content" >
    <div class="top-section">
        <div class="grid">
            <section class="panel devices">
                <div class="monitoring-container">

                    <!-- ====== 查詢條件 ====== -->
                    <div class="query-section wide">
                        <div class="query-main">
                            <div class="query-box query-main-box">
                                IC燒錄記錄查詢頁面

                                <!-- 第一行 -->
                                <div class="query-row">
                                    <div class="field">
                                        <label>料號</label>
                                        <input type="text" name="part_no" class="input" style="width:200px;">
                                    </div>
                                    <div class="field">
                                        <label>工單編號</label>
                                        <input type="text" name="work_order_no" class="input" style="width:200px;">
                                    </div>
                                    <div class="field">
                                        <label>機種</label>
                                        <input type="text" name="model" class="input" style="width:200px;">
                                    </div>
                                </div>

                                <!-- 第二行 -->
                                <div class="query-row">
                                    <div class="field">
                                        <label>治具編號</label>
                                        <input type="text" name="jig_no" class="input" style="width:200px;">
                                    </div>
                                    <div class="field">
                                        <label>狀態</label>
                                        <select name="status" class="select">
                                            <option value="">All</option>
                                            <option value="5.待檢">5.待檢</option>
                                            <option value="6.生產中">6.生產中</option>
                                            <option value="7.入庫">7.入庫</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 第三行 -->
                                <div class="query-row">
                                    <div class="field">
                                        <label>開始日期</label>
                                        <input type="date" name="start_date" class="input"
                                            value="{{ request('start_date') ?? \Carbon\Carbon::now()->subMonths(3)->format('Y-m-d') }}">
                                    </div>
                                    <div class="field">
                                        <label>結束日期</label>
                                        <input type="date" name="end_date" class="input"
                                            value="{{ request('end_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                    <div class="field" style="display:flex;align-items:flex-end;gap:12px;">
                                        <button type="button" class="btn btn-primary" onclick="applyFilters()">Apply</button>
                                        <button type="button" class="btn btn-clear" onclick="resetFilters()">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ====== 表格 ====== -->
                    <table class="device-table fits-table">
                        <thead>
                            <tr>
                                <th onclick="sortTable('production_date')">生產日期<span class="sort-icon" id="sort-production_date"></span></th>
                                <th onclick="sortTable('work_order_no')">工單編號<span class="sort-icon" id="sort-work_order_no"></span></th>
                                <th onclick="sortTable('part_no')">料號<span class="sort-icon" id="sort-part_no"></span></th>
                                <th onclick="sortTable('order_qty')">工單數<span class="sort-icon" id="sort-order_qty"></span></th>
                                <th onclick="sortTable('good_qty')">良品數<span class="sort-icon" id="sort-good_qty"></span></th>
                                <th onclick="sortTable('ng_qty')">不良數<span class="sort-icon" id="sort-ng_qty"></span></th>
                                <th onclick="sortTable('yield_rate')">良率<span class="sort-icon" id="sort-yield_rate"></span></th>
                                <th onclick="sortTable('uph')">UPH<span class="sort-icon" id="sort-uph"></span></th>
                                <th onclick="sortTable('model')">機種<span class="sort-icon" id="sort-model"></span></th>
                                <th onclick="sortTable('jig_no')">治具編號<span class="sort-icon" id="sort-jig_no"></span></th>
                                <th onclick="sortTable('status')">狀態<span class="sort-icon" id="sort-status"></span></th>
                                <th onclick="sortTable('start_time')">開始時間<span class="sort-icon" id="sort-start_time"></span></th>
                                <th onclick="sortTable('end_time')">結束時間<span class="sort-icon" id="sort-end_time"></span></th>
                                <th onclick="sortTable('hours')">時數<span class="sort-icon" id="sort-hours"></span></th>
                            </tr>
                        </thead>
                        <tbody id="deviceTableBody"></tbody>
                    </table>

                    <div id="paginationControls" class="pagination-controls"></div>
                </div>
            </section>
        </div>
    </div>
</div>
</x-layouts.app>

@php
$data = $records->map(function($row){
    return [
        'work_order_no' => (string) $row->work_order_no,
        'production_date' => $row->production_date ? \Carbon\Carbon::parse($row->production_date)->format('Y/m/d') : '',
        'part_no' => (string) $row->part_no,
        'order_qty' => (int) $row->order_qty,
        'good_qty' => (int) $row->good_qty,
        'ng_qty' => (int) $row->ng_qty,
        'yield_rate' => (float) $row->yield_rate,
        'uph' => (float) $row->uph,
        'model' => (string) $row->model,
        'jig_no' => (string) $row->jig_no,
        'status' => (string) $row->status,
        'start_time' => $row->start_time ? \Carbon\Carbon::parse($row->start_time)->format('Y/m/d H:i') : '',
        'end_time' => $row->end_time ? \Carbon\Carbon::parse($row->end_time)->format('Y/m/d H:i') : '',
        'hours' => (float) $row->hours,
    ];
})->values();
@endphp

<script>
const chartData = {!! json_encode($data) !!};
let deviceData = [...chartData];
let filteredData = [...deviceData];
let currentPage = 1;
let pageSize = 4;
let sortField = null;
let sortAsc = true;

function renderTable(data) {
    const tbody = document.getElementById("deviceTableBody");
    tbody.innerHTML = "";
    const start = (currentPage - 1) * pageSize;
    const pageData = data.slice(start, start + pageSize);

    pageData.forEach(row => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${row.production_date}</td>
            <td>${row.work_order_no}</td>
            <td>${row.part_no}</td>
            <td>${row.order_qty}</td>
            <td>${row.good_qty}</td>
            <td>${row.ng_qty}</td>
            <td>${row.yield_rate}</td>
            <td>${row.uph}</td>
            <td>${row.model}</td>
            <td>${row.jig_no}</td>
            <td>${row.status}</td>
            <td>${row.start_time}</td>
            <td>${row.end_time}</td>
            <td>${row.hours}</td>
        `;
        tbody.appendChild(tr);
    });

    renderPagination(data.length);
}

function renderPagination(total) {
    const container = document.getElementById("paginationControls");
    container.innerHTML = "";

    const totalPages = Math.max(1, Math.ceil(total / pageSize));
    const start = Math.max(1, currentPage - 2);
    const end = Math.min(totalPages, currentPage + 2);

    const makeBtn = (label, isActive = false, isDisabled = false, onClick = null) => {
        const b = document.createElement("button");
        b.textContent = label;
        b.style.margin = "0 4px";
        b.style.cursor = isDisabled ? "not-allowed" : "pointer";
        b.style.color = isActive ? "#3b82f6" : "#ffffff";
        if (!isDisabled && onClick) b.onclick = onClick;
        return b;
    };

    container.appendChild(makeBtn("◀︎", false, currentPage <= 1, () => {
        currentPage--;
        renderTable(filteredData);
    }));

    for (let i = start; i <= end; i++) {
        container.appendChild(makeBtn(String(i), i === currentPage, false, () => {
            currentPage = i;
            renderTable(filteredData);
        }));
    }

    container.appendChild(makeBtn("▶︎", false, currentPage >= totalPages, () => {
        currentPage++;
        renderTable(filteredData);
    }));
}

function updateSortIcons() {
    document.querySelectorAll('.sort-icon').forEach(el => el.textContent = '');
    if (sortField) {
        const icon = document.getElementById(`sort-${sortField}`);
        if (icon) icon.textContent = sortAsc ? '▲' : '▼';
    }
}

function sortTable(field) {
    if (sortField === field) sortAsc = !sortAsc;
    else { sortField = field; sortAsc = true; }

    filteredData.sort((a, b) => {
        let A = a[field], B = b[field];

        if (field.includes('date') || field.includes('time')) {
            A = new Date(A);
            B = new Date(B);
        } else if (!isNaN(parseFloat(A)) && !isNaN(parseFloat(B))) {
            A = parseFloat(A);
            B = parseFloat(B);
        } else {
            A = String(A).toLowerCase();
            B = String(B).toLowerCase();
        }

        if (A < B) return sortAsc ? -1 : 1;
        if (A > B) return sortAsc ? 1 : -1;
        return 0;
    });

    currentPage = 1;
    renderTable(filteredData);
    updateSortIcons();
}

function applyFilters() {
    const partNoVal = document.querySelector('input[name="part_no"]').value.trim();
    const workOrderVal = document.querySelector('input[name="work_order_no"]').value.trim();
    const modelVal = document.querySelector('input[name="model"]').value.trim();
    const jigNoVal = document.querySelector('input[name="jig_no"]').value.trim();
    const statusVal = document.querySelector('select[name="status"]').value.trim();
    const startDateVal = document.querySelector('input[name="start_date"]').value;
    const endDateVal = document.querySelector('input[name="end_date"]').value;

    filteredData = deviceData.filter(row => {
        return (!partNoVal || row.part_no.includes(partNoVal)) &&
               (!workOrderVal || row.work_order_no.includes(workOrderVal)) &&
               (!modelVal || row.model.includes(modelVal)) &&
               (!jigNoVal || row.jig_no.includes(jigNoVal)) &&
               (!statusVal || row.status === statusVal) &&
               (!startDateVal || new Date(row.production_date) >= new Date(startDateVal)) &&
               (!endDateVal || new Date(row.production_date) <= new Date(endDateVal));
    });

    currentPage = 1;
    renderTable(filteredData);
}

function resetFilters() {
    document.querySelectorAll('.query-box input, .query-box select').forEach(el => el.value = '');
    const today = new Date();
    const threeMonthsAgo = new Date();
    threeMonthsAgo.setMonth(today.getMonth() - 3);
    document.querySelector('input[name="start_date"]').value = threeMonthsAgo.toISOString().split('T')[0];
    document.querySelector('input[name="end_date"]').value = today.toISOString().split('T')[0];
    filteredData = [...deviceData];
    currentPage = 1;
    renderTable(filteredData);
}

document.querySelector('.btn-primary')?.addEventListener('click', applyFilters);
document.querySelector('.btn-clear')?.addEventListener('click', resetFilters);

renderTable(filteredData);
</script>
