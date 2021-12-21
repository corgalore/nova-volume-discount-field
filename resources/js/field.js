Nova.booting((Vue, router, store) => {
  Vue.component('index-volume-discount', require('./components/IndexField'))
  Vue.component('detail-volume-discount', require('./components/DetailField'))
  Vue.component('form-volume-discount', require('./components/FormField'))
})
