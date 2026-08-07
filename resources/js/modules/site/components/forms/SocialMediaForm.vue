<template>
    <div class="space-y-4">
        <div v-for="media in socialMediaList" :key="media.id"
            class="flex items-center gap-4 border-b border-gray-100 pb-3">
            <!-- Иконка -->
            <div class="flex h-full w-7 items-center justify-center">
                <i :class="['bi', `${media.icon}`, 'text-xl text-gray-500']" aria-hidden="true" />
            </div>

            <!-- Поля -->
            <div class="flex-1 space-y-2">
                <!-- Платформа -->
                <Select v-model="media.platform" @update:modelValue="updateMediaIcon(media)"
                    :name="`platform-${media.id}`" :options="socialMediaOptions" height="h-7" option-value="platform"
                    option-label="value" required />

                <!-- Ссылка -->
                <Input v-model="media.url" height="h-7" :name="`url-${media.id}`" placeholder="https://example.com"
                    :icon="`bi ${Icon.LINK}`" type="text" required />
            </div>

            <!-- Удалить -->
            <button v-if="socialMediaList.length > 1" type="button"
                :class="`flex h-7 w-7 items-center justify-center rounded-lg text-gray-400 transition-colors cursor-pointer hover:text-red-500`"
                @click="deleteHandler({ id: media.id, value: media.platform })">
                <i :class="['bi', Icon.TRASH]"></i>
            </button>
        </div>
    </div>
</template>



<script setup>
import { computed, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { ActionType } from '../../constants/actions';
import Input from '../UI/form/Input.vue'
import Select from '../UI/form/Select.vue'
import { socialMedia } from '../../constants/social.js'
import { Icon } from '../../constants/icons';

const { t } = useI18n();
const socialMediaOptions = computed(() => socialMedia(t));
const socialMediaList = ref([])
const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ type: null, action: null, item: null }),
    },
});

const normalizeMedia = (media) => {
    const options = socialMediaOptions.value;
    const current = String(media?.platform ?? '').toLowerCase();

    const selected = options.find((option) =>
        [option.platform, option.icon, String(option.value).toLowerCase()].includes(current)
    );

    if (!selected) {
        return media;
    }

    return {
        ...media,
        platform: selected.platform,
        icon: selected.icon,
    };
};

const updateMediaIcon = (media) => {
    const icon = socialMediaOptions.value.find(
        option => option.platform === media.platform
    )?.icon;

    if (icon) media.icon = icon;
};

const emit = defineEmits(['submit', 'delete']);
const deleteHandler = (item) => {
    socialMediaList.value = socialMediaList.value.filter(
        media => media.id !== item.id
    );
    emit('delete', item);
};

const submit = () => {
    if (props.settings.action !== ActionType.ADD) {
        return;
    }

    const [media] = socialMediaList.value.map(normalizeMedia);

    if (media) {
        emit('submit', media);
    }
};

watch(
    () => props.settings.item,
    (item) => {
        const items = Array.isArray(item) ? item : [];
        socialMediaList.value = items.map(media =>
            normalizeMedia({ ...media })
        );
    },
    { immediate: true }
);

defineExpose({
    submit
})
</script>
