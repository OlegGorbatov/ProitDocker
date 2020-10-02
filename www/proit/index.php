<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta name="keywords" content="Адресная книга" />
    <meta name="description" content="Тестовое приложение для ProIt" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>Адресная книга | Тестовое приложение для ProIt</title>

    <script src="/assets/js/jquery-3.5.1.min.js"></script>
    <script src="/assets/js/vue.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>

    <link href="/assets/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet"/>
    <link href="/assets/css/style.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-light">

<div class="main-page">
    <div class="content">
        <h1 class="mt-5">Адресная книга</h1>
        <div id="app">
            <template>
                <button class="btn btn-info mt-4" @click = "isVisible = !isVisible">Добавить контакт</button>
                <div class="number-contacts mt-4">
                    <label for="numberRecords">Отобразить контактов:</label>
                    <input  type="text"
                            class="rounded align-bottom mt-2"
                            name="numberRecords"
                            id="numberRecords"
                            v-model="numberRecords"
                            @change="loadSomeContacts"
                    />
                    <button class="btn btn-success">Ок</button>

                </div>
                <button class="btn btn-primary mt-4" v-if="isVisible" @click="createContact">Сохранить</button>
                <button v-if="createSuccessful"
                         class="btn btn-warning mt-4"
                         style="cursor: default !important;"
                         v-on:mouseleave="createSuccessful=false">Сохранено успешно!
                </button>
                <ul class="list-group mt-4" v-if="isVisible">
                    <li class="list-group-item " id="fio" >
                        <div class="row justify-content-between">
                            <div><label for="fio">Введите ФИО:</label></div>
                            <div><input id="fio" type="text" v-model.trim="newFio" /></div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div><label for="email" >Введите E-mail:</label></div>
                            <div><input id="email" type="text" v-model.trim="newEmail" /></div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div><label for="phone">Введите телефон:</label></div>
                            <div><input id="phone" type="text" v-model.trim="newPhone" /></div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div><label for="city">Введите город:</label></div>
                            <div><input id="city" type="text" v-model.trim="newCity" /></div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div><label for="addressLine">Введите адрес:</label></div>
                            <div><input id="addressLine" type="text" v-model.trim="newAddressLine" /></div>
                        </div>
                    </li>
                </ul>
            </template>
            <template>
                <table class="table table-bordered table-hover mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><a href="#" v-on:click="sortByFIO(), ascName=!ascName">ФИО<i class="material-icons">unfold_more</i></a></th>
                        <th scope="col"><a href="#" v-on:click="sortByEmail(), ascEmail=!ascEmail">E-mail<i class="material-icons">unfold_more</i></a></th>
                        <th scope="col"><a href="#" v-on:click="sortByPhone(), ascPhone=!ascPhone">Телефон<i class="material-icons">unfold_more</i></a></th>
                        <th scope="col"><a href="#" v-on:click="sortByCity(), ascCity=!ascCity">Город<i class="material-icons">unfold_more</i></a></th>
                        <th scope="col"><a href="#" v-on:click="sortByAddress(), ascAddress=!ascAddress">Адрес<i class="material-icons">unfold_more</i></a></th>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="thead-light table-striped">
                    <tr v-for="item in contacts" :key="item.id">
                        <td>{{ item.fio }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.phone }}</td>
                        <td>{{ item.city }}</td>
                        <td>{{ item.addressLine }}</td>
                    </tr>
                    </tbody>

                </table>
           </template>
        </div>
    </div>
</div>


<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                newFio: '',
                newEmail: '',
                newPhone: '',
                newCity: '',
                newAddressLine: '',

                ascName: false,
                ascEmail: false,
                ascPhone: false,
                ascCity: false,
                ascAddress: false,

                numberRecords: 5,
                createSuccessful: false,

                isVisible: false,
                contacts: [],
                content: this.$http.get('/api/show-contacts')
                    .then(response => {
                        return response.json()
                    })
                    .then(contacts => {
                        this.contacts = contacts
//                        console.log(contacts)
                    })
            }
        },
        methods: {
            createContact() {
                const contact = {
                    fio: this.newFio,
                    email: this.newEmail,
                    phone: this.newPhone,
                    city: this.newCity,
                    addressLine: this.newAddressLine
                }

                this.$http.post('/api/create-contacts', contact)
                    .then(response => {
                        //console.log(response)
                        return response.json()
                    })
                    .then(newContact => {
                        console.log(newContact)
                    })
                this.isVisible = false
                this.createSuccessful = true
            },
            sortByFIO(e){
                this.ascName ?
                    this.contacts.sort((a,b) => a.fio.localeCompare(b.fio)):
                    this.contacts.sort((a,b) => b.fio.localeCompare(a.fio))
            },
            sortByEmail(){
                this.ascEmail ?
                    this.contacts.sort((a,b) => a.email.localeCompare(b.email)):
                    this.contacts.sort((a,b) => b.email.localeCompare(a.email))
            },
            sortByPhone(){
                this.ascPhone ?
                    this.contacts.sort((a,b) => a.phone.localeCompare(b.phone)):
                    this.contacts.sort((a,b) => b.phone.localeCompare(a.phone))
            },
            sortByCity(){
                this.ascCity ?
                    this.contacts.sort((a,b) => a.city.localeCompare(b.city)):
                    this.contacts.sort((a,b) => b.city.localeCompare(a.city))
            },
            sortByAddress(){
                this.ascAddress ?
                    this.contacts.sort((a,b) => a.addressLine.localeCompare(b.addressLine)):
                    this.contacts.sort((a,b) => b.addressLine.localeCompare(a.addressLine))
            },
            loadSomeContacts(){
                let uri = "/api/show-contacts?numberRecords="+this.numberRecords
                this.$http.get(uri)
                    .then(response => {
                        return response.json()
                    })
                    .then(contacts => {
                        this.contacts = contacts
                    })
            }
        },
    })
</script>
</body>
</html>