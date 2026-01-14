<template>
    <div :id="id" class="uk-flex-top" v-on:toggle="toggled" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical game-style">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <a href="https://github.com/neonspectra/epcc"><img style="position: absolute; top: 0; left: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_gray_6d6d6d.png" alt="Fork me on GitHub"></a>
            <div class="uk-text-center">
                <h1><b><u> About</u></b></h1>
                <p>EPCC ({{versionName}})</p>
                <p>Version {{version}} ({{releaseDate}})</p>
                <p>Commit {{commitLabel}}</p>
                <p>A character creation and management tool for <a href="http://eclipsephase.com" target="_blank">Eclipse Phase (First Edition)</a>.</p>
                <p>
                    Please submit all suggestions and bug reports to the
                    <a href="https://github.com/neonspectra/epcc/issues" target="_blank">Issues</a>
                    page.
                </p>
                <p>
                    Maintained by:
                    <b>neon@neosynth.net</b>
                </p>
                <p>
                    Original created by:
                    <b>Russell Bewley, </b>
                    <b>Stoo Goof, </b>
                    <b>Derek Payne, </b>
                    <b>Cédric Reinhardt, </b>
                    <b>Jigé Pont, </b>
                    <b>Olivier Murith, </b>
                    <b>Arthur Moore</b>
                </p>
                <a rel="license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target="_blank">
                    <img alt="Creative Commons License" style="border-width:0"
                         src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png"/>
                </a>
                <p>
                    <small>
                        This work is licensed under a
                        <a rel="license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/"
                           target="_blank">
                            Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License
                        </a>
                        .
                    </small>
                </p>
                <p>
                    <small>
                        This work is a derivative work based on <a href="https://github.com/Eclipse-Phase-Unofficial/ep-character-creator">previous work by Arthur Moore and other authors</a> licensed under a
                        <a rel="license" href="https://creativecommons.org/licenses/by-nc-sa/3.0/deed.en_US"
                           target="_blank">
                            Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License
                        </a>
                        . Changes were made.
                    </small>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import urls from "../../urls";

    export default {
        name: "About",
        props: {
            id: String
        },
        data: function () {
            return {
                versionName: '',
                releaseDate: '',
                version: 0,
                commit: ''
            }
        },
        computed: {
            commitLabel: function () {
                return this.commit ? ` (${this.commit})` : '';
            }
        },
        methods: {
            // This happens whenever the Modal is shown/hidden (via UiKit)
            toggled: function (event) {
                //This is run before uk-open is applied, so the absence means shown
                if(!this.$el.classList.contains('uk-open')) {
                    if (this.$ga && this.$ga.page) {
                        this.$ga.page('/about');
                    }
                }
                //Only do this once per run
                //TODO:  This could be done in VueX and used everywhere
                if (!this.version) {
                    axios.get(urls.version)
                    .then(response => {
                        this.version = response.data.version;
                        this.versionName = response.data.versionName;
                        this.releaseDate = response.data.releaseDate;
                        this.commit = response.data.commit || '';
                    })
                    .catch(error => {
                        console.log('Error getting version data');
                        console.log(error)
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>
