<x-layouts.app :title="__('maintenance')">
  @if(session('success'))
  <script>
      alert("{{ session('success') }}");
  </script>
  @endif

  <link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">

  <div id="report-content" style="padding:24px; box-sizing:border-box; width:100%; margin:0; display:flex; flex-direction:column; gap:24px; background-color:#1a4a9c; color:#e2e8f0;">
      <div class="top-section">
        <div class="grid">
          <section class="panel devices">
            <div class="monitoring-container">
              <!-- ====== 查詢條件 ====== -->
              <div class="query-section wide">
                <div class="query-main">
                  <div class="query-box query-main-box">
                    IC工單查詢頁面

                    <!-- 第一行 -->
                    <div class="query-row">
                      <div class="field">
                        <label>廠別</label>
                        <input type="text" name="factory" class="input" style="width:200px;">
                      </div>
                      <div class="field">
                        <label>料號</label>
                        <input type="text" name="part_number" class="input" style="width:200px;">
                      </div>
                      <div class="field">
                        <label>工單</label>
                        <input type="text" name="work_order_code" class="input" style="width:200px;" list="workOrderOptions">
                      </div>
                    </div>

                    <!-- 第二行 -->
                    <div class="query-row">
                      <div class="field">
                        <label>Reel ID</label>
                        <input type="text" name="reel_id" class="input" style="width:200px;">
                      </div>
                      <div class="field">
                        <label>機種</label>
                        <input type="text" name="model" class="input" style="width:200px;">
                      </div>
                      <div class="field">
                        <label>狀態</label>
                        <select name="status" class="select">
                          <option value="">All</option>
                          <option value="3發放">3發放</option>
                          <option value="7入庫">7入庫</option>
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
                          <th onclick="sortTable('start_date')">開工日<span class="sort-icon" id="sort-start_date"></span></th>
                          <th onclick="sortTable('work_order_code')">工單編號<span class="sort-icon" id="sort-work_order_code"></span></th>
                          <th onclick="sortTable('part_number')">料號<span class="sort-icon" id="sort-part_number"></span></th>
                          <th onclick="sortTable('work_order_qty')">工單數<span class="sort-icon" id="sort-work_order_qty"></span></th>
                          <th onclick="sortTable('stock_qty')">入庫數<span class="sort-icon" id="sort-stock_qty"></span></th>
                          <th onclick="sortTable('status')">狀態<span class="sort-icon" id="sort-status"></span></th>
                          <th onclick="sortTable('completion_date')">完工日<span class="sort-icon" id="sort-completion_date"></span></th>
                          <th onclick="sortTable('model')">機種<span class="sort-icon" id="sort-model"></span></th>
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

<!-- ====== Maintenance Table ====== -->
@php
$data = $work_orders->map(function($row){
    return [
        'work_order_code' => (string) $row->work_order_code,
        'start_date'      => $row->start_date ? \Carbon\Carbon::parse($row->start_date)->format('Y/m/d') : '',
        'part_number'     => (string) $row->part_number,
        'work_order_qty'  => (int) $row->work_order_qty,
        'stock_qty'       => (int) $row->stock_qty,
        'status'          => (string) $row->status,
        'completion_date' => $row->completion_date ? \Carbon\Carbon::parse($row->completion_date)->format('Y/m/d') : '',
        'model'           => (string) $row->model,
    ];
})->values();
@endphp

