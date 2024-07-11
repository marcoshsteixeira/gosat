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

    <div id="cpf-modal" class="modal fade" aria-labelledby="cpf-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Lista de empréstimos por CPF</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="emprestimos" class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Instituição</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Código</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="emprestimos-body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="propose()">Melhores propostas</button>
                </div>
            </div>
        </div>
    </div>

    <div id="propose-modal" class="modal fade" aria-labelledby="propose-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Melhores propostas de empréstimo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="propostas" class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Instituição</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Valor a pagar</th>
                            <th scope="col">Juros</th>
                            <th scope="col">Parcelas</th>
                            </tr>
                        </thead>
                        <tbody id="propostas-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="details-modal" class="modal fade" aria-labelledby="details-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Detalhes do empréstimo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detalhes">

                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
    import { ref } from 'vue'

    let btn = document.getElementsByClassName('details')
    btn.onClick = (event) => {
        console.log(event)
        details(cpf, institution, modality)
    };

    function findCpf() {
        let cpf = document.getElementById("cpf-field").value
        axios.post('http://127.0.0.1:8000/api/simulacao/credito', {
            cpf: cpf,
        })
        .then(function (response) {
            const myModal = new bootstrap.Modal('#cpf-modal', {})
            myModal.show()

            let tb = document.getElementById('emprestimos-body')
            let data = ''
            for (const [keyOld, valueOld] of Object.entries(response.data)) {
                let line = 1
                for (const [key, value] of Object.entries(valueOld.modalities)) {
                    data += '<tr>'+
                        '<td>' + line + '</td>'+
                        '<td>' + valueOld.name + '</td>'+
                        '<td>' + value.name + '</td>'+
                        '<td>' + value.code + '</td>'+
                        '<td> <button type="button" class="btn btn-info details" data-cpf="'+cpf+'" data-institution="'+valueOld.id+'" data-code="'+value.code+'">Detalhes</button> </td>'+
                        '</tr>'
                    line++
                }
            }

            tb.innerHTML = data
        })
        .catch(function (error) {
            alert(error.response.data.error);
        });
    }

    function propose() {
        axios.get('http://127.0.0.1:8000/api/simulacao/melhor-oferta', {
        })
        .then(function (response) {
            const myModal = new bootstrap.Modal('#propose-modal', {})
            myModal.show()

            let tb = document.getElementById('propostas-body')
            let data = ''
            let line = 1
            for (const [key, value] of Object.entries(response.data)) {
                data += '<tr>'+
                    '<td>' + line + '</td>'+
                    '<td>' + value.institution + '</td>'+
                    '<td>' + value.modality + '</td>'+
                    '<td>' + value.value + '</td>'+
                    '<td>' + value.payValue + '</td>'+
                    '<td>' + value.fess + '</td>'+
                    '<td>' + value.portion + '</td>'+
                    '</tr>'
                line++
            }

            tb.innerHTML = data
        })
        .catch(function (error) {
            alert('Houve um erro para encontrar as propostas.');
        });
    }

    function details(cpf, institution, modality) {
        axios.post('http://127.0.0.1:8000/api/simulacao/oferta', {
            cpf: cpf,
            institution: institution,
            modality: modality
        })
        .then(function (response) {
            const myModal = new bootstrap.Modal('#details-modal', {})
            myModal.show()

            let tb = document.getElementById('detalhes')
            let data = ''
            for (const [key, value] of Object.entries(response.data)) {
                data += '<p>Mínimo de parcelas: ' + value.minPortion + '</p>'+
                    '<p>Máximo de parcelas: ' + value.maxPortion + '</p>'+
                    '<p>Valor mínimo: ' + value.minValue + '</p>'+
                    '<p>Valor máximo: ' + value.maxValue + '</p>'+
                    '<p>Juros: ' + value.fess + '</p>'
                line++
            }

            tb.innerHTML = data
        })
        .catch(function (error) {
            alert('Houve um erro para encontrar os detalhes.');
        });
    }
</script>
