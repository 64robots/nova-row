Nova.booting((Vue, router) => {
  Vue.component('index-nova-row', require('./components/IndexField'));
  Vue.component('detail-nova-row', require('./components/DetailField'));
  Vue.component('form-nova-row', require('./components/FormField'));
});
