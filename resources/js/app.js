import './bootstrap';
import './helpers';

//jQuery-ui
require('jquery-ui/ui/widgets/tooltip');

//UiKit
require('uikit');

//Google Analytics
require('./googleAnalytics').init();

//Background slide show
require('./background').init();

//Vue and associated pieces
const Vue = require('vue');
const Vuex = require('vuex');
const VueRouter = require('vue-router').default;

Vue.use(Vuex);
Vue.use(VueRouter);

//Modals
Vue.component('about', require('./components/About').default);
Vue.component('validation', require('./components/ValidationCheck').default);
Vue.component('load-dialog', require('./components/LoadDialog').default);
Vue.component('new-character-modal', require('./components/Modals/NewCharacterModal').default);


Vue.component('points-tracker', require('./components/PointsTracker').default);
Vue.component('panel-one', require('./components/PanelOne').default);
Vue.component('main-menu', require('./components/MainMenu').default);

const store = new Vuex.Store({
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

const router = new VueRouter({
    mode: 'history',
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

window.app = new Vue({
    el: '#container',
    store,
    router,
});