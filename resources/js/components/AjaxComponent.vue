<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <button
                    @click="update"
                    class="btn btn-success text mb-1"
                    v-if="!is_refresh"
                >
                    Обновить - {{ id }}...
                </button>
                <span class="badge badge-primary mb-1" v-if="is_refresh"
                    >Обновление...</span
                >
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="url in urldata" :key="url.id">
                            <td>{{ url.title }}</td>
                            <td>{{ url.url }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            urldata: [], //массив который мы получим от контролера
            is_refresh: false, //булева значение ,  будет опред статус аякс запроса
            id: 0 //переменнная для итерации нажатия клавиши
        };
    },
    mounted() {
        this.update();
    },
    methods: {
        update: function() {
            this.is_refresh = true;
            axios.get("/start/get-json/").then(response => {
                console.log(response);
                this.urldata = response.data;
                this.is_refresh = false;
                this.id++;
            });
        }
    }
};
</script>
