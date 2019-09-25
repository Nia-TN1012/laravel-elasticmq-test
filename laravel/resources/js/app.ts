import Vue from 'vue'
import JobListComponent from './JobListComponent.vue';

require('./bootstrap');

Vue.component( 'job-list-component', JobListComponent );

const jobList = new Vue({
    el: '#job-list'
});
