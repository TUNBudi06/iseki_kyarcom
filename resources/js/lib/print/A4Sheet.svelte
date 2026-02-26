<script lang="ts">
    import { cn } from '$shadcn/utils';

    let {
        children = null,
        class: className = '',
        wrapperClass = '',
    } = $props();
</script>

<div
    class={cn(
        'bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-8',
        wrapperClass,
    )}
>
    <div
        class={cn(
            'relative bg-white dark:bg-gray-800 shadow-xl print:shadow-none',
            'w-[210mm] h-[297mm]',
            'shrink-0',
            'box-border',
            'text-gray-900 dark:text-gray-100',
            className,
        )}
    >
        <!-- Paper texture subtle effect -->
        <div
            class="absolute inset-0 pointer-events-none opacity-[0.02] dark:opacity-[0.05]"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noise\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.8\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100\' height=\'100\' filter=\'url(%23noise)\'/%3E%3C/svg%3E');"
        ></div>

        <!-- Content - Natural flow, no padding -->
        <div class="relative z-10 w-full h-full">
            {@render children?.()}
        </div>
    </div>
</div>
