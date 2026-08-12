<template>
  <section class="hero">
    <!-- Background -->
    <div class="hero__grid"></div>
    <div class="hero__glow hero__glow--blue"></div>
    <div class="hero__glow hero__glow--teal"></div>

    <div class="hero__container">
      <!-- =========================
           CONTENT
      ========================== -->
      <div class="hero__content">
        <div class="hero__eyebrow">
          <span class="hero__status-dot"></span>

          <span>
            {{ $t('hero.badge') }}
          </span>

          <span class="hero__eyebrow-line"></span>
        </div>

        <h1 class="hero__title">
          {{ $t('hero.titleBefore') }}
          <br />

          <span class="hero__title-gradient">
            {{ $t('hero.titleGradient') }}
          </span>
        </h1>

        <p class="hero__description">
          {{ $t('hero.subtitle') }}
        </p>

        <div class="hero__actions">
          <button
            type="button"
            class="hero-btn hero-btn--primary"
            @click="handleQuote"
          >
            <span>
              {{ $t('hero.requestQuote') }}
            </span>

            <svg
              viewBox="0 0 16 16"
              aria-hidden="true"
            >
              <path d="M3 8h10M9 4l4 4-4 4" />
            </svg>
          </button>

          <a
            href="#products"
            class="hero-btn hero-btn--secondary"
          >
            {{ $t('hero.viewProducts') }}

            <svg
              viewBox="0 0 16 16"
              aria-hidden="true"
            >
              <path d="M4 8h8M8 4l4 4-4 4" />
            </svg>
          </a>
        </div>

        <!-- Small technical information -->
        <div class="hero__meta">
          <div class="hero__meta-item">
            <span class="hero__meta-value">
              {{ $t('hero.meta.location.value') }}
            </span>

            <span class="hero__meta-label">
              {{ $t('hero.meta.location.label') }}
            </span>
          </div>

          <div class="hero__meta-divider"></div>

          <div class="hero__meta-item">
            <span class="hero__meta-value">
              {{ $t('hero.meta.production.value') }}
            </span>

            <span class="hero__meta-label">
              {{ $t('hero.meta.production.label') }}
            </span>
          </div>
        </div>
      </div>

      <!-- =========================
           VISUAL
      ========================== -->
      <div class="hero__visual">
        <div class="hero-scene">

          <!-- Orbit -->
          <div class="orbit orbit--outer">
            <span class="orbit__point orbit__point--blue"></span>
          </div>

          <div class="orbit orbit--middle">
            <span class="orbit__point orbit__point--teal"></span>
          </div>

          <div class="orbit orbit--inner"></div>

          <!-- Main device -->
          <div class="scanner">
            <div class="scanner__glow"></div>

            <div class="scanner__header">
              <span class="scanner__indicator"></span>

              <span class="scanner__label">
                {{ $t('hero.scanner.live') }}
              </span>

              <span class="scanner__code">
                NDT-01
              </span>
            </div>

            <div class="scanner__radar">
              <svg
                viewBox="0 0 300 300"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <defs>
                  <radialGradient
                    id="radarGlow"
                    cx="50%"
                    cy="50%"
                    r="50%"
                  >
                    <stop
                      offset="0%"
                      stop-color="#1d4ed8"
                      stop-opacity=".08"
                    />

                    <stop
                      offset="100%"
                      stop-color="#1d4ed8"
                      stop-opacity="0"
                    />
                  </radialGradient>

                  <linearGradient
                    id="scanGradient"
                    x1="0"
                    y1="0"
                    x2="0"
                    y2="1"
                  >
                    <stop
                      offset="0%"
                      stop-color="#1d4ed8"
                      stop-opacity="0"
                    />

                    <stop
                      offset="100%"
                      stop-color="#1d4ed8"
                      stop-opacity=".8"
                    />
                  </linearGradient>
                </defs>

                <!-- Glow -->
                <circle
                  cx="150"
                  cy="150"
                  r="135"
                  fill="url(#radarGlow)"
                />

                <!-- Radar circles -->
                <circle
                  v-for="radius in [130, 100, 70, 40]"
                  :key="radius"
                  cx="150"
                  cy="150"
                  :r="radius"
                  class="radar__circle"
                />

                <!-- Crosshair -->
                <line
                  x1="20"
                  y1="150"
                  x2="280"
                  y2="150"
                  class="radar__line"
                />

                <line
                  x1="150"
                  y1="20"
                  x2="150"
                  y2="280"
                  class="radar__line"
                />

                <!-- Diagonal guides -->
                <line
                  x1="58"
                  y1="58"
                  x2="242"
                  y2="242"
                  class="radar__line radar__line--soft"
                />

                <line
                  x1="242"
                  y1="58"
                  x2="58"
                  y2="242"
                  class="radar__line radar__line--soft"
                />

                <!-- Sweep -->
                <g class="radar__sweep">
                  <line
                    x1="150"
                    y1="150"
                    x2="150"
                    y2="24"
                    stroke="url(#scanGradient)"
                    stroke-width="2"
                  />
                </g>

                <!-- Detection points -->
                <g
                  v-for="point in radarPoints"
                  :key="point.id"
                >
                  <circle
                    :cx="point.x"
                    :cy="point.y"
                    :r="point.r"
                    :class="[
                      'radar__point',
                      `radar__point--${point.type}`
                    ]"
                  />

                  <circle
                    :cx="point.x"
                    :cy="point.y"
                    :r="point.r * 3"
                    :class="[
                      'radar__pulse',
                      `radar__pulse--${point.type}`
                    ]"
                  />
                </g>

                <!-- Waveform -->
                <polyline
                  :points="waveform"
                  class="radar__wave"
                />
              </svg>
            </div>

            <div class="scanner__footer">
              <span>
                {{ $t('hero.scanner.scanActive') }}
              </span>

              <span class="scanner__frequency">
                4.5 MHz
              </span>
            </div>
          </div>

          <!-- Floating statistics -->
          <div
            v-for="(stat, index) in stats"
            :key="stat.key"
            :class="[
              'hero-stat',
              `hero-stat--${index + 1}`
            ]"
          >
            <span class="hero-stat__accent"></span>

            <div class="hero-stat__content">
              <strong>
                {{ $t(stat.value) }}
              </strong>

              <span>
                {{ $t(stat.label) }}
              </span>

              <small v-if="stat.status">
                <i></i>
                {{ $t(stat.status) }}
              </small>
            </div>
          </div>

          <!-- Technical labels -->
          <span class="tech-label tech-label--top">
            ULTRASONIC / PA
          </span>

          <span class="tech-label tech-label--bottom">
            {{ $t('hero.scanner.system') }}
          </span>

          <span class="tech-line tech-line--left"></span>
          <span class="tech-line tech-line--right"></span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const emit = defineEmits(['quote'])

