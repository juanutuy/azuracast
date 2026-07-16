<template>
    <div class="luna-widget-container">
        <lunaradio-player :minimal="true" :station-short-name="stationShortName" />
    </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import LunaradioPlayer from "~/components/Stations/Profile/LunaradioPlayer.vue";

const props = defineProps<{
    nowPlayingProps?: {
        stationShortName: string;
    };
}>();

const stationShortName = computed(() => props.nowPlayingProps?.stationShortName || "");
</script>

<style scoped>
.luna-widget-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
