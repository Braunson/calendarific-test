require('./bootstrap');

// Import InertiaJS
import {
    InertiaApp
} from '@inertiajs/inertia-vue'
import Vue from 'vue'

Vue.use(InertiaApp)

// Import Buefy & MDI
import '@mdi/font/css/materialdesignicons.css'
import Buefy from 'buefy'
Vue.use(Buefy)

const app = document.getElementById('app')

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(app)
