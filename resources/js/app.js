require('./bootstrap');

window.Vue = require('vue');
Vue.component('video-upload', require('./components/VideoUpload.vue').default);
Vue.component('video-player', require('./components/VideoPlayer.vue').default);
Vue.component('video-vote', require('./components/VideoVote.vue').default);
Vue.component('video-comments', require('./components/VideoComments.vue').default);
Vue.component('subscribe-button', require('./components/SubscribeButton.vue').default);

const app = new Vue({
    el: '#app',
    data: window.app,
});
