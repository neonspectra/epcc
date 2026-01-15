import './bootstrap';
import './helpers';

//jQuery-ui
require('jquery-ui/ui/widgets/tooltip');

//UiKit
require('uikit');

//Theme
require('./theme').init();

//Background slide show
require('./background').init();

//Vue and associated pieces
import { createApp, h } from 'vue';
import { createStore } from 'vuex';
import { createRouter, createWebHistory, RouterView } from 'vue-router';
import VueGtag from 'vue-gtag-next';

//Modals
const store = createStore({
    modules: {
        highLevel: require('./store/modules/highLevelCreator').default,
        character: require('./store/modules/character').default,
    },
    state: {
        firstTime: true
    },
    mutations: {
        markFirstTime(state, payload) {
            state.firstTime = false;
        }
    },
});

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'main',
            component: require('./pages/Main').default
        },
        {
            path: '/welcome',
            name: 'welcome',
            component: require('./pages/Welcome').default
        },
    ],
});

const app = createApp({
    render: () => h(RouterView),
});

app.component('about', require('./components/modals/About').default);
app.component('settings-modal', require('./components/modals/Settings').default);
app.component('validation', require('./components/modals/ValidationCheck').default);
app.component('load-dialog', require('./components/modals/LoadDialog').default);
app.component('new-character-modal', require('./components/modals/NewCharacterModal').default);
app.component('points-tracker', require('./components/PointsTracker').default);
app.component('panel-one', require('./components/PanelOne').default);
app.component('main-menu', require('./components/MainMenu').default);

app.use(store);
app.use(router);

const analyticsId = window.env && window.env.VITE_GOOGLE_ANALYTICS_ID;
if (analyticsId) {
    app.use(VueGtag, {
        property: {
            id: analyticsId,
        },
    }, router);
}

//Do an initial check on the creator during the first page load
//This must be done here, so we can wait for the asynchronous call to complete before finishing routing
router.beforeEach((to, from, next) => {
    if(store.state.firstTime) {
        store.commit('markFirstTime');
        store.dispatch('highLevel/getHighLevelCreatorInfo')
            .then(() => {
                next()
            }).catch(() => {next()});
        return
    }
    next();
});

router.beforeEach((to, from, next) => {
    //Go to the welcome page if the creator does not exist
    if(!store.getters['highLevel/creatorExists'] && to.name !== 'welcome') {
        next({name: 'welcome'});
        return;
    }
    //Do not allow access to the welcome page while a creator exists
    if(store.getters['highLevel/creatorExists'] && to.name === 'welcome') {
        //Prevent infinite recursion, with a default
        if (from.name === 'welcome') {
            next({name: 'main'});
            return;
        }
        next(from);
        return;
    }
    next();
});

window.app = app.mount('#container');