<!-- ====== Maintenance ====== -->
<script>
  const chartData = {!! json_encode($data) !!};
  let deviceData = [...chartData];
  let filteredData = [...deviceData];
  let currentPage = 1;
  let pageSize = 4;
  let sortField = null;
  let sortAsc = true;
  let activeArrowId = null;

  function clampCurrentPage(totalItems) {
    const totalPages = Math.max(1, Math.ceil(totalItems / pageSize));
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;
    return totalPages;
  }

  function statusClass(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'completed')   return 'tag tag-completed';
    if (s === 'pending')     return 'tag tag-pending';
    if (s === 'in progress') return 'tag tag-inprogress';
    return 'tag tag-default';
  }

  function priorityClass(status) {
    const s = String(status || '').toLowerCase();
    if (s === 'high')   return 'priority priority-high';
    if (s === 'medium') return 'priority priority-medium';
    if (s === 'low')    return 'priority priority-low';
    return 'priority priority-default';
  }

  function renderTable(data) {
    const tbody = document.getElementById("deviceTableBody");
    tbody.innerHTML = "";
    clampCurrentPage(data.length);
    const start = (currentPage - 1) * pageSize;
    const pageData = data.slice(start, start + pageSize);

    pageData.forEach(row => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${row.start_date}</td>
        <td>${row.work_order_code}</td>
        <td>${row.part_number}</td>
        <td>${row.work_order_qty}</td>
        <td>${row.stock_qty}</td>
        <td>${row.status}</td>
        <td>${row.completion_date}</td>
        <td>${row.model}</td>
      `;
      tbody.appendChild(tr);
    });

    renderPagination(data.length);
  }


  function renderPagination(total) {
    const container = document.getElementById("paginationControls");
    container.innerHTML = "";

    // 容器樣式
    Object.assign(container.style, {
      marginTop: "16px",
      display: "flex",
      justifyContent: "center",
      gap: "12px",
      flexWrap: "wrap",
      fontSize: "14px",
      alignItems: "center"
    });

    const totalPages = Math.max(1, Math.ceil(total / pageSize));
    const maxVisible = 5;
    const showEllipsis = totalPages > maxVisible + 2;
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (showEllipsis) {
      if (currentPage <= 3) {
        startPage = 1;
        endPage = maxVisible;
      } else if (currentPage >= totalPages - 2) {
        startPage = totalPages - maxVisible + 1;
        endPage = totalPages;
      }
    }

    // 建立按鈕
    const makeBtn = (label, isActive = false, isDisabled = false, onClick = null, color = "#ffffff") => {
      const b = document.createElement("button");
      b.textContent = label;
      Object.assign(b.style, {
        background: "none",
        border: "none",
        padding: "0",
        margin: "0",
        cursor: isDisabled ? "not-allowed" : "pointer",
        fontSize: "14px",
        lineHeight: "1",
        color: isDisabled ? "#999999" : (isActive ? "#3b82f6" : color),
        textDecoration: isActive ? "underline" : "none",
        fontWeight: isActive ? "500" : "400",
        opacity: isDisabled ? "0.4" : "1"
      });
      if (!isDisabled && onClick) b.onclick = onClick;
      return b;
    };

    const makeEllipsis = () => {
      const s = document.createElement("span");
      s.textContent = "...";
      Object.assign(s.style, {
        color: "#999999",
        fontSize: "14px",
        lineHeight: "1"
      });
      return s;
    };

    // ◀︎ Prev
    container.appendChild(makeBtn("◀︎", false, currentPage <= 1, () => {
      currentPage--;
      renderTable(filteredData);
    }, "#3b82f6"));

    // 頁碼群組
    for (let i = startPage; i <= endPage; i++) {
      container.appendChild(makeBtn(String(i), i === currentPage, false, () => {
        currentPage = i;
        renderTable(filteredData);
      }));
    }

    // ... + 最後一頁
    if (showEllipsis && endPage < totalPages) {
      container.appendChild(makeEllipsis());
      container.appendChild(makeBtn(String(totalPages), totalPages === currentPage, false, () => {
        currentPage = totalPages;
        renderTable(filteredData);
      }));
    }

    // ▶︎ Next
    container.appendChild(makeBtn("▶︎", false, currentPage >= totalPages, () => {
      currentPage++;
      renderTable(filteredData);
    }, "#3b82f6"));

    // Page + Go
    const pageWrapper = document.createElement("div");
    Object.assign(pageWrapper.style, {
      display: "flex",
      alignItems: "center",
      gap: "6px",
      marginLeft: "16px"
    });

    const label = document.createElement("span");
    label.textContent = "Page";
    label.style.color = "#ffffff";

    const input = document.createElement("input");
    input.type = "number";
    input.min = "1";
    input.max = totalPages;
    Object.assign(input.style, {
      width: "60px",
      height: "30px",
      border: "1px solid #475569",
      borderRadius: "4px",
      padding: "0 6px"
    });

    const goBtn = document.createElement("button");
    goBtn.textContent = "Go";
    Object.assign(goBtn.style, {
      backgroundColor: "#3b82f6",
      color: "#fff",
      border: "none",
      borderRadius: "4px",
      padding: "4px 10px",
      cursor: "pointer"
    });
    goBtn.disabled = true;

    // 輸入監聽
    input.addEventListener("input", () => {
      goBtn.disabled = !input.value;
    });

    // Go 按鈕事件
    goBtn.addEventListener("click", () => {
      const pageNum = parseInt(input.value, 10);
      if (!isNaN(pageNum) && pageNum >= 1 && pageNum <= totalPages) {
        currentPage = pageNum;
        renderTable(filteredData);
      }
    });

    pageWrapper.appendChild(label);
    pageWrapper.appendChild(input);
    pageWrapper.appendChild(goBtn);
    container.appendChild(pageWrapper);
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

      // 日期欄位用 Date 比較
      if (field === 'date_time') {
        A = new Date(A);
        B = new Date(B);
      }
      // 數字欄位用 parseFloat
      else if (['kwh','amount'].includes(field)) {
        A = parseFloat(A);
        B = parseFloat(B);
      }
      // 其他字串欄位
      else {
        A = String(A).toLowerCase().trim();
        B = String(B).toLowerCase().trim();
      }

      if (A < B) return sortAsc ? -1 : 1;
      if (A > B) return sortAsc ? 1 : -1;
      return 0;
    });

    currentPage = 1;
    renderTable(filteredData);
    updateSortIcons();
  }


  function bindRowEvents() {
    document.querySelectorAll('.pin-wrapper').forEach(el => {
      el.onclick = () => {
        const id = el.dataset.id;
        toggleArrowRow(id);
      };
    });

    document.querySelectorAll('.stream-btn').forEach(btn => {
      btn.onclick = () => {
        const id = btn.dataset.id;
        openStreamModal(id);
      };
    });
  }

  function applyFilters() {
    const factoryVal     = document.querySelector('input[name="factory"]').value.trim();
    const partNumberVal  = document.querySelector('input[name="part_number"]').value.trim();
    const workOrderVal   = document.querySelector('input[name="work_order_code"]').value.trim();
    const reelIdVal      = document.querySelector('input[name="reel_id"]').value.trim();
    const modelVal       = document.querySelector('input[name="model"]').value.trim();
    const statusVal      = document.querySelector('select[name="status"]').value.trim();
    const startDateVal   = document.querySelector('input[name="start_date"]').value;
    const endDateVal     = document.querySelector('input[name="end_date"]').value;

    filteredData = deviceData.filter(row => {
      return (!factoryVal    || (row.factory && row.factory.includes(factoryVal))) &&
            (!partNumberVal || row.part_number.includes(partNumberVal)) &&
            (!workOrderVal  || row.work_order_code.includes(workOrderVal)) &&
            (!reelIdVal     || (row.reel_id && row.reel_id.includes(reelIdVal))) &&
            (!modelVal      || row.model.includes(modelVal)) &&
            (!statusVal     || row.status === statusVal) &&
            (!startDateVal  || new Date(row.start_date) >= new Date(startDateVal)) &&
            (!endDateVal    || new Date(row.completion_date) <= new Date(endDateVal));
    });

    currentPage = 1;
    renderTable(filteredData);
  }


  // 關閉視窗
  function closeAlert() {
      document.getElementById('customAlert').style.display = 'none';
  }

  // 繼續查詢
  function proceedQuery() {
      document.getElementById('customAlert').style.display = 'none';
      applyFilters(); // 再次執行篩選
  }


  function resetFilters() {
    // 清空所有 input / select
    document.querySelectorAll('.query-box input, .query-box select').forEach(el => el.value = '');

    // 重設日期欄位為預設值（三個月前 ~ 今天）
    const today = new Date();
    const threeMonthsAgo = new Date();
    threeMonthsAgo.setMonth(today.getMonth() - 3);

    document.querySelector('input[name="start_date"]').value = threeMonthsAgo.toISOString().split('T')[0];
    document.querySelector('input[name="end_date"]').value = today.toISOString().split('T')[0];

    // 重置資料
    filteredData = [...deviceData];
    currentPage = 1;
    renderTable(filteredData);
  }



  function changePageSize() {
    const per = document.querySelector('select[name="per_page"]');
    pageSize = parseInt(per ? per.value : 10);
    currentPage = 1;
    renderTable(filteredData);
  }

  document.querySelector('.btn-primary')?.addEventListener('click', applyFilters);
  document.querySelector('.btn-clear')?.addEventListener('click', resetFilters);
  document.querySelector('select[name="per_page"]')?.addEventListener('change', changePageSize);

  renderTable(filteredData);
</script>
