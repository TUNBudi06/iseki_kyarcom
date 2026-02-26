<script lang="ts">
    import { routeUrl } from '@tunbudi06/inertia-route-helper';
    import { useForm } from '@inertiajs/svelte';
    import {
        FileDown,
        Upload,
        Tractor,
        CheckCircle2,
        AlertCircle,
        X,
        FileText,
        Loader2,
        RefreshCw,
    } from '@lucide/svelte';
    import * as Card from '$shadcn/components/ui/card/index.ts';
    import * as Table from '$shadcn/components/ui/table/index.ts';
    import { Badge } from '$shadcn/components/ui/badge/index.ts';
    import { Button } from '$shadcn/components/ui/button';
    import { cn } from '$shadcn/utils';
    import { downloadTemplateKyarcom, importKyarcom } from '$routes/kyarcom/index.ts';
    import { untrack } from 'svelte';

    let { today, tractors } = $props();

    // ─── Types ────────────────────────────────────────────────────────────────
    type TractorInventory = {
        name: string;
        unit: number;
        patent: string;
    };

    type TractorUsed = {
        no: string;
        name: string;
    };

    // ─── Inventory master list ─────────────────────────────────────────────
    const tractorInventoryNames: string[] = [
        'SF',
        'MF1E41',
        'MF1E25',
        'MF1E35',
        'MF1E40',
        'MF1GC',
        'MF2E56',
        'MF2E50',
        'MF2E60',
        'NT540',
        'NT548',
        'NT554',
        'SXG2',
        'SXG3',
        'TLE34',
        'TLE455',
        'TXGS',
    ];

    // ─── State ─────────────────────────────────────────────────────────────
    let tractorInventory: TractorInventory[]

    $effect(() => {
        if(tractors) {
            untrack(()=>{

            })
        } else {
            untrack(() => {
                tractorInventory = tractorInventoryNames.map((name) => ({
                    name,
                    unit: 0,
                    patent: '',
                }));
            });
        }
    });

    let tractorsUsed: TractorUsed[] = $state([]);
    let tractorsNotInList: TractorUsed[] = $state([]);
    let totalUnits = $derived(
        tractorInventory.reduce((sum, t) => sum + t.unit, 0),
    );

    // Import state
    let fileInput: HTMLInputElement = $state(null!);
    let isDragging = $state(false);
    let importStatus: 'idle' | 'loading' | 'success' | 'error' = $state('idle');
    let importMessage = $state('');
    let selectedFileName = $state('');
    let showImportPanel = $state(false);

    // ─── Form ──────────────────────────────────────────────────────────────
    const form = useForm({
        file: null as File | null,
        timestamp: new Date().toISOString(),   // always today; parsed to Y-m-d on the server
    });

    // ─── Handlers ──────────────────────────────────────────────────────────
    function downloadTemplate() {
        window.location.href = routeUrl(downloadTemplateKyarcom());
    }

    function openFilePicker() {
        fileInput?.click();
    }

    function handleFileChange(event: Event) {
        const target = event.target as HTMLInputElement;
        const file = target.files?.[0];
        if (file) processFile(file);
    }

    function handleDrop(event: DragEvent) {
        event.preventDefault();
        isDragging = false;
        const file = event.dataTransfer?.files?.[0];
        if (file) processFile(file);
    }

    function handleDragOver(event: DragEvent) {
        event.preventDefault();
        isDragging = true;
    }

    function handleDragLeave() {
        isDragging = false;
    }

    function processFile(file: File) {
        const allowedTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'text/csv',
        ];

        if (!allowedTypes.includes(file.type)) {
            importStatus = 'error';
            importMessage =
                'Format file tidak didukung. Gunakan .xlsx, .xls, atau .csv';
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            importStatus = 'error';
            importMessage = 'Ukuran file terlalu besar. Maksimal 10MB.';
            return;
        }

        selectedFileName = file.name;
        $form.file = file;
        importStatus = 'idle';
        importMessage = '';
    }

    function handleImport() {
        if (!$form.file) {
            importStatus = 'error';
            importMessage = 'Pilih file terlebih dahulu.';
            return;
        }

        importStatus = 'loading';

        $form.post(routeUrl(importKyarcom()), {
            forceFormData: true,
            onSuccess: () => {
                importStatus = 'success';
                importMessage = 'Data berhasil diimport!';
                selectedFileName = '';
                $form.file = null;
                setTimeout(() => {
                    showImportPanel = false;
                    importStatus = 'idle';
                }, 1500);
            },
            onError: (errors) => {
                importStatus = 'error';
                importMessage =
                    Object.values(errors)[0] ??
                    'Terjadi kesalahan saat import.';
            },
        });
    }

    function resetImport() {
        selectedFileName = '';
        $form.file = null;
        importStatus = 'idle';
        importMessage = '';
        if (fileInput) fileInput.value = '';
    }

    function getUnitBadgeVariant(unit: number) {
        if (unit === 0) return 'destructive';
        if (unit < 2) return 'outline';
        return 'default';
    }

    function getUnitBadgeClass(unit: number) {
        if (unit < 2 && unit > 0)
            return 'border-amber-500 text-amber-600 dark:text-amber-400';
        return '';
    }
