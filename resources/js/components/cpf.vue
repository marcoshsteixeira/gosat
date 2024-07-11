<template>
    <div class="row">
        <div class="mb-12">
            <h3>Sistema de consulta de empréstimos por CPF</h3>
        </div>
    </div>

    <div class="row">
        <label for="cpf" class="form-label">Digite um CPF (Valores válidos: 11111111111, 12312312312, 22222222222)</label>
        <div class="col-5">
            <input id="cpf-field" class="form-control mb-5" type="phone" placeholder="CPF" aria-label="default input">
        </div>
        <div class="col-5">
            <button type="button" class="btn btn-primary" @click="findCpf()" data-bs-target="#cpf-modal">Consultar</button>
        </div>
    </div>

    <div id="cpf-modal" class="modal fade">
        asdasd
    </div>

</template>
<script setup>
    import { ref } from 'vue'

    function findCpf() {
        axios.post('http://127.0.0.1:8000/api/simulacao/credito', {
            cpf: document.getElementById("cpf-field").value,
        })
        .then(function (response) {
            document.getElementById("cpf-modal").Modal
        })
        .catch(function (error) {
            alert(error.response.data.error);
        });
    }
</script>
