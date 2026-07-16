<template>
  <div v-if="minimal" class="p-0 d-flex flex-column align-items-center gap-2 w-100">
    <div v-if="streamUrl" :id="playerId" style="width:100%;max-width:450px;height:400px;"></div>
    <div v-else class="text-muted text-center py-4 w-100">
      <div v-if="loading" class="mb-2">
        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
        {{ $gettext('Loading...') }}
      </div>
      <div v-else>
        <i class="material-icons text-muted" style="font-size:48px;">radio</i>
        <p class="mt-2">{{ $gettext('No active streams available.') }}</p>
      </div>
    </div>
  </div>
  <card-page v-else header-id="hdr_lunaradio" :title="$gettext('Live Radio Player')">
    <div class="p-3 d-flex flex-column align-items-center gap-2">
      <div v-if="streamUrl" :id="playerId" style="width:100%;max-width:450px;height:400px;"></div>
      <div v-else class="text-muted text-center py-4 w-100">
        <div v-if="loading" class="mb-2">
          <span class="spinner-border spinner-border-sm me-2" role="status"></span>
          {{ $gettext('Loading...') }}
        </div>
        <div v-else>
          <i class="material-icons text-muted" style="font-size:48px;">radio</i>
          <p class="mt-2">{{ $gettext('No active streams available.') }}</p>
        </div>
      </div>

      <div v-if="streamUrl" class="d-flex gap-2 mt-2">
        <button class="btn btn-sm btn-outline-primary" @click="showSettings = !showSettings">
          <i class="material-icons" style="font-size:16px;">settings</i>
          {{ $gettext('Customize') }}
        </button>
      </div>

      <div v-if="showSettings" class="w-100 border rounded p-3 mt-2" style="max-width:450px;">
        <h6 class="fw-bold mb-3">{{ $gettext('Player Settings') }}</h6>
        <div class="row g-2">
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Radio Name') }}</label>
            <input v-model="cfg.radioname" class="form-control form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Cover Image URL') }}</label>
            <input v-model="cfg.coverimage" class="form-control form-control-sm" @input="queueSave" placeholder="pegar url del logo aqui..">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Main Color') }} 1</label>
            <input v-model="cfg.color1" type="color" class="form-control form-control-color form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Main Color') }} 2</label>
            <input v-model="cfg.color2" type="color" class="form-control form-control-color form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Main Color') }} 3</label>
            <input v-model="cfg.color3" type="color" class="form-control form-control-color form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Main Color') }} 4</label>
            <input v-model="cfg.color4" type="color" class="form-control form-control-color form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Background') }}</label>
            <input v-model="cfg.backgroundcolor" class="form-control form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Font Color') }}</label>
            <input v-model="cfg.fontcolor" type="color" class="form-control form-control-color form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Highlight Color') }}</label>
            <input v-model="cfg.hightlightcolor" type="color" class="form-control form-control-color form-control-sm" @input="queueSave">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Font') }}</label>
            <input v-model="cfg.fontname" class="form-control form-control-sm" @input="queueSave" placeholder="Saira Condensed">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Google Font') }}</label>
            <input v-model="cfg.googlefont" class="form-control form-control-sm" @input="queueSave" placeholder="Saira+Condensed:wght@700">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Font Ratio') }}</label>
            <input v-model="cfg.fontratio" class="form-control form-control-sm" @input="queueSave" placeholder="0.5">
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Cover Style') }}</label>
            <select v-model="cfg.coverstyle" class="form-select form-select-sm" @change="queueSave">
              <option value="circle">Circle</option>
              <option value="animated">Animated</option>
              <option value="square">Square</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Visualizer') }}</label>
            <select v-model="cfg.usevisualizer" class="form-select form-select-sm" @change="queueSave">
              <option value="fake">{{ $gettext('Fake') }}</option>
              <option value="real">{{ $gettext('Real') }}</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Visualizer Type') }}</label>
            <select v-model="cfg.visualizertype" class="form-select form-select-sm" @change="queueSave">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Auto Play') }}</label>
            <select v-model="cfg.autoplay" class="form-select form-select-sm" @change="queueSave">
              <option value="true">{{ $gettext('Yes') }}</option>
              <option value="false">{{ $gettext('No') }}</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label small">{{ $gettext('Volume') }}</label>
            <input v-model="cfg.volume" type="number" class="form-control form-control-sm" min="0" max="100" @input="queueSave">
          </div>
          <div class="col-12">
            <label class="form-label small">{{ $gettext('Offline Text') }}</label>
            <input v-model="cfg.offlinetext" class="form-control form-control-sm" @input="queueSave" placeholder="Radio is offline">
          </div>
        </div>
        <hr class="my-2">
        <div class="d-flex justify-content-between align-items-center">
          <div class="small text-muted">{{ $gettext('Settings are saved automatically and synced across all devices.') }}</div>
          <button class="btn btn-sm btn-primary" type="button" @click="handleSave">
            {{ $gettext('Save Changes') }}
          </button>
        </div>
      </div>
    </div>
  </card-page>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref, nextTick, computed } from "vue";
