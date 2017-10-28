import Vue from 'vue'
import App from './App'
import router from './router'

import store from './store' //vuex

import axios from 'axios' //axios
import VueAxios from 'vue-axios'
import qs from 'qs' //axios qs模块

Vue.config.productionTip = false

Vue.use(VueAxios, axios)
axios.defaults.transformRequest = [function (data) {
  return qs.stringify(data)
}]                            //qs模块全局配置

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store, //vuex
  template: '<App/>',
  components: { App }
})