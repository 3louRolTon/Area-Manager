<template>
    <div>

        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Область успешно создана</div>

            <div class="form-group row">
                <label for="area" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <input id="area" type="text" class="form-control" name="area" v-model="fields.area_name" required>
                    <div class="alert alert-danger" v-if="errors && errors.area">
                        {{ errors.area[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Отправить
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { ModelSelect } from 'vue-search-select'


    export default {
        data() {
            return {
                fields: {},
                success: false,
                errors: {},
                isLoading: false
            }
        },
        mounted() {

        },
        methods: {
            submit() {
                this.success = false;
                this.errors = {};

                axios.post('/api/areas', this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = { area: error.response.data.data.area_name};
                    }
                }).finally(() => {

                });
            }
        },
        components: {
            ModelSelect
        }
    }
</script>