import CardPage from "~/components/Common/CardPage.vue";
import { useStationData, useStationId } from "~/functions/useStationQuery.ts";
import { useApiRouter } from "~/functions/useApiRouter.ts";
import { useNotify } from "~/components/Common/Toasts/useNotify.ts";
import { useTranslate } from "~/vendor/gettext";
import { useAxios } from "~/vendor/axios";

const props = defineProps<{
  minimal?: boolean;
  stationShortName?: string;
}>();
const playerId = "lnr_" + Math.random().toString(36).substring(2, 9);
const streamUrl = ref("");
const loading = ref(true);
const showSettings = ref(false);
let destroyed = false;
let pollTimer: any = null;
let saveTimer: any = null;

const stationData = useStationData();
const stationId = useStationId();

const { axios } = useAxios();

const stationIdentifier = computed(() => {
  if (props.stationShortName) {
    return props.stationShortName;
  }
  const id = Number(stationId.value);
  return (!isNaN(id) && id > 0) ? id : "loading";
});

const { getStationApiUrl } = useApiRouter();
const configUrl = getStationApiUrl("/lunaradio-config", stationIdentifier);
const metadataUrl = getStationApiUrl("/icy-metadata", stationIdentifier);

interface PlayerConfig {
  radioname: string;
  coverimage: string;
  backgroundcolor: string;
  fontcolor: string;
  hightlightcolor: string;
  fontname: string;
  googlefont: string;
  fontratio: string;
  coverstyle: string;
  usevisualizer: string;
  visualizertype: string;
  autoplay: string;
  volume: string;
  offlinetext: string;
  color1: string;
  color2: string;
  color3: string;
  color4: string;
  [key: string]: string;
}

const cfg = ref<PlayerConfig>({
  radioname: "",
  coverimage: "",
  backgroundcolor: "rgba(9,15,25,0.8)",
  fontcolor: "#cbf3f0",
  hightlightcolor: "#fcf6bd",
  fontname: "Saira Condensed",
  googlefont: "Saira+Condensed:wght@700",
  fontratio: "0.5",
  coverstyle: "animated",
  usevisualizer: "real",
  visualizertype: "3",
  autoplay: "true",
  volume: "100",
  offlinetext: "Radio is offline",
  color1: "#00FF00",
  color2: "#ffff00",
  color3: "#FF1F6F",
  color4: "#FF1F6F",
});

const resolveStreamUrl = (np: any): string => {
  if (np?.station?.mounts?.length > 0 && np.station.mounts[0].url)
    return np.station.mounts[0].url;
  if (np?.station?.remotes?.length > 0 && np.station.remotes[0].url)
    return np.station.remotes[0].url;
  if (np?.station?.hls_url) return np.station.hls_url;
  return "";
};

const getShortName = (): string => {
  if (props.stationShortName) {
    return props.stationShortName;
  }
  try { return stationData.value?.shortName || ""; } catch { return ""; }
};

const loadScript = (url: string): Promise<void> =>
  new Promise((resolve, reject) => {
    if (document.querySelector(`script[src="${url}"]`)) { resolve(); return; }
    const s = document.createElement("script");
    s.src = url;
    s.onload = () => resolve();
    s.onerror = () => reject(new Error("fail " + url));
    document.head.appendChild(s);
  });

