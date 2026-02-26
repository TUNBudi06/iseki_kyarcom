<script lang="ts">
    let { data } = $props();
</script>

<div
    class="relative font-mono bg-white border-[1.6px] border-black"
    style="width:105mm;height:80mm"
>
    <div class="absolute inset-[4mm]">
        <!-- Title -->
        <div
            class="absolute left-0 right-0 top-0 text-center font-bold text-[13.5px]"
        >
            LABEL PALLET ASSY
        </div>

        <!-- Fields -->
        <div class="absolute left-0 right-0" style="top:10mm">
            <div
                class="grid text-[10.5px]"
                style="grid-template-columns: 32mm 1fr; row-gap:1.6mm;"
            >
                <div>Item Code</div>
                <div>: <b>{data.itemCode}</b></div>
                <div>Part Name</div>
                <div>: <b>{data.partName}</b></div>
                <div>Supplier</div>
                <div>: {data.supplier}</div>
                <div>Type</div>
                <div>: {data.type}</div>
                <div>Rack No</div>
                <div>: <b>{data.rackNo}</b></div>
            </div>
        </div>
    </div>
</div>
