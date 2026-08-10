<x-layouts.app :title="__('IC Burn Operations')">

<link rel="stylesheet" href="{{ asset('css/fits.css') }}?v={{ time() }}">

<div id="report-content" >

    <div class="query-section wide">
        <div class="query-box query-main-box">
            <h2>IC燒錄設備操作管控頁面</h2>
            <!-- 中間二個區塊 -->
            <div class="query-row" style="display:flex; gap:24px;">
                <!-- 左邊區塊 -->
                <div class="query-left">
                    <div class="query-row">
                        <div class="field"><label>Reel ID</label><input type="text" id="reel_id" class="input"></div>
                        <div class="field"><label>數量</label><input type="text" id="quantity" class="input"></div>
                    </div>
                    <div class="query-row">
                        <div class="field"><label>IC料號</label><input type="text" id="ic_part_no" class="input"></div>
                    </div>
                    <div class="query-row">
                        <div class="field"><label>IC品名</label><input type="text" id="ic_name" class="input"></div>
                        <div class="field"><label>IC規格</label><input type="text" id="ic_spec" class="input"></div>
                    </div>
                    <div class="query-row">
                        <div class="field"><label>封裝方式</label><input type="text" id="package_type" class="input"></div>
                        <div class="field"><label>IC廠商</label><input type="text" id="ic_vendor" class="input"></div>
                    </div>
                    <div class="query-row">
                        <div class="field"><label>料槍規格</label><input type="text" id="gun_spec" class="input"></div>
                        <div class="field"><label>治具規格</label><input type="text" id="jig_spec" class="input"></div>
                    </div>  
                    <div class="query-row">
                        <div class="field"><label>料帶規格</label><input type="text" id="tape_spec" class="input"></div>
                    </div>                    
                </div>
                <!-- 右邊區塊 -->
                <div style="flex:1; display:flex; flex-direction:column; gap:12px;">
                    <div class="field">
                        <label>工單號碼</label>
                        <input type="text" id="work_order" class="input" style="width:200px;">
                        <button type="button" class="btn btn-primary" onclick="fetchWorkOrder()">查詢</button>
                    </div>
                    <div class="field"><label>料槍編號</label><input type="text" id="gun_id" class="input"></div>
                    <div class="field"><label>ZF料號</label><input type="text" id="zf_part_no" class="input"></div>                    
                    <div class="field"><label>治具編號</label><input type="text" id="jig_id" class="input"></div>
                    <div class="field"><label>料帶編號</label><input type="text" id="tape_id" class="input"></div>
                </div>
            </div>
            <!-- 左邊區塊 -->
            <div style="flex:2; display:flex; flex-direction:column; gap:12px;">
                <!-- 上面一行 -->
                <div class="query-row">
                    <div class="field"><label>燒錄檔料號</label><input type="text" id="burn_file_no" class="input"></div>
                    <div class="field"><label>燒錄檔路徑</label><input type="text" id="burn_file_path" class="input"></div>
                </div>
                <div class="query-row">
                    <div class="field"><label>燒錄檔檔名</label><input type="text" id="burn_file_name" class="input"></div>
                                        <div class="field"><label>Checksum</label><input type="text" id="checksum" class="input"></div>
                    <button type="button" class="btn btn-success" onclick="startBurn()">
                        <span style="margin-right:6px;">👉開始</span>
                    </button>
                </div>
            
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
<script>
    function fetchWorkOrder() {
        let workOrder = document.getElementById('work_order').value.trim();
        if (!workOrder) {
            alert('請輸入工單號碼');
            return;
        }

        fetch('{{ url("api/ic-burn-operations") }}?work_order=' + encodeURIComponent(workOrder))
        .then(response => response.json())
        .then(result => {
            if (!result.success) {
                alert('查無資料');
                clearForm();
                return;
            }
            let d = result.data;
            // 填入資料
            document.getElementById('work_order').value = d.work_order || '';
            document.getElementById('reel_id').value = d.reel_id || '';
            document.getElementById('quantity').value = d.quantity || '';
            document.getElementById('ic_part_no').value = d.ic_part_no || '';
            document.getElementById('zf_part_no').value = d.zf_part_no || '';
            document.getElementById('ic_name').value = d.ic_name || '';
            document.getElementById('gun_id').value = d.gun_id || '';
            document.getElementById('ic_spec').value = d.ic_spec || '';
            document.getElementById('jig_id').value = d.jig_id || '';
            document.getElementById('package_type').value = d.package_type || '';
            document.getElementById('tape_id').value = d.tape_id || '';
            document.getElementById('ic_vendor').value = d.ic_vendor || '';
            document.getElementById('gun_spec').value = d.gun_spec || '';
            document.getElementById('jig_spec').value = d.jig_spec || '';
            document.getElementById('tape_spec').value = d.tape_spec || '';
            document.getElementById('burn_file_no').value = d.burn_file_no || '';
            document.getElementById('burn_file_path').value = d.burn_file_path || '';
            document.getElementById('burn_file_name').value = d.burn_file_name || '';
            document.getElementById('checksum').value = d.checksum || '';
        })
        .catch(error => {
            console.error(error);
            alert('查詢失敗：' + error.message);
        });
    }

    function clearForm() {
        const ids = [
            'reel_id','quantity','ic_part_no','zf_part_no','ic_name','gun_id',
            'ic_spec','jig_id','package_type','tape_id','ic_vendor','gun_spec',
            'jig_spec','tape_spec','burn_file_no','burn_file_path','burn_file_name','checksum'
        ];
        ids.forEach(id => document.getElementById(id).value = '');
    }

    function startBurn() {
        alert('開始燒錄流程！');
        // 這裡可以加上 AJAX 呼叫或後端 API 觸發燒錄邏輯
    }
</script>
