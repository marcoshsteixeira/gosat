import './bootstrap'
import "../../node_modules/bootstrap/dist/js/bootstrap.js"
import { createApp } from 'vue'

import Cpf from './components/cpf.vue'

const app = createApp({
    components: { Cpf }
})

app.mount('#app')
