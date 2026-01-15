<template>
<!--    <div id="popup">-->
    <div class="welcome-page">
    <article class="welcome-shell uk-article game-style">
        <h1 class="uk-article-title">Welcome to EPCC, the Eclipse Phase 1E Character Creator</h1>
        <p class="uk-article-meta">A chatacter creation and management tool for <a href="http://eclipsephase.com/">Eclipse Phase (First Edition)</a></p>
<!--    TODO:  This is the welcome page for people who don't have a creator already set up-->
<!--    TODO:  Better Styling-->
<!--    People should be able to create a new character, or load an old one from this page.-->
        <p>It looks like this is your first time here, or your session has expired.</p>

        <div class="uk-grid uk-grid-medium uk-child-width-1-2@m uk-grid-match" uk-grid>
        <div>
            <div class="uk-card uk-card-body uk-card-default uk-text-center welcome-card">
                <h3 class="uk-card title">Choose!</h3>
                <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom" uk-toggle="target: #new-character-modal">New Character</button>
                <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom" uk-toggle="target: #load-modal">Continue?</button>
                <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom" uk-toggle="target: #settings-modal">Settings</button>
                <new-character-modal id="new-character-modal"></new-character-modal>
                <load-dialog id="load-modal"></load-dialog>
                <settings-modal id="settings-modal"></settings-modal>
                <about id="about-modal"></about>
            </div>
        </div>

        <div>
            <div class="uk-card uk-card-body uk-card-default welcome-card">
                <h3 class="uk-card title">What is this?</h3>
                <p>
                    This tool allows you to create and export character sheets for use with the <a href="https://posthuman.shop/products/eclipse-phase-first-edition-pdf">Eclipse Phase First Edition (1E)</a> tabletop roleplaying game.
                </p>
                <p>
                    This website is not endorsed by or affiliated with <a href="https://posthumanstudios.com/">Posthuman Studios</a> in any way. 
		    If you enjoy Eclipse Phase, please consider <a href="https://posthuman.shop/"supporting them</a>.
                </p>
            </div>
        </div>
        </div>

        <p class="welcome-links">Please submit all suggestions and bug reports to the <a href="https://github.com/neonspectra/epcc/issues" target="_blank">GitHub Issues</a> page.</p>

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
    .welcome-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .welcome-shell {
        width: min(100%, 980px);
        padding: 1.5rem;
        background: var(--epcc-surface);
        border-radius: 0.75rem;
    }

    .welcome-card {
        background: var(--epcc-surface);
        border: 1px solid var(--epcc-border-panel);
        border-radius: 0.75rem;
    }

    .welcome-links {
        margin-top: 1.25rem;
    }

    .disclaimer {
        font-size: x-small;
    }

    @media (max-width: 640px) {
        .welcome-shell {
            padding: 1.25rem;
        }
    }
</style>
