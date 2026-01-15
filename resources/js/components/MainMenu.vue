<template>
    <div id="mainMenu">
        <a href="/api/creator/save">
            <button @click="$ga.event('character', 'save')" class="popupButton">
                Save
            </button>
        </a>
        <button class="popupButton" uk-toggle="target: #load-modal">
            Load
        </button>
        <load-dialog id="load-modal"></load-dialog>
        <button class="popupButton" uk-toggle="target: #validation-modal">
            Check
        </button>
        <validation id="validation-modal"></validation>
        <div class='dropdown'>
            <button class="popupButton" id="exportButton">
                Export
                &#x25BC;
            </button>
            <div class='dropdown-content'>
                <ul>
                    <li>
                        <a @click="$ga.event('character', 'export', 'pdf')" href="/export/pdf" target="_blank">
                            PDF
                        </a>
                    </li>
                    <li>
                        <a @click="$ga.event('character', 'export', 'txt')" href="/export/txt" target="_blank">
                            TXT
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <button class="popupButton" uk-toggle="target: #new-character-modal">
            New
        </button>
        <new-character-modal id="new-character-modal"></new-character-modal>
        <button class="popupButton" uk-toggle="target: #settings-modal">
            Settings
        </button>
        <settings-modal id="settings-modal"></settings-modal>
        <about id="about-modal"></about>
    </div>
</template>

<script>
    export default {
        name: "MainMenu"
    }
</script>

<style scoped>

</style>
