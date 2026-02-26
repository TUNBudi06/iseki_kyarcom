<script lang="ts">
    let { data } = $props();
</script>

<div
    class="relative font-mono bg-white border-[1.6px] border-black"
    style="width:95mm;height:55mm"
>
    <!-- Padding frame -->
    <div class="absolute inset-[2mm]">
        <!-- Header -->
        <div
            class="absolute left-0 top-0 right-0 flex justify-between items-start"
        >
            <div class="font-bold text-[10.5px] leading-[1.1]">
                LABEL KECIL RACK SUB PERAKITAN ASSY
            </div>

            <div class="text-right text-[9px] leading-[1.1]">
                <div>Rack <b>{data.rack}</b></div>
                <div>{data.category}</div>
            </div>
        </div>

        <!-- Table Frame -->
        <div
            class="absolute left-0 right-0 border border-black"
            style="top:9mm;height:40mm"
        >
            <!-- Column headers -->
            <div
                class="grid border-b border-black text-[8.5px] font-bold"
                style="grid-template-columns: 6mm 36mm 1fr 8mm; height:6mm;"
            >
                <div
                    class="border-r border-black flex items-center justify-center"
                >
                    No
                </div>
                <div
                    class="border-r border-black flex items-center justify-center"
                >
                    ITEM CODE
                </div>
                <div
                    class="border-r border-black flex items-center justify-center"
                >
                    PART NAME
                </div>
                <div class="flex items-center justify-center">QTY</div>
            </div>

            <!-- Rows -->
            <div class="text-[8.2px]" style="line-height:4mm;">
                {#each data.rows as row}
                    <div
                        class="grid border-b border-black"
                        style="grid-template-columns: 6mm 36mm 1fr 8mm; height:4mm;"
                    >
                        <div
                            class="border-r border-black flex items-center justify-center"
                        >
                            {row.no}
                        </div>
                        <div
                            class="border-r border-black px-[1mm] flex items-center"
                        >
                            {row.code}
                        </div>
                        <div
                            class="border-r border-black px-[1mm] flex items-center truncate"
                        >
                            {row.name}
                        </div>
                        <div class="flex items-center justify-center">
                            {row.qty}
                        </div>
                    </div>
                {/each}
            </div>
        </div>
    </div>
</div>
