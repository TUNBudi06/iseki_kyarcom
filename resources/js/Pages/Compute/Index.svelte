<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import {
        AlertCircle,
        ChevronsUpDownIcon,
        CheckIcon,
        PlusIcon,
        CopyIcon,
        CalendarIcon,
        XIcon,
        SparklesIcon,
        FileTextIcon,
    } from '@lucide/svelte';
    import { routeUrl } from '@tunbudi06/inertia-route-helper';
    import { onMount } from 'svelte';
    import { quintOut } from 'svelte/easing';
    import { slide, fade } from 'svelte/transition';
    import Layout from '$/Layouts/Navbar.svelte';
    import HandleTractorsImport from '$/pages/Compute/HandleTractorsImport.svelte';
    import { cn } from '$lib/utils';
    import { kyarcomDataStore } from '$routes/kyarcom';
    import * as Alert from '$shadcn/components/ui/alert/index.ts';
    import { Button } from '$shadcn/components/ui/button';
    import * as Card from '$shadcn/components/ui/card/index.ts';
    import * as Command from '$shadcn/components/ui/command/index.ts';
    import { Input } from '$shadcn/components/ui/input';
    import { Label } from '$shadcn/components/ui/label';
    import * as Popover from '$shadcn/components/ui/popover/index.ts';

    let { list, today,tractors } = $props();

    let alertOpen = $state(false);
    let open = $state(false);
    let triggerRef: HTMLButtonElement | null = $state(null);

    // Form states
    let createName = $state('');
    let createDate = $state(new Date().toISOString().split('T')[0]); // Default to today

    let copyName = $state('');
    let copyDateValue = $state('');

    let isCreating = $state(false);
    let isCopying = $state(false);

    const selectedCopyDate = $derived.by(() => {
        return list.find((item) => item.date === copyDateValue);
    });

    const selectedCopyValue = $derived.by(() => {
        return selectedCopyDate ? selectedCopyDate.name : null;
    });

    function closeAndFocusTrigger() {
        open = false;
        triggerRef?.focus();
    }

    const formCreate = useForm({
        name: '',
        date: '',
    });

    const formCopy = useForm({
        name: '',
        from_date: '',
        to_date: new Date().toISOString().split('T')[0], // Default to today for copy target
    });

    function handleCreateNew() {
        if (!createName.trim()) return;

        isCreating = true;
        $formCreate.name = createName;
        $formCreate.date = createDate;

        $formCreate.post(routeUrl(kyarcomDataStore()), {
            onFinish: () => {
                isCreating = false;
                createName = '';
            },
        });
    }

    function handleCopy() {
        if (!copyName.trim() || !copyDateValue) return;

        isCopying = true;
        $formCopy.name = copyName;
        $formCopy.from_date = copyDateValue;

        // $formCopy.post(routeUrl(), {
        //     onFinish: () => {
        //         isCopying = false;
        //         copyName = "";
        //         copyDateValue = "";
        //     }
        // });
    }

    function formatRelativeDate(dateStr: string) {
        const date = new Date(dateStr);
        const today = new Date();
        const diffTime = today.getTime() - date.getTime();
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays === 0) return 'Today';
        if (diffDays === 1) return 'Yesterday';
        if (diffDays < 7) return `${diffDays} days ago`;
        if (diffDays < 30) return `${Math.floor(diffDays / 7)} weeks ago`;
        return date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
        });
    }

    onMount(() => {
        if (!today) {
            alertOpen = true;
        }
    });
</script>

<svelte:head>
    <title>Dashboard | Daily Kyarya Management</title>
</svelte:head>