const stats = [
  {
    key: 'tests',
    value: 'hero.stats.tests.value',
    label: 'hero.stats.tests.label'
  },
  {
    key: 'industry',
    value: 'hero.stats.industry.value',
    label: 'hero.stats.industry.label',
    status: 'hero.stats.industry.status'
  },
  {
    key: 'certificates',
    value: 'hero.stats.certificates.value',
    label: 'hero.stats.certificates.label'
  }
]

const radarPoints = [
  {
    id: 1,
    x: 105,
    y: 92,
    r: 3,
    type: 'blue'
  },
  {
    id: 2,
    x: 188,
    y: 108,
    r: 2.5,
    type: 'teal'
  },
  {
    id: 3,
    x: 120,
    y: 188,
    r: 2,
    type: 'blue'
  },
  {
    id: 4,
    x: 194,
    y: 174,
    r: 3,
    type: 'teal'
  },
  {
    id: 5,
    x: 82,
    y: 150,
    r: 2,
    type: 'blue'
  }
]

const waveform =
  '35,235 55,235 65,226 75,241 85,222 95,240 105,228 115,235 125,230 135,239 145,225 155,235 165,228 175,242 185,220 195,239 205,228 215,235 225,231 235,238 245,235 265,235'

const handleQuote = () => {
  emit('quote')
}
</script>

