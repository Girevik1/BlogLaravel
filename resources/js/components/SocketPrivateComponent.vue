<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row form-group">
                    <div class="col-sm-4">
                        <select name="" multiple="" class="form-control" id="" v-model="usersSelect">
                            <option v-for="user in users" :value="'news-action.'+ user.id">{{user.email}}</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <textarea rows="6" class="form-control" readonly="">{{dataMessages.join('\n')}}</textarea>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Наберите сообщение" v-model="message">
                    <div class="input-group-append">
                        <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                dataMessages: [],
                message: "",
                usersSelect: []
            }
        },
        props: [
            'users',
            'user'
        ],
        created() {
            var socket = io.connect('http://localhost:3000'); // добавил клиент для связи с сервером

            socket.on("news-action." + this.user.id + ":App\\Events\\PrivateMessage", function (data) { // отловит канал на стороне клиента
                console.log(data.message)
                this.dataMessages.push(data.message.user + ': ' + data.message.message)
            }.bind(this));
            socket.on("news-action.:App\\Events\\PrivateMessage", function (data) {
                this.dataMessages.push(data.message.user + ': ' + data.message.message)
            }.bind(this));
        },
        methods: {
            sendMessage: function () {
                if (!this.usersSelect.length)
                    this.usersSelect.push('news-action.');

                axios({
                    method: 'get',
                    url: '/start/send-private-message',
                    params: {channels: this.usersSelect, message: this.message, user: this.user.email}
                }).then((response) => {
                    this.dataMessages.push(this.user.email + ': ' + this.message);
                    app.message = "";
                });
            }
        }
    }
</script>
