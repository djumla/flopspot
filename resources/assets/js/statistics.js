/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
import Vue from 'vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Pie from './components/Statistics/Overall.vue';
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

const app = new Vue({
  el: '#app',
  components: {
    'flopspot-header': Header,
    'flopspot-pie': Pie,
    'flopspot-footer': Footer
  }
})
