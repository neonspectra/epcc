<template>
<!--    <div id="popup">-->
    <div class="game-box uk-padding-remove">
    <article class="game-box uk-article">
        <h1 class="uk-article-title">Welcome to EPCC, the Eclipse Phase 1E Character Creator</h1>
        <p class="uk-article-meta">A chatacter creation and management tool for <a href="http://eclipsephase.com/">Eclipse Phase (First Edition)</a></p>
<!--    TODO:  This is the welcome page for people who don't have a creator already set up-->
<!--    TODO:  Better Styling-->
<!--    People should be able to create a new character, or load an old one from this page.-->
        <p>It looks like this is your first time here, or your session has expired.</p>

        <div class="uk-flex uk-flex-around uk-flex-wrap">
        <div class="uk-card uk-card-body uk-card-default uk-width-1-3@m uk-text-center game-style">
            <h3 class="uk-card title">Choose!</h3>
            <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom" uk-toggle="target: #new-character-modal">New Character</button>
            <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom" uk-toggle="target: #load-modal">Continue?</button>
            <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom" uk-toggle="target: #settings-modal">Settings</button>
            <new-character-modal id="new-character-modal"></new-character-modal>
            <load-dialog id="load-modal"></load-dialog>
            <settings-modal id="settings-modal"></settings-modal>
            <about id="about-modal"></about>
        </div>

        <div class="uk-card uk-card-body uk-card-default uk-width-1-3@m game-style">
            <h3 class="uk-card title">What is this?</h3>
            <p>
                This tool allows you to create and export character sheets for use with the <a href="http://eclipsephase.com/">Eclipse Phase First Edition (1E)</a> tabletop roleplaying game.
                Stats are automatically calculated based on appropriate Ego and Morph aptitudes so that you can focus on just playing the game.
            </p>
            <p>
                This website is not endorsed by or affiliated with <a href="https://posthuman.shop/">Posthuman Studios</a> in any way. 
                Although Eclipse Phase 1E is now out of print, please consider supporting its creators by purchasing digital copies of the official rulebooks, supplements, or other merch.
            </p>
        </div>
        </div>

        <p>Please submit all suggestions and bug reports to the GitHub <a href="https://github.com/neonspectra/epcc/issues" target="_blank">Issues</a> page.</p>

        <p class="disclaimer"><b>Mandatory EU Notice: </b>
            This site uses JavaScript and cookies to function.  By continuing to use this site, you consent to the following privacy policy.
            The creators of this site do not sell your data to anyone.
            This policy may be updated at any time.
        </p>

<!--    Idea on how to fix session expiration:  Timer in Javascript that retrieves the save pack and stores it in localStorage every few minutes.  On page load it checks the store and auto loads it.-->
    </article>
    </div>
</template>

<script>
    export default {
        name: "Welcome"
    }
</script>

<style scoped>
    .disclaimer {
        font-size: x-small;
    }
</style>
