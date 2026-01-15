<template>
    <div :id="id" class="uk-flex-top" v-on:toggle="toggled" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical game-style epcc-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-text-center">
                <h1><b><u>Settings</u></b></h1>
                <form class="uk-form-horizontal settings-form">
                    <div class="settings-row settings-grid">
                        <div class="settings-label">
                            <label class="uk-form-label" for="darkMode">Dark theme</label>
                        </div>
                        <div class="settings-control">
                            <input class="uk-checkbox" type="checkbox" id="darkMode" v-model="darkModeEnabled" @change="applySettings">
                        </div>
                    </div>
                    <div class="settings-row settings-grid">
                        <div class="settings-label">
                            <label class="uk-form-label" for="backgroundEnabled">Background images</label>
                        </div>
                        <div class="settings-control">
                            <input class="uk-checkbox" type="checkbox" id="backgroundEnabled" v-model="backgroundEnabled" @change="applySettings">
                        </div>
                    </div>
                    <div class="settings-row settings-grid">
                        <div class="settings-label">
                            <label class="uk-form-label" for="remoteBackgrounds">Remote background images</label>
                            <span class="btnhelp slowTransition icon-question" :title="remoteImagesHelp"></span>
                        </div>
                        <div class="settings-control">
                            <input class="uk-checkbox" type="checkbox" id="remoteBackgrounds" v-model="remoteBackgroundsEnabled" :disabled="!backgroundEnabled" @change="applySettings">
                        </div>
                    </div>
                    <div class="uk-margin-top settings-actions">
                        <button type="button" class="popupInnerButton settings-action" uk-toggle="target: #about-modal">
                            About
                        </button>
                        <button type="button" class="popupInnerButton closeButton settings-action" :uk-toggle="'target: #' + confirmId">
                            Clear Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div :id="confirmId" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical game-style epcc-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-text-center">
                <h1><b><u>Clear Session?</u></b></h1>
                <p>Clearing the current session will erase all currently loaded data.</p>
                <div class="uk-margin-top settings-actions">
                    <button type="button" class="popupInnerButton settings-action" @click="clearSessionConfirmed" uk-modal-close>
                        Clear Session
                    </button>
                    <button type="button" class="popupInnerButton closeButton settings-action" uk-modal-close>
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import urls from "../../urls";

    export default {
        name: "Settings",
        props: {
            id: String
        },
        computed: {
            confirmId: function () {
                return this.id ? `${this.id}-clear-confirm` : 'settings-clear-confirm';
            }
        },
        data: function () {
            return {
                darkModeEnabled: true,
                backgroundEnabled: true,
                remoteBackgroundsEnabled: true,
                remoteImagesHelp: 'Remote images are larger and may use more data.',
            }
        },
        methods: {
            toggled: function () {
                if (!this.$el.classList.contains('uk-open')) {
                    this.loadSettings();
                }
            },
            loadSettings: function () {
                const isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
                const remoteDefault = !isMobile;
                this.darkModeEnabled = this.readThemeSetting();
                this.backgroundEnabled = this.readBoolSetting('epcc.background.enabled', true);
                this.remoteBackgroundsEnabled = this.readBoolSetting('epcc.background.remoteEnabled', remoteDefault);
            },
            readThemeSetting: function () {
                try {
                    const value = localStorage.getItem('epcc.theme.mode');
                    if (value === null) {
                        return true;
                    }
                    return value !== 'light';
                } catch (error) {
                    return true;
                }
            },
            readBoolSetting: function (key, fallback) {
                try {
                    const value = localStorage.getItem(key);
                    if (value === null) {
                        return fallback;
                    }
                    return value === 'true';
                } catch (error) {
                    return fallback;
                }
            },
            applySettings: function () {
                try {
                    localStorage.setItem('epcc.theme.mode', this.darkModeEnabled ? 'dark' : 'light');
                    localStorage.setItem('epcc.background.enabled', this.backgroundEnabled ? 'true' : 'false');
                    localStorage.setItem('epcc.background.remoteEnabled', this.remoteBackgroundsEnabled ? 'true' : 'false');
                } catch (error) {
                    console.log('Unable to persist settings');
                }
                if (window.applyThemeSettings) {
                    window.applyThemeSettings();
                }
                if (window.applyBackgroundSettings) {
                    window.applyBackgroundSettings();
                }
            },
            clearSessionConfirmed: function () {
                axios.delete(urls.creator)
                    .then(() => {
                        location.reload();
                    })
                    .catch(error => {
                        console.log('Error clearing session');
                        console.log(error);
                        location.reload();
                    });
            }
        }
    }
</script>

<style scoped>
.settings-row {
    margin-bottom: 0.75em;
}

.settings-form {
    display: inline-block;
    text-align: left;
    margin: 0 auto;
    max-width: 24em;
    width: 100%;
}

.settings-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    column-gap: 0.5em;
    align-items: center;
}

.settings-label {
    display: flex;
    align-items: center;
    gap: 0.15em;
}

.settings-label .uk-form-label {
    margin: 0;
    line-height: 1.4;
}

.settings-label .btnhelp {
    float: none;
    padding-right: 0;
    opacity: 0.9;
    margin-left: 0;
    line-height: 1;
    color: var(--epcc-text);
}

.settings-control {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.settings-control .uk-checkbox {
    margin: 0;
    width: 18px;
    height: 18px;
}

.settings-actions {
    display: flex;
    justify-content: center;
    gap: 0.75em;
}

.settings-action {
    min-width: 160px;
    white-space: nowrap;
}
</style>