<Layout>
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900 p-6 md:p-8"
    >
        <!--        however this the adding page but i dont use copy for now-->
        {#if !today}
            <div class="mx-auto max-w-5xl space-y-6">
                <!-- Page Header -->
                <div class="space-y-1" in:fade={{ duration: 300 }}>
                    <h1
                        class="text-3xl font-bold tracking-tight text-slate-900 dark:text-slate-100"
                    >
                        Daily Kyarya Management
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Manage your Kyarya records efficiently
                    </p>
                </div>

                <!-- Alert Banner -->
                {#if alertOpen}
                    <div
                        class="relative overflow-hidden rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/20 dark:border-amber-800/30 shadow-sm"
                        transition:slide={{ duration: 300, easing: quintOut }}
                    >
                        <div
                            class="absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-amber-400 to-orange-500"
                        ></div>
                        <div
                            class="flex items-start justify-between p-4 md:p-5"
                        >
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400 shadow-sm"
                                >
                                    <AlertCircle class="h-5 w-5" />
                                </div>
                                <div class="space-y-1">
                                    <h3
                                        class="font-semibold text-amber-900 dark:text-amber-100"
                                    >
                                        No Data for Today
                                    </h3>
                                    <p
                                        class="text-sm leading-relaxed text-amber-700/80 dark:text-amber-300/80 max-w-md"
                                    >
                                        You haven't created any data for today
                                        yet. Choose to start fresh or copy from
                                        a previous day to get started quickly.
                                    </p>
                                </div>
                            </div>
                            <Button
                                variant="ghost"
                                size="icon"
                                onclick={() => (alertOpen = false)}
                                class="shrink-0 text-amber-700 hover:text-amber-800 hover:bg-amber-100 dark:text-amber-400 dark:hover:bg-amber-900/30"
                            >
                                <XIcon class="h-4 w-4" />
                            </Button>
                        </div>
                    </div>
                {/if}

                <!-- Main Action Cards -->
                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Create New Card -->
                    <Card.Root
                        class="group relative overflow-hidden border-slate-200/60 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:shadow-xl hover:shadow-primary/5 hover:border-primary/20 dark:bg-slate-950/50 dark:border-slate-800"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        ></div>
                        <Card.Header class="relative space-y-4 pb-2">
                            <div class="flex items-start justify-between">
                                <div
                                    class="inline-flex rounded-2xl bg-primary/10 p-3 text-primary ring-4 ring-primary/5 transition-transform duration-300 group-hover:scale-110"
                                >
                                    <PlusIcon class="h-6 w-6" />
                                </div>
                                <div
                                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400"
                                >
                                    New Entry
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Card.Title
                                    class="text-xl font-bold text-slate-900 dark:text-slate-100"
                                    >Create New Data</Card.Title
                                >
                                <Card.Description
                                    class="text-sm leading-relaxed"
                                >
                                    Start fresh with a new Kyarya entry. The
                                    date defaults to today.
                                </Card.Description>
                            </div>
                        </Card.Header>
                        <Card.Content class="relative space-y-4">
                            <!-- Name Input -->
                            <div class="space-y-2">
                                <Label
                                    for="create-name"
                                    class="text-sm font-medium text-slate-700 dark:text-slate-300"
                                >
                                    Entry Name <span class="text-red-500"
                                        >*</span
                                    >
                                </Label>
                                <div class="relative">
                                    <FileTextIcon
                                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                                    />
                                    <Input
                                        id="create-name"
                                        type="text"
                                        placeholder="e.g., Morning Routine, Work Tasks..."
                                        bind:value={createName}
                                        class="pl-10 border-slate-300 bg-white/70 focus:border-primary focus:ring-primary/20 dark:border-slate-700 dark:bg-slate-900/50"
                                    />
                                </div>
                            </div>

                            <!-- Date Input (Default Today) -->
                            <div class="space-y-2">
                                <Label
                                    for="create-date"
                                    class="text-sm font-medium text-slate-700 dark:text-slate-300"
                                >
                                    Date
                                </Label>
                                <div class="relative">
                                    <CalendarIcon
                                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                                    />
                                    <Input
                                        id="create-date"
                                        type="date"
                                        bind:value={createDate}
                                        class="pl-10 border-slate-300 bg-white/70 focus:border-primary focus:ring-primary/20 dark:border-slate-700 dark:bg-slate-900/50"
                                    />
                                </div>
                                <p class="text-xs text-muted-foreground">
                                    Defaults to today: {new Date().toLocaleDateString(
                                        'en-US',
                                        {
                                            weekday: 'long',
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric',
                                        },
                                    )}
                                </p>
                            </div>
                        </Card.Content>
                        <Card.Footer class="relative pt-2">
                            <Button
                                class="w-full gap-2 bg-gradient-to-r from-primary to-primary/90 text-primary-foreground shadow-lg shadow-primary/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary/30 hover:scale-[1.02] disabled:opacity-50"
                                onclick={handleCreateNew}
                                disabled={isCreating || !createName.trim()}
                            >
                                {#if isCreating}
                                    <div
                                        class="h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"
                                    ></div>
                                    Creating...
                                {:else}
                                    <SparklesIcon class="h-4 w-4" />
                                    Create New Entry
                                {/if}
                            </Button>
                        </Card.Footer>
                    </Card.Root>

                    <!-- Copy From Previous Card -->
                    <Card.Root
                        class="group relative overflow-hidden border-slate-200/60 bg-white/80 backdrop-blur-sm transition-all duration-300 hover:shadow-xl hover:shadow-secondary/5 hover:border-secondary/20 dark:bg-slate-950/50 dark:border-slate-800"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-secondary/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        ></div>
                        <Card.Header class="relative space-y-4 pb-2">
                            <div
                                class="inline-flex rounded-2xl bg-secondary/80 p-3 text-secondary-foreground ring-4 ring-secondary/10 transition-transform duration-300 group-hover:scale-110"
                            >
                                <CopyIcon class="h-6 w-6" />
                            </div>
                            <div class="space-y-2">
                                <Card.Title
                                    class="text-xl font-bold text-slate-900 dark:text-slate-100"
                                    >Copy From Previous</Card.Title
                                >
                                <Card.Description
                                    class="text-sm leading-relaxed"
                                >
                                    Duplicate an existing entry with a new name
                                    for today.
                                </Card.Description>
                            </div>
                        </Card.Header>
                        <Card.Content class="relative space-y-4">
                            <!-- Name Input for Copy -->
                            <div class="space-y-2">
                                <Label
                                    for="copy-name"
                                    class="text-sm font-medium text-slate-700 dark:text-slate-300"
                                >
                                    New Entry Name <span class="text-red-500"
                                        >*</span
                                    >
                                </Label>
                                <div class="relative">
                                    <FileTextIcon
                                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                                    />
                                    <Input
                                        id="copy-name"
                                        type="text"
                                        placeholder="e.g., Today's Tasks (Copy)..."
                                        bind:value={copyName}
                                        class="pl-10 border-slate-300 bg-white/70 focus:border-secondary focus:ring-secondary/20 dark:border-slate-700 dark:bg-slate-900/50"
                                    />
                                </div>
                            </div>

                            <!-- Date Dropdown (Source Selection) -->
                            <div class="space-y-2">
                                <Label
                                    class="text-sm font-medium text-slate-700 dark:text-slate-300"
                                >
                                    Select Source Date <span
                                        class="text-red-500">*</span
                                    >
                                </Label>
                                <Popover.Root bind:open>
                                    <Popover.Trigger bind:ref={triggerRef}>
                                        {#snippet child({ props })}
                                            <Button
                                                {...props}
                                                variant="outline"
                                                class="w-full justify-between border-slate-300 bg-white/50 px-4 py-6 text-left font-normal transition-all hover:bg-white hover:border-slate-400 dark:border-slate-700 dark:bg-slate-900/50 dark:hover:bg-slate-900 dark:hover:border-slate-600 {copyDateValue
                                                    ? 'border-secondary/50 ring-2 ring-secondary/10'
                                                    : ''}"
                                                role="combobox"
                                                aria-expanded={open}
                                            >
                                                <div
                                                    class="flex items-center gap-2"
                                                >
                                                    <CalendarIcon
                                                        class="h-4 w-4 text-muted-foreground"
                                                    />
                                                    <span
                                                        class={copyDateValue
                                                            ? 'font-medium text-foreground'
                                                            : 'text-muted-foreground'}
                                                    >
                                                        {selectedCopyValue ||
                                                            'Select a previous date...'}
                                                    </span>
                                                </div>
                                                <ChevronsUpDownIcon
                                                    class="h-4 w-4 shrink-0 text-muted-foreground"
                                                />
                                            </Button>
                                        {/snippet}
                                    </Popover.Trigger>
                                    <Popover.Content
                                        class="w-[--radix-popover-trigger-width] p-0"
                                        align="start"
                                    >
                                        <Command.Root
                                            class="rounded-lg border-0"
                                        >
                                            <Command.Input
                                                placeholder="Search previous dates..."
                                                class="border-0 border-b border-slate-200 px-4 py-3 dark:border-slate-700"
                                            />
                                            <Command.List
                                                class="max-h-[300px] overflow-auto p-2"
                                            >
                                                <Command.Empty
                                                    class="py-6 text-center text-sm text-muted-foreground"
                                                >
                                                    <div
                                                        class="flex flex-col items-center gap-2"
                                                    >
                                                        <CalendarIcon
                                                            class="h-8 w-8 text-slate-300"
                                                        />
                                                        <p>
                                                            No previous dates
                                                            found
                                                        </p>
                                                    </div>
                                                </Command.Empty>
                                                <Command.Group>
                                                    <div
                                                        class="px-2 py-1.5 text-xs font-semibold text-muted-foreground uppercase tracking-wider"
                                                    >
                                                        Available Dates
                                                    </div>
                                                    {#each list as l (l.index)}
                                                        <Command.Item
                                                            value={l.date}
                                                            onSelect={() => {
                                                                copyDateValue =
                                                                    l.date;
                                                                closeAndFocusTrigger();
                                                            }}
                                                            class="flex items-center gap-3 rounded-md px-2 py-2.5 text-sm outline-none transition-colors aria-selected:bg-slate-100 dark:aria-selected:bg-slate-800 cursor-pointer"
                                                        >
                                                            <div
                                                                class="flex h-5 w-5 items-center justify-center rounded border {copyDateValue ===
                                                                l.date
                                                                    ? 'border-secondary bg-secondary text-secondary-foreground'
                                                                    : 'border-slate-300 dark:border-slate-600'}"
                                                            >
                                                                <CheckIcon
                                                                    class="h-3.5 w-3.5 {copyDateValue !==
                                                                        l.date &&
                                                                        'hidden'}"
                                                                />
                                                            </div>
                                                            <div
                                                                class="flex flex-1 items-center justify-between"
                                                            >
                                                                <div
                                                                    class="flex flex-col"
                                                                >
                                                                    <span
                                                                        class="font-medium"
                                                                        >{l.name}</span
                                                                    >
                                                                    <span
                                                                        class="text-xs text-muted-foreground"
                                                                        >{l.date}</span
                                                                    >
                                                                </div>
                                                                <span
                                                                    class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-400"
                                                                >
                                                                    {formatRelativeDate(
                                                                        l.date,
                                                                    )}
                                                                </span>
                                                            </div>
                                                        </Command.Item>
                                                    {/each}
                                                </Command.Group>
                                            </Command.List>
                                        </Command.Root>
                                    </Popover.Content>
                                </Popover.Root>
                            </div>

                            {#if selectedCopyDate}
                                <div
                                    class="flex items-center gap-3 rounded-lg bg-secondary/20 p-3 text-sm dark:bg-secondary/10"
                                    transition:slide={{ duration: 200 }}
                                >
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary/40"
                                    >
                                        <CheckIcon
                                            class="h-4 w-4 text-secondary-foreground"
                                        />
                                    </div>
                                    <div class="flex-1">
                                        <p
                                            class="font-medium text-secondary-foreground"
                                        >
                                            Ready to copy
                                        </p>
                                        <p
                                            class="text-xs text-secondary-foreground/70"
                                        >
                                            From: {selectedCopyDate.name} • {selectedCopyDate.date}
                                        </p>
                                    </div>
                                </div>
                            {/if}

                            <!-- Target Date Info -->
                            <div
                                class="rounded-lg border border-dashed border-slate-300 bg-slate-50/50 p-3 dark:border-slate-700 dark:bg-slate-900/30"
                            >
                                <div
                                    class="flex items-center gap-2 text-xs text-muted-foreground"
                                >
                                    <CalendarIcon class="h-3.5 w-3.5" />
                                    <span
                                        >Will be created for: <strong
                                            class="text-foreground"
                                            >{new Date().toLocaleDateString(
                                                'en-US',
                                                {
                                                    month: 'short',
                                                    day: 'numeric',
                                                    year: 'numeric',
                                                },
                                            )}</strong
                                        ></span
                                    >
                                </div>
                            </div>
                        </Card.Content>
                        <Card.Footer class="relative pt-2">
                            <Button
                                variant="secondary"
                                class="w-full gap-2 shadow-lg shadow-secondary/20 transition-all duration-300 hover:shadow-xl hover:shadow-secondary/30 hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                                onclick={handleCopy}
                                disabled={!copyName.trim() ||
                                    !copyDateValue ||
                                    isCopying}
                            >
                                {#if isCopying}
                                    <div
                                        class="h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"
                                    ></div>
                                    Copying...
                                {:else}
                                    <CopyIcon class="h-4 w-4" />
                                    Copy to Today
                                {/if}
                            </Button>
                        </Card.Footer>
                    </Card.Root>
                </div>
            </div>
        {:else}
            <HandleTractorsImport {today} tractors={} />
        {/if}
    </div>
</Layout>
