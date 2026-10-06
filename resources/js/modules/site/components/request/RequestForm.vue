vue
<template>
    <form
        class="p-5 sm:p-7"
        novalidate
        @submit.prevent="handleSubmit"
    >
        <input
            v-model="form.website"
            type="text"
            name="website"
            autocomplete="off"
            tabindex="-1"
            aria-hidden="true"
            class="absolute -left-[9999px] h-px w-px overflow-hidden"
        />

        <!-- HEADER -->
        <div class="mb-6 pr-10">
            <div
                class="text-[9px] font-semibold uppercase tracking-[0.15em] text-slate-400"
            >
                {{ t('request.form.label') }}
            </div>

            <h2
                class="mt-1 text-lg font-semibold tracking-tight text-slate-900"
            >
                {{ t('request.form.title') }}
            </h2>

            <p
                class="mt-2 text-sm leading-6 text-slate-500"
            >
                {{ t('request.form.description') }}
            </p>
        </div>

        <!-- FIELDS -->
        <div class="space-y-5">
            <!-- NAME -->
            <div>
                <label
                    for="request-name"
                    class="mb-2 block text-xs font-semibold text-slate-700"
                >
                    {{ t('request.form.name') }}
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="request-name"
                    v-model="form.name"
                    type="text"
                    autocomplete="name"
                    :placeholder="t('request.form.namePlaceholder')"
                    :disabled="submitting"
                    class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100 disabled:cursor-not-allowed disabled:bg-slate-50"
                    :class="{
                        'border-red-300 focus:border-red-400':
                            errors.name,
                    }"
                />

                <p
                    v-if="errors.name"
                    class="mt-1.5 text-xs text-red-500"
                >
                    {{ errors.name }}
                </p>
            </div>

            <!-- PHONE -->
            <div>
                <label
                    for="request-phone"
                    class="mb-2 block text-xs font-semibold text-slate-700"
                >
                    {{ t('request.form.phone') }}
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="request-phone"
                    v-model="form.phone"
                    type="tel"
                    autocomplete="tel"
                    :placeholder="t('request.form.phonePlaceholder')"
                    :disabled="submitting"
                    class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100 disabled:cursor-not-allowed disabled:bg-slate-50"
                    :class="{
                        'border-red-300 focus:border-red-400':
                            errors.phone,
                    }"
                />

                <p
                    v-if="errors.phone"
                    class="mt-1.5 text-xs text-red-500"
                >
                    {{ errors.phone }}
                </p>
            </div>

            <!-- EMAIL -->
            <div>
                <label
                    for="request-email"
                    class="mb-2 block text-xs font-semibold text-slate-700"
                >
                    {{ t('request.form.email') }}
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="request-email"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    required
                    :placeholder="t('request.form.emailPlaceholder')"
                    :disabled="submitting"
                    class="w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100 disabled:cursor-not-allowed disabled:bg-slate-50"
                    :class="{
                        'border-red-300 focus:border-red-400':
                            errors.email,
                    }"
                />

                <p
                    v-if="errors.email"
                    class="mt-1.5 text-xs text-red-500"
                >
                    {{ errors.email }}
                </p>
            </div>

            <!-- COMMENT -->
            <div>
                <label
                    for="request-comment"
                    class="mb-2 block text-xs font-semibold text-slate-700"
                >
                    {{ t('request.form.comment') }}
                </label>

                <textarea
                    id="request-comment"
                    v-model="form.comment"
                    rows="4"
                    :placeholder="t('request.form.commentPlaceholder')"
                    :disabled="submitting"
                    class="w-full resize-y rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-400 focus:ring-2 focus:ring-slate-100 disabled:cursor-not-allowed disabled:bg-slate-50"
                ></textarea>
            </div>
        </div>

        <!-- ERROR -->
        <div
            v-if="submitError"
            class="mt-5 rounded-lg border border-red-100 bg-red-50 px-4 py-3 text-xs text-red-600"
        >
            <div class="flex items-start gap-2">
                <i class="bi bi-exclamation-circle"></i>

                <span>
                    {{ submitError }}
                </span>
            </div>
        </div>

        <!-- SUBMIT -->
        <button
            type="submit"
            :disabled="
                submitting
                || (withProducts && !itemCount)
            "
            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-3 text-xs font-semibold text-white shadow-sm transition-all duration-200 hover:bg-slate-800 hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
        >
            <i
                v-if="submitting"
                class="bi bi-arrow-repeat animate-spin text-sm"
            ></i>

            <i
                v-else
                class="bi bi-send text-sm"
            ></i>

            <span>
                {{
                    submitting
                        ? t('request.form.sending')
                        : t('request.form.submit')
                }}
            </span>
        </button>

        <!-- PRIVACY -->
        <p
            class="mt-3 text-center text-[10px] leading-4 text-slate-400"
        >
            {{ t('request.form.privacy') }}
        </p>
    </form>
</template>

<script setup>
import {
    reactive,
    ref,
} from 'vue';

import { useI18n } from 'vue-i18n';

import { useCart } from '../../composables/useCart';
import { requestApi } from '../../services/requestApi';

const props = defineProps({
    /**
     * Whether the request is created from cart.
     */
    withProducts: {
        type: Boolean,
        default: false,
    },

    /**
     * Request subject.
     *
     * Examples:
     * - Запрос на оборудование
     * - Связаться со специалистом
     * - Техническое обслуживание
     */
    subject: {
        type: String,
        default: null,
    },

    /**
     * Request context.
     *
     * Allowed values:
     * - cart
     * - contact
     * - service
     */
    context: {
        type: String,
        default: 'contact',
        validator: (value) => [
            'cart',
            'contact',
            'service',
        ].includes(value),
    },
});

const emit = defineEmits([
    'success',
]);

const { t, locale } = useI18n();

const {
    itemCount,
    resetLocal,
} = useCart();

const form = reactive({
    name: '',
    phone: '',
    email: '',
    comment: '',
    website: '',
});

const errors = ref({});
const submitError = ref(null);
const submitting = ref(false);

/**
 * Submit request.
 */
const handleSubmit = async () => {
    if (submitting.value) {
        return;
    }

    errors.value = {};
    submitError.value = null;

    /*
     * Cart request must contain products.
     */
    if (
        props.withProducts
        && !itemCount.value
    ) {
        submitError.value = t(
            'request.form.emptyCart',
        );

        return;
    }

    submitting.value = true;

    try {
        const data = await requestApi.store({
            /*
             * Request context.
             */
            context: props.context,

            /*
             * Request subject.
             */
            subject: props.subject,

            /*
             * Contact data.
             */
            name: form.name,
            phone: form.phone,
            email: form.email || null,
            comment: form.comment || null,
            website: form.website,
        }, locale.value);

        /*
         * Laravel clears the server-side cart
         * when context = cart.
         *
         * Reset local Vue state as well.
         */
        if (
            props.withProducts
            || props.context === 'cart'
        ) {
            resetLocal();
        }

        /*
         * Show success screen.
         */
        emit('success', data);

    } catch (error) {
        /*
         * Laravel validation errors.
         */
        errors.value = error?.errors || {};

        /*
         * General error.
         */
        const hasVisibleFieldErrors = [
            'name',
            'phone',
            'email',
        ].some((field) => errors.value[field]?.length);

        submitError.value = error?.status === 429
            ? t('request.form.rateLimited')
            : hasVisibleFieldErrors
                ? null
                : t('request.form.submitError');

    } finally {
        submitting.value = false;
    }
};
</script>