<style scoped>
.hero {
  --hero-bg: #ffffff;
  --hero-ink: #0b0e1e;
  --hero-muted: #6e7196;
  --hero-blue: #1d4ed8;
  --hero-teal: #0d9488;
  --hero-border: rgba(11, 14, 30, 0.08);
  --hero-blue-soft: rgba(29, 78, 216, 0.08);
  --hero-teal-soft: rgba(13, 148, 136, 0.07);

  position: relative;
  min-height: min(900px, 88vh);

  display: flex;
  align-items: center;

  overflow: hidden;

  background: var(--hero-bg);
  color: var(--hero-ink);
}

/* =========================================
   BACKGROUND
========================================= */

.hero__grid {
  position: absolute;
  inset: 0;

  opacity: 0.45;

  background-image:
    linear-gradient(
      rgba(11, 14, 30, 0.025) 1px,
      transparent 1px
    ),
    linear-gradient(
      90deg,
      rgba(11, 14, 30, 0.025) 1px,
      transparent 1px
    );

  background-size: 70px 70px;

  mask-image: linear-gradient(
    to right,
    transparent,
    black 20%,
    black 80%,
    transparent
  );
}

.hero__glow {
  position: absolute;

  width: 600px;
  height: 600px;

  border-radius: 50%;

  filter: blur(100px);

  pointer-events: none;
}

.hero__glow--blue {
  top: -300px;
  right: -150px;

  background: rgba(29, 78, 216, 0.07);
}

.hero__glow--teal {
  bottom: -350px;
  left: 10%;

  background: rgba(13, 148, 136, 0.05);
}

/* =========================================
   CONTAINER
========================================= */

.hero__container {
  position: relative;
  z-index: 2;

  width: min(1440px, 100%);
  margin: 0 auto;

  padding: 80px 6vw;

  display: grid;
  grid-template-columns: minmax(0, 0.95fr) minmax(480px, 1.05fr);
  gap: clamp(30px, 5vw, 100px);

  align-items: center;
}

/* =========================================
   CONTENT
========================================= */

.hero__content {
  position: relative;
  z-index: 5;

  max-width: 680px;

  animation: hero-enter 0.9s ease both;
}

