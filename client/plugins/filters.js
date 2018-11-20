import Vue from 'vue'

Vue.filter('trim', val => val.endsWith('P')?parseInt(val):val)