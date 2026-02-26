<script lang="ts">
    let { data } = $props();
</script>

<div
    class="relative font-mono bg-white border-[1.6px] border-black"
    style="width:105mm;height:70mm"
>
    <div class="absolute inset-[4mm]">
        <!-- Title -->
        <div
            class="absolute left-0 right-0 top-0 text-center font-bold text-[13.5px]"
        >
            LABEL RACK ASSY
        </div>

        <!-- Fields -->
        <div class="absolute left-0 right-0" style="top:10mm">
            <div
                class="grid text-[10.5px]"
                style="grid-template-columns: 28mm 1fr; row-gap:1.4mm;"
            >
                <div>Rack No</div>
                <div>: <b>{data.rackNo}</b></div>
                <div>Remark</div>
                <div>: {data.remark}</div>
                <div>Code</div>
                <div>: <b>{data.code}</b></div>
                <div>Name</div>
                <div>: <b>{data.name}</b></div>
                <div>Type</div>
                <div>: {data.type}</div>
            </div>
        </div>

        <!-- Footer -->
        <div
            class="absolute left-0 right-0 border-t border-black pt-[1mm] text-[9.5px]"
            style="bottom:0mm"
        >
            Supplier : <b>{data.supplier}</b>
        </div>
    </div>
</div>