const loadSettings = async () => {
  try {
    if (!configUrl.value) return;
    const { data } = await axios.get(configUrl.value);
    if (data && typeof data === "object") {
      cfg.value = { ...cfg.value, ...data };
    }
  } catch (e) {
    console.error("load settings err:", e);
  }
};

const queueSave = () => {
  if (saveTimer) clearTimeout(saveTimer);
  saveTimer = setTimeout(saveSettings, 1000);
};

const saveSettings = async () => {
  try {
    if (!configUrl.value) return;
    await axios.put(configUrl.value, cfg.value);
  } catch (e) {
    console.error("save settings err:", e);
  }
};

const { notifySuccess } = useNotify();
const { $gettext } = useTranslate();

const handleSave = async () => {
  if (saveTimer) clearTimeout(saveTimer);
  await saveSettings();
  notifySuccess($gettext("Changes saved."));
  if (streamUrl.value) {
    await initPlugin(streamUrl.value);
  }
};

const initPlugin = async (url: string) => {
  if (destroyed) return;

  await loadScript("https://code.jquery.com/jquery-3.7.1.min.js");
  await loadScript("/static/lunaradio.min.js");
  await nextTick();
  if (destroyed) return;

  const $ = (window as any).jQuery;
  if (!$?.fn?.lunaradio) return;

  const el = document.getElementById(playerId);
  if (!el) return;
  if ($(el).data("lunaradio")) $(el).lunaradio("destroy");

  $(el).lunaradio({
    userinterface: "big",
    streamurl: url,
    autoplay: cfg.value.autoplay,
    volume: cfg.value.volume,
    color1: cfg.value.color1,
    color2: cfg.value.color2,
    color3: cfg.value.color3,
    color4: cfg.value.color4,
    backgroundcolor: cfg.value.backgroundcolor,
    fontcolor: cfg.value.fontcolor,
    hightlightcolor: cfg.value.hightlightcolor,
    fontname: cfg.value.fontname,
    googlefont: cfg.value.googlefont,
    fontratio: cfg.value.fontratio,
    radioname: cfg.value.radioname,
    coverimage: cfg.value.coverimage,
    coverstyle: cfg.value.coverstyle,
    onlycoverimage: "false",
    usevisualizer: cfg.value.usevisualizer,
    visualizertype: cfg.value.visualizertype,
    itunestoken: "1000lIPN",
    metadatatechnic: "ownmetadataurl",
    ownmetadataurl: metadataUrl.value,
    streamtype: "icecast2",
    icecastmountpoint: "",
    shoutcastid: "1",
    metadatainterval: "26000",
    debug: "false",
    displayliveicon: "true",
    displayvisualizericon: "true",
    multicolorvisualizer: "true",
    visualizeropacity: "0.9",
    uselocalstorage: "true",
    corsproxy: "",
    usestreamcorsproxy: "false",
  });
};

const fetchNowPlaying = async () => {
  if (destroyed) return;
  const shortName = getShortName();
  if (!shortName) return;

  try {
    const r = await fetch(`/api/nowplaying/${shortName}`);
    if (!r.ok) return;
    const np = await r.json();
    if (destroyed) return;

    const url = resolveStreamUrl(np);
    if (!url) return;

    if (np.station?.name && !cfg.value.radioname) {
      cfg.value.radioname = np.station.name;
    }

    if (streamUrl.value !== url) {
      streamUrl.value = url;
      loading.value = false;
      await nextTick();

      await loadSettings();
      await initPlugin(url);
    }
  } catch (e) {
    console.error("luna fetch err", e);
    loading.value = false;
  }
};

onMounted(() => {
  fetchNowPlaying();
  pollTimer = setInterval(fetchNowPlaying, 30000);
});

onUnmounted(() => {
  destroyed = true;
  if (pollTimer) clearInterval(pollTimer);
  if (saveTimer) clearTimeout(saveTimer);
  try {
    const $ = (window as any).jQuery;
    const el = document.getElementById(playerId);
    if ($ && el && $(el).data("lunaradio")) $(el).lunaradio("destroy");
  } catch {}
});
</script>
