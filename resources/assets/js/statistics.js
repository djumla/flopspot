/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
import Vue from 'vue';

/**
 * Production config
 * May set false to true in development
 */
Vue.config.productionTip = false;
Vue.config.devtools = false;
Vue.config.debug = false;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Overall from './components/Statistics/Overall.vue';
import Footer from './components/Footer.vue';

const app = new Vue({
  el: '#app',

  components: {
    'flopspot-overall': Overall,
    'flopspot-footer': Footer
  }
});
