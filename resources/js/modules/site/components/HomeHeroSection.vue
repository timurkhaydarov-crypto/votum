<template>
    <section class="home-hero">
        <div class="home-hero__grid" aria-hidden="true"></div>

        <div class="home-hero__container">
            <div class="home-hero__content">
                <div class="home-hero__eyebrow">
                    <span class="home-hero__status-dot"></span>
                    <span>{{ $t('hero.badge') }}</span>
                </div>

                <h1 class="home-hero__title">
                    {{ $t('hero.titleBefore') }}
                    <br />
                    <span>{{ $t('hero.titleGradient') }}</span>
                </h1>

                <p class="home-hero__description">
                    {{ $t('hero.subtitle') }}
                </p>

                <div class="home-hero__actions">
                    <RouterLink to="/contacts" class="home-hero__button home-hero__button--primary">
                        {{ $t('hero.requestQuote') }}
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </RouterLink>

                    <RouterLink to="/products" class="home-hero__button home-hero__button--secondary">
                        {{ $t('hero.viewProducts') }}
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </RouterLink>
                </div>

            </div>

            <figure class="home-hero__visual">
                <div class="home-hero__scan" aria-hidden="true">
                    <svg viewBox="0 0 1000 660" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="beam-gradient" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0" stop-color="#0d9488" stop-opacity="0.18" />
                                <stop offset="1" stop-color="#1d4ed8" stop-opacity="0.02" />
                            </linearGradient>
                        </defs>

                        <g class="home-hero__scan-rays">
                            <path d="M500 370 230 145" />
                            <path d="M500 370 335 85" />
                            <path d="M500 370 500 65" />
                            <path d="M500 370 665 85" />
                            <path d="M500 370 770 145" />
                        </g>

                        <g class="home-hero__beam-sweep">
                            <path d="M500 370 790 95 812 111Z" fill="url(#beam-gradient)" />
                            <path d="M500 370 790 95" />
                        </g>

                        <path class="home-hero__echo-return" d="M735 195Q632 260 505 365" />

                        <g class="home-hero__echo-point">
                            <circle class="home-hero__echo-pulse" cx="735" cy="195" r="15" />
                            <circle class="home-hero__echo-dot" cx="735" cy="195" r="4" />
                        </g>
                    </svg>
                </div>

                <img
                    :src="'/image/GeographySection.webp'"
                    :alt="$t('hero.mapAlt')"
                    class="home-hero__image"
                    fetchpriority="high"
                />

                <figcaption class="home-hero__caption">
                    <span class="home-hero__caption-dot" aria-hidden="true"></span>
                    {{ $t('company.global.mapLabel') }}
                </figcaption>
            </figure>
        </div>
    </section>
</template>

<style scoped>
.home-hero {
    --hero-ink: #0b0e1e;
    --hero-muted: #62677d;
    --hero-blue: #1d4ed8;
    --hero-teal: #0d9488;
    --hero-border: rgba(11, 14, 30, 0.1);

    position: relative;
    display: flex;
    min-height: min(900px, 88vh);
    align-items: center;
    overflow: hidden;
    background: #fff;
    color: var(--hero-ink);
}

.home-hero__grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(11, 14, 30, 0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(11, 14, 30, 0.025) 1px, transparent 1px);
    background-size: 70px 70px;
    mask-image: linear-gradient(to right, transparent, black 20%, black 80%, transparent);
}

.home-hero__container {
    position: relative;
    z-index: 1;
    display: grid;
    width: min(1440px, 100%);
    grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
    align-items: center;
    gap: 5vw;
    margin: 0 auto;
    padding: 80px 6vw;
}

.home-hero__content {
    max-width: 680px;
    animation: home-hero-enter 700ms ease both;
}

.home-hero__eyebrow {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 28px;
    color: var(--hero-blue);
    font-family: 'Outfit', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.home-hero__status-dot,
.home-hero__caption-dot {
    flex: 0 0 auto;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--hero-teal);
    box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
}

.home-hero__title {
    margin: 0;
    font-family: 'Outfit', sans-serif;
    font-size: 48px;
    font-weight: 800;
    line-height: 1.04;
}

.home-hero__title span {
    color: var(--hero-blue);
}

.home-hero__description {
    max-width: 580px;
    margin: 28px 0 32px;
    color: var(--hero-muted);
    font-size: 16px;
    line-height: 1.8;
}

.home-hero__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.home-hero__button {
    display: inline-flex;
    min-height: 50px;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 0 22px;
    border: 1px solid transparent;
    border-radius: 999px;
    font-family: 'Outfit', sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: transform 180ms ease, background-color 180ms ease, border-color 180ms ease;
}

