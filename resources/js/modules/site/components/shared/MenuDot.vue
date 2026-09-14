<template>
    <span class="menu-dot"></span>
</template>

<style scoped>
.menu-dot {
    width: 5px;
    height: 5px;

    flex-shrink: 0;

    border-radius: 999px;

    background: #d1d1d1;

    transition:
        background-color 180ms ease,
        transform 180ms ease;
}

:global(.menu-dot-hover:hover) .menu-dot {
    background: #252525;

    transform: scale(1.25);
}
</style>