@keyframes hero-enter {
  from {
    opacity: 0;
    transform: translateY(24px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 9px;

  margin-bottom: 28px;

  color: var(--hero-blue);

  font-family: 'Outfit', sans-serif;
  font-size: 11px;
  font-weight: 700;

  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.hero__status-dot {
  position: relative;

  width: 7px;
  height: 7px;

  border-radius: 50%;

  background: var(--hero-blue);

  box-shadow:
    0 0 0 5px rgba(29, 78, 216, 0.08),
    0 0 15px rgba(29, 78, 216, 0.35);
}

.hero__status-dot::after {
  content: '';

  position: absolute;
  inset: -5px;

  border: 1px solid rgba(29, 78, 216, 0.25);
  border-radius: 50%;

  animation: pulse 2s ease infinite;
}

@keyframes pulse {
  0% {
    opacity: 1;
    transform: scale(0.8);
  }

  100% {
    opacity: 0;
    transform: scale(1.7);
  }
}

.hero__eyebrow-line {
  width: 32px;
  height: 1px;

  margin-left: 4px;

  background: currentColor;
  opacity: 0.25;
}

.hero__title {
  margin: 0;

  font-family: 'Outfit', sans-serif;
  font-size: clamp(48px, 5.4vw, 78px);
  font-weight: 800;
  line-height: 0.98;
  letter-spacing: -0.045em;
}

.hero__title-gradient {
  background: linear-gradient(
    120deg,
    #1d4ed8 0%,
    #2563eb 40%,
    #0d9488 100%
  );

  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero__description {
  max-width: 580px;

  margin: 30px 0 34px;

  color: var(--hero-muted);

  font-size: 16px;
  line-height: 1.8;
}

/* =========================================
   ACTIONS
========================================= */

.hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

.hero-btn {
  min-height: 50px;

  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;

  padding: 0 24px;

  border-radius: 999px;

  font-family: 'Outfit', sans-serif;
  font-size: 13px;
  font-weight: 700;

  text-decoration: none;

  cursor: pointer;

  transition:
    transform 0.25s ease,
    box-shadow 0.25s ease,
    border-color 0.25s ease,
    background 0.25s ease;
}

.hero-btn svg {
  width: 16px;
  height: 16px;

  fill: none;
  stroke: currentColor;
  stroke-width: 1.8;
}

.hero-btn--primary {
  border: 0;

  background: var(--hero-ink);
  color: #fff;
}

.hero-btn--primary:hover {
  background: var(--hero-blue);

  box-shadow:
    0 12px 30px rgba(29, 78, 216, 0.2);

  transform: translateY(-2px);
}

.hero-btn--secondary {
  border: 1px solid var(--hero-border);

  background: rgba(255, 255, 255, 0.7);
  color: var(--hero-ink);

  backdrop-filter: blur(10px);
}

.hero-btn--secondary:hover {
  border-color: rgba(29, 78, 216, 0.3);

  color: var(--hero-blue);

  transform: translateY(-2px);
}

/* =========================================
   META
========================================= */

.hero__meta {
  display: flex;
  align-items: center;

  margin-top: 42px;
}

.hero__meta-item {
  display: flex;
  flex-direction: column;
  gap: 3px;
}

.hero__meta-value {
  font-family: 'Outfit', sans-serif;
  font-size: 13px;
  font-weight: 700;
}

.hero__meta-label {
  color: var(--hero-muted);

  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.hero__meta-divider {
  width: 1px;
  height: 30px;

  margin: 0 22px;

  background: var(--hero-border);
}

/* =========================================
   VISUAL
========================================= */

.hero__visual {
  display: flex;
  align-items: center;
  justify-content: center;

  animation: hero-visual-enter 1s ease 0.2s both;
}

@keyframes hero-visual-enter {
  from {
    opacity: 0;
    transform: scale(0.94);
  }

  to {
    opacity: 1;
    transform: scale(1);
  }
}

.hero-scene {
  position: relative;

  width: min(580px, 100%);
  aspect-ratio: 1;

  display: flex;
  align-items: center;
  justify-content: center;
}

/* =========================================
   ORBITS
========================================= */

.orbit {
  position: absolute;

  border-radius: 50%;

  pointer-events: none;
}

.orbit--outer {
  inset: 0;

  border: 1px solid rgba(29, 78, 216, 0.1);

  animation: rotate 28s linear infinite;
}

.orbit--middle {
  inset: 11%;

  border: 1px dashed rgba(13, 148, 136, 0.15);

  animation:
    rotate 20s linear infinite reverse;
}

.orbit--inner {
  inset: 23%;

  border: 1px solid rgba(29, 78, 216, 0.07);

  animation: rotate 24s linear infinite;
}

@keyframes rotate {
  to {
    transform: rotate(360deg);
  }
}

.orbit__point {
  position: absolute;

  width: 9px;
  height: 9px;

  border-radius: 50%;
}

.orbit__point--blue {
  top: -5px;
  left: 50%;

  background: var(--hero-blue);

  box-shadow:
    0 0 0 5px rgba(29, 78, 216, 0.08),
    0 0 18px rgba(29, 78, 216, 0.5);
}

.orbit__point--teal {
  right: -4px;
  bottom: 17%;

  width: 8px;
  height: 8px;

  background: var(--hero-teal);

  box-shadow:
    0 0 0 5px rgba(13, 148, 136, 0.07),
    0 0 15px rgba(13, 148, 136, 0.4);
}

/* =========================================
   SCANNER
========================================= */

.scanner {
  position: relative;
  z-index: 3;

  width: 46%;
  aspect-ratio: 1;

  display: flex;
  flex-direction: column;

  overflow: hidden;

  border: 1px solid rgba(11, 14, 30, 0.07);
  border-radius: 24px;

  background:
    linear-gradient(
      145deg,
      rgba(255, 255, 255, 0.98),
      rgba(247, 249, 253, 0.94)
    );

  box-shadow:
    0 30px 80px rgba(11, 14, 30, 0.11),
    0 0 0 8px rgba(255, 255, 255, 0.5);

  backdrop-filter: blur(12px);
}

.scanner::after {
  content: '';

  position: absolute;
  inset: 0;

  border: 1px solid rgba(29, 78, 216, 0.05);
  border-radius: inherit;

  pointer-events: none;
}

.scanner__glow {
  position: absolute;

  width: 80%;
  height: 80%;

  top: -25%;
  left: -20%;

  border-radius: 50%;

  background: rgba(29, 78, 216, 0.08);

  filter: blur(45px);
}

.scanner__header,
.scanner__footer {
  position: relative;
  z-index: 2;

  display: flex;
  align-items: center;

  padding: 14px 16px;

  font-family: 'Outfit', sans-serif;
  font-size: 8px;
  font-weight: 700;

  letter-spacing: 0.1em;
  text-transform: uppercase;
}

.scanner__header {
  justify-content: space-between;

  border-bottom: 1px solid rgba(11, 14, 30, 0.05);
}

.scanner__indicator {
  width: 5px;
  height: 5px;

  margin-right: 6px;

  border-radius: 50%;

  background: var(--hero-teal);

  box-shadow: 0 0 8px rgba(13, 148, 136, 0.5);
}

.scanner__label {
  margin-right: auto;

  color: var(--hero-teal);
}

.scanner__code {
  color: #9a9db0;
}

.scanner__radar {
  position: relative;

  flex: 1;

  min-height: 0;

  padding: 10px;
}

.scanner__radar svg {
  width: 100%;
  height: 100%;
}

.scanner__footer {
  justify-content: space-between;

  color: #85889e;

  border-top: 1px solid rgba(11, 14, 30, 0.05);
}

.scanner__frequency {
  color: var(--hero-blue);
}

/* Radar */

.radar__circle {
  fill: none;

  stroke: rgba(29, 78, 216, 0.1);
  stroke-width: 0.8;
}

.radar__line {
  stroke: rgba(29, 78, 216, 0.1);
  stroke-width: 0.7;
}

.radar__line--soft {
  stroke: rgba(29, 78, 216, 0.045);
}

.radar__sweep {
  transform-origin: 150px 150px;

  animation: radar-sweep 4s linear infinite;
}

@keyframes radar-sweep {
  to {
    transform: rotate(360deg);
  }
}

.radar__point {
  animation: radar-point 2.5s ease-in-out infinite;
}

.radar__point--blue {
  fill: var(--hero-blue);
}

.radar__point--teal {
  fill: var(--hero-teal);
}

.radar__pulse {
  fill: none;

  stroke-width: 0.8;

  animation: radar-pulse 2.5s ease-out infinite;
}

.radar__pulse--blue {
  stroke: var(--hero-blue);
}

.radar__pulse--teal {
  stroke: var(--hero-teal);
}

@keyframes radar-point {
  0%,
  100% {
    opacity: 0.3;
  }

  50% {
    opacity: 1;
  }
}

@keyframes radar-pulse {
  0% {
    opacity: 0.6;
    transform: scale(0.6);
    transform-origin: center;
  }

  100% {
    opacity: 0;
    transform: scale(2);
    transform-origin: center;
  }
}

.radar__wave {
  fill: none;

  stroke: var(--hero-blue);
  stroke-width: 1.2;

  opacity: 0.4;

  stroke-linecap: round;

  animation: wave-shift 2s ease-in-out infinite;
}

@keyframes wave-shift {
  0%,
  100% {
    opacity: 0.25;
  }

  50% {
    opacity: 0.65;
  }
}

/* =========================================
   STATS
========================================= */

.hero-stat {
  position: absolute;
  z-index: 10;

  display: flex;

  min-width: 145px;

  padding: 13px 17px;

  border: 1px solid rgba(11, 14, 30, 0.06);
  border-radius: 13px;

  background: rgba(255, 255, 255, 0.9);

  box-shadow:
    0 12px 35px rgba(11, 14, 30, 0.07);

  backdrop-filter: blur(12px);

  animation: stat-float 5s ease-in-out infinite;
}

.hero-stat--1 {
  top: 9%;
  right: 2%;
}

.hero-stat--2 {
  bottom: 18%;
  left: -2%;

  animation-delay: 1.5s;
}

.hero-stat--3 {
  top: 43%;
  left: -5%;

  animation-delay: 3s;
}

@keyframes stat-float {
  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-7px);
  }
}

.hero-stat__accent {
  width: 3px;

  margin-right: 11px;

  border-radius: 10px;

  background: var(--hero-blue);
}

.hero-stat--2 .hero-stat__accent {
  background: var(--hero-teal);
}

.hero-stat--3 .hero-stat__accent {
  background: #6c3bff;
}

.hero-stat__content {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.hero-stat strong {
  font-family: 'Outfit', sans-serif;
  font-size: 17px;
  font-weight: 800;
  line-height: 1.1;
}

.hero-stat span {
  color: var(--hero-muted);

  font-family: 'Outfit', sans-serif;
  font-size: 8px;
  font-weight: 600;

  letter-spacing: 0.06em;
  text-transform: uppercase;
}

.hero-stat small {
  display: flex;
  align-items: center;
  gap: 5px;

  margin-top: 3px;

  color: var(--hero-teal);

  font-family: 'Outfit', sans-serif;
  font-size: 7px;
  font-weight: 700;

  text-transform: uppercase;
}

.hero-stat small i {
  width: 4px;
  height: 4px;

  border-radius: 50%;

  background: currentColor;
}

/* =========================================
   TECH LABELS
========================================= */

.tech-label {
  position: absolute;

  color: #a3a6b7;

  font-family: monospace;
  font-size: 7px;
  letter-spacing: 0.12em;
}

.tech-label--top {
  top: 19%;
  left: 3%;
}

.tech-label--bottom {
  right: 4%;
  bottom: 19%;
}

.tech-line {
  position: absolute;

  width: 35px;
  height: 1px;

  background: rgba(11, 14, 30, 0.12);
}

.tech-line--left {
  top: 20%;
  left: -1%;
}

.tech-line--right {
  right: -1%;
  bottom: 20%;
}

/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1100px) {
  .hero__container {
    grid-template-columns: 1fr;

    padding-top: 70px;
    padding-bottom: 70px;
  }

  .hero__content {
    max-width: 760px;
  }

  .hero__visual {
    max-width: 620px;
    margin: 0 auto;
  }
}

@media (max-width: 700px) {
  .hero {
    min-height: auto;
  }

  .hero__container {
    padding: 70px 20px;
  }

  .hero__title {
    font-size: clamp(42px, 13vw, 62px);
  }

  .hero__description {
    font-size: 15px;
  }

  .hero__actions {
    flex-direction: column;
  }

  .hero-btn {
    width: 100%;
  }

  .hero__meta {
    margin-top: 32px;
  }

  .hero__visual {
    width: calc(100% + 30px);
    margin-left: -15px;
  }

  .hero-scene {
    width: 100%;
  }

  .scanner {
    width: 48%;
  }

  .hero-stat {
    min-width: 125px;
    padding: 10px 12px;
  }

  .hero-stat strong {
    font-size: 14px;
  }

  .hero-stat--1 {
    right: 0;
  }

  .hero-stat--2 {
    left: 0;
  }

  .hero-stat--3 {
    left: -1%;
  }

  .tech-label,
  .tech-line {
    display: none;
  }
}

@media (max-width: 480px) {
  .hero__container {
    padding: 55px 18px;
  }

  .hero__eyebrow {
    margin-bottom: 22px;
  }

  .hero__title {
    font-size: 43px;
  }

  .hero__description {
    margin-top: 24px;
  }

  .hero__meta {
    display: none;
  }

  .hero__visual {
    margin-top: 20px;
  }

  .hero-stat {
    min-width: 105px;
  }

  .hero-stat__accent {
    margin-right: 7px;
  }

  .hero-stat span {
    font-size: 6px;
  }

  .hero-stat strong {
    font-size: 12px;
  }

  .hero-stat--1 {
    top: 8%;
  }

  .hero-stat--2 {
    bottom: 15%;
  }

  .hero-stat--3 {
    top: 43%;
  }
}

@media (prefers-reduced-motion: reduce) {
  .hero *,
  .hero *::before,
  .hero *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
  }
}
</style>