.home-hero__button:hover {
    transform: translateY(-2px);
}

.home-hero__button--primary {
    background: var(--hero-ink);
    color: #fff;
}

.home-hero__button--primary:hover {
    background: var(--hero-blue);
}

.home-hero__button--secondary {
    border-color: var(--hero-border);
    background: rgba(255, 255, 255, 0.72);
    color: var(--hero-ink);
}

.home-hero__button--secondary:hover {
    border-color: rgba(29, 78, 216, 0.35);
    color: var(--hero-blue);
}

.home-hero__visual {
    position: relative;
    min-width: 0;
    margin: 0;
    padding: 16px;
    overflow: hidden;
    border: 1px solid var(--hero-border);
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 30px 80px rgba(11, 14, 30, 0.09);
    animation: home-hero-enter 850ms ease 120ms both;
}

.home-hero__scan {
    position: absolute;
    z-index: 0;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.home-hero__scan svg {
    display: block;
    width: 100%;
    height: 100%;
}

.home-hero__scan-rays,
.home-hero__beam-sweep,
.home-hero__echo-return {
    fill: none;
    stroke: var(--hero-blue);
    stroke-width: 1.5;
    vector-effect: non-scaling-stroke;
}

.home-hero__scan-rays {
    opacity: 0.16;
}

.home-hero__beam-sweep {
    transform-box: view-box;
    transform-origin: 50% 56%;
    animation: home-hero-beam-steer 5s ease-in-out infinite alternate;
}

.home-hero__beam-sweep path:first-child {
    stroke: none;
}

.home-hero__beam-sweep path:last-child {
    stroke: var(--hero-teal);
    stroke-width: 2;
    opacity: 0.42;
}

.home-hero__echo-return {
    stroke: var(--hero-teal);
    stroke-dasharray: 3 8;
    stroke-width: 2;
    opacity: 0.24;
    animation: home-hero-echo-return 2.5s linear infinite;
}

.home-hero__echo-pulse {
    fill: none;
    stroke: var(--hero-teal);
    stroke-width: 1.5;
    opacity: 0;
    transform-box: fill-box;
    transform-origin: center;
    animation: home-hero-echo-pulse 2.5s ease-out infinite;
}

.home-hero__echo-dot {
    fill: var(--hero-teal);
    opacity: 0.45;
}

.home-hero__image {
    position: relative;
    z-index: 1;
    display: block;
    width: 100%;
    height: auto;
    border-radius: 14px;
    mix-blend-mode: multiply;
}

.home-hero__caption {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 4px 2px;
    color: var(--hero-muted);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

@keyframes home-hero-enter {
    from {
        opacity: 0;
        transform: translateY(16px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes home-hero-beam-steer {
    from {
        transform: rotate(-18deg);
    }

    to {
        transform: rotate(18deg);
    }
}

@keyframes home-hero-echo-return {
    to {
        stroke-dashoffset: -22;
    }
}

@keyframes home-hero-echo-pulse {
    from {
        opacity: 0.38;
        transform: scale(0.55);
    }

    to {
        opacity: 0;
        transform: scale(1.8);
    }
}

@media (max-width: 1100px) {
    .home-hero {
        min-height: auto;
    }

    .home-hero__container {
        grid-template-columns: minmax(0, 1fr);
        gap: 44px;
        padding-top: 72px;
        padding-bottom: 72px;
    }

    .home-hero__content {
        max-width: 760px;
    }

    .home-hero__visual {
        width: min(760px, 100%);
        justify-self: center;
    }
}

@media (max-width: 640px) {
    .home-hero__container {
        gap: 32px;
        padding: 52px 20px;
    }

    .home-hero__eyebrow {
        margin-bottom: 22px;
    }

    .home-hero__title {
        font-size: 40px;
    }

    .home-hero__description {
        margin: 22px 0 26px;
        font-size: 15px;
        line-height: 1.7;
    }

    .home-hero__actions {
        flex-direction: column;
    }

    .home-hero__button {
        width: 100%;
    }

    .home-hero__visual {
        padding: 10px;
        border-radius: 18px;
    }

    .home-hero__image {
        border-radius: 10px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .home-hero__content,
    .home-hero__visual,
    .home-hero__beam-sweep,
    .home-hero__echo-return,
    .home-hero__echo-pulse {
        animation: none;
    }

    .home-hero__button {
        transition: none;
    }
}
</style>