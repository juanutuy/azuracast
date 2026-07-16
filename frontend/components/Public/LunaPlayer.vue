<template>
    <div class="public-page d-flex align-items-center justify-content-center min-vh-100" style="background: #233D4D; color: #EAECF0; padding: 20px;">
        <div class="card w-100" style="max-width: 600px; background: #14222B; border: 1px solid #2F4D5E; box-shadow: 0 8px 30px rgba(0,0,0,0.5); border-radius: 12px; overflow: hidden;">
            <div class="card-body text-center pt-4">
                <h1 class="h2 card-title mb-2 text-white font-weight-bold" style="letter-spacing: -0.5px;">
                    {{ stationName }}
                </h1>
                <p class="text-muted mb-4">{{ $gettext('Transmisión Oficial') }}</p>

                <div class="my-4 px-2">
                    <!-- Lunaradio Dynamic Player Embedded -->
                    <lunaradio-player :minimal="true" :station-short-name="stationShortName" />
                </div>
            </div>

            <div class="card-body buttons d-flex justify-content-center gap-3 pt-0 pb-4 border-0">
                <a
                    v-if="enableRequests"
                    class="btn btn-outline-primary px-3"
                    style="border-color: #FE7F2D; color: #FE7F2D;"
                    @click.prevent="openRequestModal"
                >
                    <icon-ic-help class="align-middle me-1"/>
                    <span>{{ $gettext('Pedir Canción') }}</span>
                </a>
                <a
                    class="btn btn-outline-light px-3"
                    style="border-color: #EAECF0; color: #EAECF0;"
                    :href="downloadPlaylistUri"
                >
                    <icon-ic-cloud-download class="align-middle me-1"/>
                    <span>{{ $gettext('Playlist') }}</span>
                </a>
            </div>
        </div>
    </div>

    <request-modal
        v-if="enableRequests"
        ref="$requestModal"
        v-bind="requests"
    />
</template>

<script setup lang="ts">
import { useTemplateRef, computed } from "vue";
import RequestModal from "~/components/Public/FullPlayer/RequestModal.vue";
import LunaradioPlayer from "~/components/Stations/Profile/LunaradioPlayer.vue";
import { RequestsProps } from "~/components/Public/Requests.vue";
import IconIcCloudDownload from "~icons/ic/baseline-cloud-download";
import IconIcHelp from "~icons/ic/baseline-help";

const props = defineProps<{
    stationName: string;
    enableRequests?: boolean;
    downloadPlaylistUri: string;
    player: any;
    requests: RequestsProps;
}>();

const stationShortName = computed(() => props.player?.nowPlayingProps?.stationShortName || "");

const $requestModal = useTemplateRef("$requestModal");

const openRequestModal = () => {
    $requestModal.value?.open();
};
</script>

<style lang="scss" scoped>
.btn-outline-primary:hover {
    background-color: #FE7F2D !important;
    color: #000000 !important;
}
.btn-outline-light:hover {
    background-color: #EAECF0 !important;
    color: #000000 !important;
}
</style>
