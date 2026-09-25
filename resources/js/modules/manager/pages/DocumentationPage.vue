<template>
    <div class="space-y-6">
        <!-- ========================================================= -->
        <!-- HEADER -->
        <!-- ========================================================= -->

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                    Документация
                </div>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                    Доступ к документации
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Управление пользователями, ключами доступа и доступными продуктами.
                </p>
            </div>

            <button
                type="button"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                @click="loadUsers"
            >
                <i
                    :class="[
                        'bi',
                        isLoading ? 'bi-arrow-repeat animate-spin' : 'bi-arrow-clockwise',
                    ]"
                ></i>

                Обновить
            </button>
        </div>

        <!-- ========================================================= -->
        <!-- ERROR -->
        <!-- ========================================================= -->

        <div v-if="errorMessage" class="rounded-2xl border border-rose-200 bg-rose-50 p-5">
            <div class="flex items-start gap-3">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600"
                >
                    <i class="bi bi-exclamation-triangle"></i>
                </div>

                <div>
                    <div class="font-semibold text-rose-900">
                        Не удалось загрузить пользователей
                    </div>

                    <div class="mt-1 text-sm text-rose-700">
                        {{ errorMessage }}
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- LOADING -->
        <!-- ========================================================= -->

        <div v-if="isLoading" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div
                v-for="item in 6"
                :key="item"
                class="h-48 animate-pulse rounded-2xl bg-slate-100"
            ></div>
        </div>

        <!-- ========================================================= -->
        <!-- EMPTY -->
        <!-- ========================================================= -->

        <div
            v-else-if="!users.length"
            class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm"
        >
            <div
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"
            >
                <i class="bi bi-people text-2xl"></i>
            </div>

            <h2 class="mt-4 text-lg font-semibold text-slate-900">Пользователи не найдены</h2>

            <p class="mt-2 text-sm text-slate-500">Пока нет пользователей с ролью user.</p>
        </div>

        <!-- ========================================================= -->
        <!-- USERS -->
        <!-- ========================================================= -->

        <div v-else class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <article
                v-for="user in users"
                :key="user.id"
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-slate-300 hover:shadow-md"
            >
                <!-- top -->
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="truncate text-base font-semibold text-slate-900">
                            {{ user.name || 'Без имени' }}
                        </div>

                        <div class="mt-1 truncate text-sm text-slate-500">
                            {{ user.email || 'Email не указан' }}
                        </div>
                    </div>

                    <div
                        :class="[
                            'inline-flex shrink-0 items-center gap-1.5 rounded-lg border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.08em]',
                            user.has_documentation_key
                                ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                : 'border-slate-200 bg-slate-50 text-slate-500',
                        ]"
                    >
                        <span
                            :class="[
                                'h-1.5 w-1.5 rounded-full',
                                user.has_documentation_key ? 'bg-emerald-500' : 'bg-slate-300',
                            ]"
                        ></span>

                        {{ user.has_documentation_key ? 'Ключ активен' : 'Нет ключа' }}
                    </div>
                </div>

                <!-- stats -->
                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div
                            class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400"
                        >
                            Доступов
                        </div>

                        <div class="mt-1 text-xl font-bold text-slate-900">
                            {{ user.documentation_count }}
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div
                            class="text-[10px] font-semibold uppercase tracking-[0.1em] text-slate-400"
                        >
                            ID
                        </div>

                        <div class="mt-1 text-xl font-bold text-slate-900">#{{ user.id }}</div>
                    </div>
                </div>

                <!-- action -->
                <button
                    type="button"
                    class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
                    @click="openUser(user)"
                >
                    <i class="bi bi-shield-lock"></i>

                    Управление доступом

                    <i class="bi bi-arrow-right ml-auto"></i>
                </button>
            </article>
        </div>

        <!-- ========================================================= -->
        <!-- MODAL -->
        <!-- ========================================================= -->

        <DocumentationUserModal
            v-if="selectedUser"
            :user="selectedUser"
            @close="closeUser"
            @changed="handleUserChanged"
        />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

import DocumentationUserModal from '../components/DocumentationUserModal.vue';
import { documentationApi } from '../services/documentationApi.js';

const users = ref([]);
const isLoading = ref(false);
const errorMessage = ref('');

const selectedUser = ref(null);

/*
|--------------------------------------------------------------------------
| Load users
|--------------------------------------------------------------------------
*/

const loadUsers = async () => {
    isLoading.value = true;
    errorMessage.value = '';

    try {
        const response = await documentationApi.getUsers();

        console.log('Documentation users response:', response);

        if (Array.isArray(response)) {
            users.value = response;
        } else if (Array.isArray(response?.users)) {
            users.value = response.users;
        } else if (Array.isArray(response?.data)) {
            users.value = response.data;
        } else if (Array.isArray(response?.data?.users)) {
            users.value = response.data.users;
        } else {
            users.value = [];
        }

        console.log('Documentation users:', users.value);
    } catch (error) {
        console.error('Failed to load documentation users:', error);

        users.value = [];

        errorMessage.value = error?.message || 'Произошла ошибка при загрузке пользователей.';
    } finally {
        isLoading.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| User modal
|--------------------------------------------------------------------------
*/

const openUser = (user) => {
    selectedUser.value = user;
    document.body.classList.add('overflow-hidden');
};

const closeUser = () => {
    selectedUser.value = null;
    document.body.classList.remove('overflow-hidden');
};

const handleUserChanged = async () => {
    await loadUsers();

    if (!selectedUser.value) {
        return;
    }

    const updatedUser = users.value.find((user) => user.id === selectedUser.value.id);

    if (updatedUser) {
        selectedUser.value = updatedUser;
    }
};

onMounted(loadUsers);
</script>
