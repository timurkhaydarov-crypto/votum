import { computed, ref } from 'vue';
import { authApi } from '../services/authApi';

const user = ref(null);
const isLoading = ref(false);
let loadPromise = null;

export function useCurrentUser() {

    const canManage = computed(() => {
        const role = user.value?.role;
        return role === 'admin' || role === 'manager';
    });

    const loadUser = async () => {
        if (loadPromise) {
            return loadPromise;
        }

        isLoading.value = true;
        loadPromise = authApi.me()
            .then((data) => {
                user.value = data;
            })
            .catch((error) => {
                if (error?.status === 401) {
                    user.value = null;
                    return;
                }

                throw error;
            })
            .finally(() => {
                isLoading.value = false;
                loadPromise = null;
            });

        return loadPromise;
    };

    return {
        user,
        isLoading,
        canManage,
        loadUser,
    };
}
