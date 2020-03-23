<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <line-chart :chart-data="data" :height="100"
                            :options="{responsive: true, maintainAspectRation: true}"></line-chart>
                <input type="checkbox" v-model="realtime"> realtime
                <input type="text" v-model="label">
                <input type="text" v-model="sale">
                <button @click="sendData" class="btn btn-primary btn-xs text mt-1 mh-100">Обновить</button>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from './LineChart';

    export default {
        components: {
            LineChart
        },
        data: function () {
            return {
                data: [], //массив c данными для построения графика
                realtime: false,
                label: "",
                sale: 5000,
            }
        },
        mounted() {
            var socket = io('http://localhost:3000'); // добавил клиент для связи с сервером

            socket.on("news-action:App\\Events\\NewEvent", function (data) {
                this.data = data.result;
            }.bind(this));
            this.update() // для получения начальных даннфх для построения графика, за начальную отрисовку
        },
        methods: {
            update: function () {
                axios.get('/start/socket-chart').then((response) => {
                    this.data = response.data
                });
            },
            sendData: function () {

                axios({
                    method: 'get',
                    url: '/start/socket-chart',
                    params: {label: this.label, sale: this.sale, realtime: this.realtime}
                }).then((response) => {
                    this.data = response.data
                });
            }
        }
    }
</script>
