<script lang="ts">
    let { items, component: Component, cols = 2, gapMm = 6 } = $props();
</script>

<div
    class="grid"
    style="
		grid-template-columns: repeat({cols}, max-content);
		gap: {gapMm}mm;
	"
>
    {#each items as item}
        <Component data={item} />
    {/each}
</div>
