<x-layouts.app :title="__('IC Work Detail')">

<link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">

<div id="report-content" >

    <div class="query-section wide">
        <div class="query-box query-main-box">
            <h2>IC燒錄工單資訊頁面</h2>

            <!-- 工單號碼 -->
            <div class="query-row">
                <div class="field">
                    <label>工單號碼</label>
                    <input type="text" id="work_order_no" class="input" style="width:200px;">
                    <button type="button" class="btn btn-primary" onclick="fetchWorkOrder()">查詢</button>
                </div>
            </div>

            <!-- 其他欄位 -->
            <div class="query-row">
                <div class="field"><label>工單數量</label><input type="text" id="quantity" class="input"></div>
                <div class="field"><label>SMT工單</label><input type="text" id="smt_work_order" class="input"></div>
                <div class="field"><label>料號</label><input type="text" id="material_no" class="input"></div>
            </div>

            <div class="query-row">
                <div class="field"><label>開工日期</label><input type="text" id="start_date" class="input" readonly></div>
                <div class="field"><label>品名</label><input type="text" id="product_name" class="input"></div>
                <div class="field"><label>完工日期</label><input type="text" id="completion_date" class="input" readonly></div>
            </div>

            <div class="query-row">
                <div class="field"><label>規格</label><input type="text" id="specification" class="input"></div>
                <div class="field"><label>使用機種</label><input type="text" id="model" class="input"></div>
            </div>

            <div class="query-row">
                <div class="field"><label>IC料號</label><input type="text" id="ic_part_no" class="input"></div>
                <div class="field"><label>封裝方式</label><input type="text" id="package_type" class="input"></div>
                <div class="field"><label>IC廠商</label><input type="text" id="ic_vendor" class="input"></div>
            </div>

            <div class="query-row">
                <div class="field"><label>IC品名</label><input type="text" id="ic_name" class="input"></div>
                <div class="field"><label>Reel ID</label><input type="text" id="reel_id" class="input"></div>
                <div class="field"><label>IC規格</label><input type="text" id="ic_spec" class="input"></div>
            </div>

            <div class="query-row">
                <div class="field"><label>燒錄檔料號</label><input type="text" id="burn_file_no" class="input"></div>
                <div class="field"><label>燒錄檔路徑</label><input type="text" id="program_file_path" class="input"></div>
                <div class="field"><label>燒錄檔檔名</label><input type="text" id="file_name" class="input"></div>
            </div>

            <div class="query-row">
                <div class="field"><label>Checksum</label><input type="text" id="checksum" class="input"></div>
                <button type="button" class="btn btn-secondary" onclick="transferMaterial()">
                    <span style="margin-right:6px;">👉轉料號</span>
                </button>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>

<script>
    function fetchWorkOrder()
    {
        let workOrderNo = document.getElementById('work_order_no').value.trim();

        if (!workOrderNo)
        {
            alert('請輸入工單號碼');
            return;
        }

        fetch('{{ url("api/ic-work-order") }}?work_order_no=' + encodeURIComponent(workOrderNo))
        .then(response =>
        {
            if (!response.ok)
            {
                throw new Error('HTTP Error : ' + response.status);
            }

            return response.json();
        })
        .then(result =>
        {
            if (!result.success)
            {
                alert('查無資料');
                clearForm();
                return;
            }

            let d = result.data;

            // 工單資訊
            document.getElementById('work_order_no').value = d.work_order_no || '';
            document.getElementById('quantity').value = d.quantity || '';
            document.getElementById('smt_work_order').value = d.smt_work_order || '';
            document.getElementById('material_no').value = d.material_no || '';

            document.getElementById('start_date').value = d.start_date || '';
            document.getElementById('completion_date').value = d.completion_date || '';

            document.getElementById('product_name').value = d.product_name || '';
            document.getElementById('specification').value = d.specification || '';
            document.getElementById('model').value = d.model || '';

            // IC資訊
            document.getElementById('ic_part_no').value = d.ic_part_no || '';
            document.getElementById('package_type').value = d.package_type || '';
            document.getElementById('ic_vendor').value = d.ic_vendor || '';

            document.getElementById('ic_name').value = d.ic_name || '';
            document.getElementById('reel_id').value = d.reel_id || '';
            document.getElementById('ic_spec').value = d.ic_spec || '';

            // 燒錄資訊
            document.getElementById('burn_file_no').value = d.burn_file_no || '';
            document.getElementById('program_file_path').value = d.program_file_path || '';
            document.getElementById('file_name').value = d.file_name || '';
            document.getElementById('checksum').value = d.checksum || '';
        })
        .catch(error =>
        {
            console.error(error);
            alert('查詢失敗：' + error.message);
        });
    }

    function clearForm()
    {
        const ids =
        [
            'quantity',
            'smt_work_order',
            'material_no',
            'start_date',
            'completion_date',
            'product_name',
            'specification',
            'model',
            'ic_part_no',
            'package_type',
            'ic_vendor',
            'ic_name',
            'reel_id',
            'ic_spec',
            'burn_file_no',
            'program_file_path',
            'file_name',
            'checksum'
        ];

        ids.forEach(id =>
        {
            const el = document.getElementById(id);

            if (el)
            {
                el.value = '';
            }
        });
    }
</script>