</script>

<!-- ═══════════════════════════════════════════════════════════════════════════
     ROOT LAYOUT
     ═══════════════════════════════════════════════════════════════════════════ -->
<div
    class="min-h-screen bg-linear-to-br from-slate-50 via-slate-50 to-slate-100 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900 p-4 md:p-6 lg:p-8"
>
    <div class="mx-auto max-w-7xl space-y-5">
        <!-- ── Header Card ─────────────────────────────────────────────── -->
        <Card.Root
            class="border-none shadow-xl bg-white/90 backdrop-blur-sm dark:bg-slate-900/90 overflow-hidden"
        >
            <!-- decorative top bar -->
            <div
                class="h-1 w-full bg-linear-to-r from-primary via-primary/70 to-primary/30"
            ></div>
            <Card.Header class="pb-4 pt-5">
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                >
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary shadow-inner"
                        >
                            <Tractor class="h-6 w-6" />
                        </div>
                        <div>
                            <Card.Title class="text-xl font-bold tracking-tight"
                                >Tractor Import Handler</Card.Title
                            >
                            <Card.Description class="text-sm mt-0.5">
                                Manage inventory, track usage, and handle patent
                                records
                            </Card.Description>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        <!-- Template Download -->
                        <Button
                            variant="outline"
                            class="gap-2 h-9 text-sm font-medium border-slate-200 hover:border-primary/40 hover:bg-primary/5 transition-all"
                            onclick={downloadTemplate}
                        >
                            <FileDown class="h-4 w-4" />
                            <span>Download Template</span>
                        </Button>

                        <!-- Import Toggle -->
                        <Button
                            class={cn(
                                'gap-2 h-9 text-sm font-medium shadow-md transition-all',
                                showImportPanel
                                    ? 'bg-slate-700 hover:bg-slate-800 shadow-slate-400/20'
                                    : 'bg-linear-to-r from-primary to-primary/85 shadow-primary/20 hover:shadow-primary/40 hover:shadow-lg',
                            )}
                            onclick={() => {
                                showImportPanel = !showImportPanel;
                                resetImport();
                            }}
                        >
                            {#if showImportPanel}
                                <X class="h-4 w-4" />
                                <span>Tutup</span>
                            {:else}
                                <Upload class="h-4 w-4" />
                                <span>Import Data</span>
                            {/if}
                        </Button>
                    </div>
                </div>
            </Card.Header>
        </Card.Root>

        <!-- ── Import Panel (collapsible) ─────────────────────────────── -->
        {#if showImportPanel}
            <Card.Root
                class="border-none shadow-lg bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm overflow-hidden transition-all"
            >
                <div
                    class="h-0.5 w-full bg-linear-to-r from-blue-400 to-indigo-400"
                ></div>
                <Card.Header
                    class="py-4 border-b border-slate-100 dark:border-slate-800"
                >
                    <Card.Title
                        class="text-base font-semibold flex items-center gap-2"
                    >
                        <Upload class="h-4 w-4 text-blue-500" />
                        Import File Data Tractor
                    </Card.Title>
                </Card.Header>
                <Card.Content class="p-5">
                    <div class="flex flex-col md:flex-row gap-5">
                        <!-- Drop zone -->
                        <button
                            class={cn(
                                'flex-1 flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed p-8 text-center cursor-pointer transition-all select-none',
                                isDragging
                                    ? 'border-primary bg-primary/5 scale-[0.99]'
                                    : 'border-slate-200 dark:border-slate-700 hover:border-primary/50 hover:bg-slate-50 dark:hover:bg-slate-800/50',
                                importStatus === 'error'
                                    ? 'border-red-300 bg-red-50/50 dark:border-red-800 dark:bg-red-900/10'
                                    : '',
                                importStatus === 'success'
                                    ? 'border-emerald-300 bg-emerald-50/50 dark:border-emerald-800 dark:bg-emerald-900/10'
                                    : '',
                            )}
                            ondrop={handleDrop}
                            ondragover={handleDragOver}
                            ondragleave={handleDragLeave}
                            onclick={openFilePicker}
                            tabindex="0"
                            onkeydown={(e) =>
                                e.key === 'Enter' && openFilePicker()}
                            aria-label="Upload file area"
                            type="button"
                        >
                            <input
                                bind:this={fileInput}
                                type="file"
                                accept=".xlsx,.xls,.csv"
                                class="hidden"
                                onchange={handleFileChange}
                            />

                            {#if importStatus === 'success'}
                                <div
                                    class="h-12 w-12 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center"
                                >
                                    <CheckCircle2
                                        class="h-6 w-6 text-emerald-600 dark:text-emerald-400"
                                    />
                                </div>
                                <p
                                    class="text-sm font-semibold text-emerald-600 dark:text-emerald-400"
                                >
                                    {importMessage}
                                </p>
                            {:else if importStatus === 'error'}
                                <div
                                    class="h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center"
                                >
                                    <AlertCircle class="h-6 w-6 text-red-500" />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-semibold text-red-500"
                                    >
                                        Error
                                    </p>
                                    <p class="text-xs text-red-400 mt-0.5">
                                        {importMessage}
                                    </p>
                                </div>
                            {:else if selectedFileName}
                                <div
                                    class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center"
                                >
                                    <FileText class="h-6 w-6 text-primary" />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-semibold text-slate-700 dark:text-slate-200 max-w-50 truncate"
                                    >
                                        {selectedFileName}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Klik untuk ganti file
                                    </p>
                                </div>
                            {:else}
                                <div
                                    class="h-12 w-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center"
                                >
                                    <Upload class="h-5 w-5 text-slate-400" />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-slate-600 dark:text-slate-300"
                                    >
                                        Drag & drop atau <span
                                            class="text-primary font-semibold"
                                            >klik untuk pilih file</span
                                        >
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Mendukung .xlsx, .xls, .csv — maks. 10MB
                                    </p>
                                </div>
                            {/if}
                        </button>

                        <!-- Action panel -->
                        <div
                            class="flex flex-col justify-between gap-4 md:w-56"
                        >
                            <div class="space-y-2">
                                <div
                                    class="rounded-lg bg-slate-50 dark:bg-slate-800/50 p-3 text-xs text-slate-500 dark:text-slate-400 space-y-1"
                                >
                                    <p
                                        class="font-semibold text-slate-600 dark:text-slate-300 text-[11px] uppercase tracking-wide mb-2"
                                    >
                                        Panduan
                                    </p>
                                    <p>1. Download template terlebih dahulu</p>
                                    <p>2. Isi data sesuai format kolom</p>
                                    <p>3. Upload file yang sudah diisi</p>
                                    <p>4. Klik tombol Import</p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                {#if selectedFileName}
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        class="gap-1.5 h-9 text-xs border-slate-200"
                                        onclick={resetImport}
                                    >
                                        <RefreshCw class="h-3.5 w-3.5" />
                                        Reset
                                    </Button>
                                {/if}
                                <Button
                                    class={cn(
                                        'flex-1 gap-2 h-9 text-sm font-medium transition-all',
                                        !selectedFileName ||
                                            importStatus === 'loading'
                                            ? 'opacity-60 cursor-not-allowed'
                                            : 'shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30',
                                    )}
                                    disabled={!selectedFileName ||
                                        importStatus === 'loading'}
                                    onclick={handleImport}
                                >
                                    {#if importStatus === 'loading'}
                                        <Loader2 class="h-4 w-4 animate-spin" />
                                        <span>Mengimpor...</span>
                                    {:else}
                                        <Upload class="h-4 w-4" />
                                        <span>Import</span>
                                    {/if}
                                </Button>
                            </div>
                        </div>
                    </div>
                </Card.Content>
            </Card.Root>
        {/if}

        <!-- ── 3-Column Data Grid ───────────────────────────────────────── -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
            <!-- Col 1: Inventory List -->
            <Card.Root
                class="border-none shadow-lg overflow-hidden flex flex-col"
                style="height: calc(100vh - 280px); min-height: 400px;"
            >
                <Card.Header
                    class="bg-slate-50/80 dark:bg-slate-800/30 border-b border-slate-100 dark:border-slate-800 py-3 px-4 shrink-0"
                >
                    <Card.Title
                        class="text-sm font-semibold flex items-center gap-2"
                    >
                        <Tractor class="h-4 w-4 text-primary" />
                        <span>Inventory List</span>
                        <Badge
                            variant="secondary"
                            class="ml-auto text-xs font-semibold"
                        >
                            {tractorInventoryNames.length} types
                        </Badge>
                    </Card.Title>
                </Card.Header>
                <Card.Content class="p-0 flex-1 overflow-auto">
                    <Table.Root>
                        <Table.Header
                            class="sticky top-0 bg-white dark:bg-slate-900 shadow-sm z-10"
                        >
                            <Table.Row
                                class="hover:bg-transparent border-b border-slate-100 dark:border-slate-800"
                            >
                                <Table.Head
                                    class="w-28 font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5 px-4"
                                    >Name</Table.Head
                                >
                                <Table.Head
                                    class="w-16 font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5"
                                    >Unit</Table.Head
                                >
                                <Table.Head
                                    class="font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5"
                                    >Patent</Table.Head
                                >
                            </Table.Row>
                        </Table.Header>
                        <Table.Body>
                            {#each tractorInventory as tractor, i (tractor.name)}
                                <Table.Row
                                    class={cn(
                                        'transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/40 border-b border-slate-50 dark:border-slate-800/50',
                                        i % 2 === 0
                                            ? ''
                                            : 'bg-slate-50/40 dark:bg-slate-800/20',
                                    )}
                                >
                                    <Table.Cell
                                        class="font-mono text-xs font-semibold text-slate-700 dark:text-slate-300 py-2.5 px-4"
                                    >
                                        {tractor.name}
                                    </Table.Cell>
                                    <Table.Cell class="py-2.5">
                                        <Badge
                                            variant={getUnitBadgeVariant(
                                                tractor.unit,
                                            )}
                                            class={cn(
                                                'text-xs font-semibold min-w-8 justify-center',
                                                getUnitBadgeClass(tractor.unit),
                                            )}
                                        >
                                            {tractor.unit}
                                        </Badge>
                                    </Table.Cell>
                                    <Table.Cell
                                        class="text-xs text-slate-500 dark:text-slate-400 py-2.5 font-mono"
                                    >
                                        {tractor.patent}
                                    </Table.Cell>
                                </Table.Row>
                            {/each}
                        </Table.Body>
                    </Table.Root>

                    <!-- Sticky footer total -->
                    <div
                        class="sticky bottom-0 bg-white dark:bg-slate-900 border-t-2 border-slate-200 dark:border-slate-700 px-4 py-2.5 flex items-center justify-between"
                    >
                        <span
                            class="text-xs font-bold uppercase tracking-wide text-slate-500"
                            >Total Units</span
                        >
                        <Badge class="font-bold text-sm">{totalUnits}</Badge>
                    </div>
                </Card.Content>
            </Card.Root>

            <!-- Col 2: Tractors In Use -->
            <Card.Root
                class="border-none shadow-lg overflow-hidden flex flex-col"
                style="height: calc(100vh - 280px); min-height: 400px;"
            >
                <Card.Header
                    class="bg-emerald-50/80 dark:bg-emerald-900/10 border-b border-emerald-100 dark:border-emerald-900/30 py-3 px-4 shrink-0"
                >
                    <Card.Title
                        class="text-sm font-semibold flex items-center gap-2 text-emerald-700 dark:text-emerald-400"
                    >
                        <CheckCircle2 class="h-4 w-4" />
                        <span>In Use</span>
                        <Badge
                            variant="secondary"
                            class="ml-auto text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300"
                        >
                            {tractorsUsed.length}
                        </Badge>
                    </Card.Title>
                </Card.Header>
                <Card.Content class="p-0 flex-1 overflow-auto">
                    {#if tractorsUsed.length === 0}
                        <div
                            class="flex flex-col items-center justify-center h-full gap-3 text-slate-400 p-8"
                        >
                            <div
                                class="h-14 w-14 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center"
                            >
                                <Tractor
                                    class="h-7 w-7 text-slate-300 dark:text-slate-600"
                                />
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-slate-500">
                                    Belum ada data
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Import file untuk melihat data
                                </p>
                            </div>
                        </div>
                    {:else}
                        <Table.Root>
                            <Table.Header
                                class="sticky top-0 bg-white dark:bg-slate-900 shadow-sm z-10"
                            >
                                <Table.Row
                                    class="hover:bg-transparent border-b border-slate-100 dark:border-slate-800"
                                >
                                    <Table.Head
                                        class="w-24 font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5 px-4"
                                        >No</Table.Head
                                    >
                                    <Table.Head
                                        class="font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5"
                                        >Name</Table.Head
                                    >
                                </Table.Row>
                            </Table.Header>
                            <Table.Body>
                                {#each tractorsUsed as tractor, i (tractor.no)}
                                    <Table.Row
                                        class={cn(
                                            'transition-colors hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 border-b border-slate-50 dark:border-slate-800/50',
                                            i % 2 === 0
                                                ? ''
                                                : 'bg-slate-50/40 dark:bg-slate-800/20',
                                        )}
                                    >
                                        <Table.Cell
                                            class="font-mono text-xs font-medium text-slate-500 py-2.5 px-4"
                                        >
                                            {tractor.no}
                                        </Table.Cell>
                                        <Table.Cell
                                            class="text-sm font-semibold text-slate-700 dark:text-slate-200 py-2.5"
                                        >
                                            {tractor.name}
                                        </Table.Cell>
                                    </Table.Row>
                                {/each}
                            </Table.Body>
                        </Table.Root>
                    {/if}
                </Card.Content>
            </Card.Root>

            <!-- Col 3: Not In List -->
            <Card.Root
                class="border-none shadow-lg overflow-hidden flex flex-col"
                style="height: calc(100vh - 280px); min-height: 400px;"
            >
                <Card.Header
                    class="bg-amber-50/80 dark:bg-amber-900/10 border-b border-amber-100 dark:border-amber-900/30 py-3 px-4 shrink-0"
                >
                    <Card.Title
                        class="text-sm font-semibold flex items-center gap-2 text-amber-700 dark:text-amber-400"
                    >
                        <AlertCircle class="h-4 w-4" />
                        <span>Not Listed</span>
                        <Badge
                            variant="secondary"
                            class="ml-auto text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300"
                        >
                            {tractorsNotInList.length}
                        </Badge>
                    </Card.Title>
                </Card.Header>
                <Card.Content class="p-0 flex-1 overflow-auto">
                    {#if tractorsNotInList.length === 0}
                        <div
                            class="flex flex-col items-center justify-center h-full gap-3 text-slate-400 p-8"
                        >
                            <div
                                class="h-14 w-14 rounded-full bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center"
                            >
                                <CheckCircle2
                                    class="h-7 w-7 text-amber-200 dark:text-amber-800"
                                />
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-slate-500">
                                    Semua terdaftar
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Tidak ada data di luar list
                                </p>
                            </div>
                        </div>
                    {:else}
                        <Table.Root>
                            <Table.Header
                                class="sticky top-0 bg-white dark:bg-slate-900 shadow-sm z-10"
                            >
                                <Table.Row
                                    class="hover:bg-transparent border-b border-slate-100 dark:border-slate-800"
                                >
                                    <Table.Head
                                        class="w-24 font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5 px-4"
                                        >No</Table.Head
                                    >
                                    <Table.Head
                                        class="font-semibold text-xs text-slate-500 uppercase tracking-wide py-2.5"
                                        >Name</Table.Head
                                    >
                                </Table.Row>
                            </Table.Header>
                            <Table.Body>
                                {#each tractorsNotInList as tractor (tractor.no)}
                                    <Table.Row
                                        class="transition-colors hover:bg-amber-50/50 dark:hover:bg-amber-900/10 border-b border-slate-50 dark:border-slate-800/50 bg-amber-50/20 dark:bg-amber-900/5"
                                    >
                                        <Table.Cell
                                            class="font-mono text-xs font-medium text-amber-600/70 dark:text-amber-500/70 py-2.5 px-4"
                                        >
                                            {tractor.no}
                                        </Table.Cell>
                                        <Table.Cell
                                            class="text-sm font-semibold text-amber-700 dark:text-amber-300 py-2.5"
                                        >
                                            {tractor.name}
                                        </Table.Cell>
                                    </Table.Row>
                                {/each}
                            </Table.Body>
                        </Table.Root>
                    {/if}
                </Card.Content>
            </Card.Root>
        </div>
        <!-- end grid -->
    </div>
</div>
