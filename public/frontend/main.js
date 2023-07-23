import App from './App.js';
const { createApp } = Vue;
import router from './router.js';
import { bsModalError } from './helper.js';

axios.defaults.baseURL = '/api';
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    bsModalError(error.response.data.title, error.response.data.detail);

    return Promise.reject(error);
});

const emitter = mitt();
const app = createApp(App);

moment.locale(navigator.language);

app.config.globalProperties.$emitter = emitter;
app.config.globalProperties.$filters = {
    toLocaleString(dateStr) {
        return new Date(dateStr).toLocaleString(navigator.language);
    },
    formatDate(dateStr) {
        return moment(dateStr).fromNow();
    }
};

app.use(router)
    .use(VueAxios, axios)
    .mount('#app');
