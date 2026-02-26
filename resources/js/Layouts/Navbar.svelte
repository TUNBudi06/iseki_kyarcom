<script>
    import { Link } from '@inertiajs/svelte';
    import { Menu, X, Calculator } from '@lucide/svelte';
    import { isCurrentRoute, routeUrl } from '@tunbudi06/inertia-route-helper';
    import DefaultLayout from '$/Layouts/DefaultLayout.svelte';
    import { home } from '$routes';
    import { kyarcomDataList } from '$routes/kyarcom/index.ts';

    let { children = null } = $props();
    let mobileOpen = $state(false);

    function toggleMobile() {
        mobileOpen = !mobileOpen;
    }
</script>

<DefaultLayout>
    <div class="min-h-screen bg-background text-foreground">
        <!-- Navigation -->
        <nav
            class="sticky top-0 z-40 border-b border-border bg-card/50 backdrop-blur-md shadow-sm dark:bg-card/40"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between gap-4">
                    <!-- Brand -->
                    <Link
                        href={routeUrl(home())}
                        class="flex items-center gap-3 flex-shrink-0 hover:opacity-80 transition-opacity"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-[calc(var(--radius)-2px)] bg-primary text-primary-foreground shadow-lg hover:shadow-xl transition-shadow"
                        >
                            <Calculator class="w-5 h-5" />
                        </div>
                        <div class="hidden sm:block">
                            <h1
                                class="text-base font-bold text-foreground leading-tight"
                            >
                                Iseki Kyarcom
                            </h1>
                            <p class="text-xs text-muted-foreground">
                                Kyarya Compute
                            </p>
                        </div>
                    </Link>

                    <!-- Desktop Links -->
                    <div
                        class="hidden md:flex md:items-center md:gap-1 ml-auto"
                    >
                        <Link
                            href={routeUrl(home())}
                            class="px-4 py-2 text-sm font-medium rounded-[calc(var(--radius)-2px)] transition-all duration-200 text-foreground hover:bg-secondary/80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring data-[active=true]:bg-primary data-[active=true]:text-primary-foreground data-[active=true]:shadow-md"
                            data-active={isCurrentRoute(
                                routeUrl(home()),
                                true,
                                true,
                            )}
                        >
                            Home
                        </Link>
                        <Link
                            href={routeUrl(kyarcomDataList())}
                            class="px-4 py-2 text-sm font-medium rounded-[calc(var(--radius)-2px)] transition-all duration-200 text-foreground hover:bg-secondary/80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring data-[active=true]:bg-primary data-[active=true]:text-primary-foreground data-[active=true]:shadow-md"
                            data-active={isCurrentRoute(
                                routeUrl(kyarcomDataList()),
                                true,
                                true,
                            )}
                        >
                            KyarCom
                        </Link>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden ml-auto">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-foreground hover:bg-secondary/60 focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring transition-colors"
                            aria-controls="mobile-menu"
                            aria-expanded={mobileOpen}
                            onclick={toggleMobile}
                        >
                            {#if !mobileOpen}
                                <Menu class="h-5 w-5" />
                            {:else}
                                <X class="h-5 w-5" />
                            {/if}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Panel -->
            {#if mobileOpen}
                <div
                    id="mobile-menu"
                    class="md:hidden border-t border-border bg-card/80 backdrop-blur-sm animate-in fade-in slide-in-from-top-2 duration-200"
                >
                    <div class="px-4 pt-3 pb-4 sm:px-6">
                        <div class="flex flex-col gap-1">
                            <Link
                                href={routeUrl(home())}
                                class="block px-4 py-2.5 text-sm font-medium rounded-[calc(var(--radius)-2px)] transition-all duration-200 text-foreground hover:bg-secondary/80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring data-[active=true]:bg-primary data-[active=true]:text-primary-foreground"
                                data-active={isCurrentRoute(
                                    routeUrl(home()),
                                    true,
                                    true,
                                )}
                                onclick={() => (mobileOpen = false)}
                            >
                                Home
                            </Link>
                            <Link
                                href={routeUrl(kyarcomDataList())}
                                class="block px-4 py-2.5 text-sm font-medium rounded-[calc(var(--radius)-2px)] transition-all duration-200 text-foreground hover:bg-secondary/80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring data-[active=true]:bg-primary data-[active=true]:text-primary-foreground"
                                data-active={isCurrentRoute(
                                    routeUrl(kyarcomDataList()),
                                    true,
                                    true,
                                )}
                                onclick={() => (mobileOpen = false)}
                            >
                                KyarCom
                            </Link>
                        </div>
                    </div>
                </div>
            {/if}
        </nav>

        <!-- Main Content -->
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {@render children?.()}
        </main>

        <!-- Footer -->
        <footer
            class="mt-auto border-t border-border bg-card/50 backdrop-blur-md"
        >
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-muted-foreground"
                >
                    <p>
                        © 2026 Iseki KyarCom. Built with Laravel, Inertia &
                        Svelte.
                    </p>
                    <div class="flex gap-6">
                        <button
                            onclick={() => {}}
                            class="hover:text-foreground transition-colors"
                            >Privacy</button
                        >
                        <button
                            onclick={() => {}}
                            class="hover:text-foreground transition-colors"
                            >Terms</button
                        >
                        <button
                            onclick={() => {}}
                            class="hover:text-foreground transition-colors"
                            >Contact</button
                        >
                    </div>
                </div>
            </div>
        </footer>
    </div>
</DefaultLayout>
