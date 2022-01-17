<template>
    <div>

        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Область успешно обновлена</div>

            <div class="form-group row">
                <label for="area" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <model-select id="area" name="area" :options="area_options"
                                  v-model="area_item"
                                  placeholder="Выберите область" :required="area_item.value == ''"
                                  @input="loadCurrentArea">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.area">
                        {{ errors.area[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="district" class="col-md-4 col-form-label text-md-right">Название области</label>

                <div class="col-md-6">
                    <input id="area_name" type="text" class="form-control" name="area_name" v-model="fields.area_name" required>
                    <div class="alert alert-danger" v-if="errors && errors.area_name">
                        {{ errors.area_name[0] }}
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
        props: ['data'],
        data() {
            return {
                area_options: [

                ],
                area_item: {
                    value: '0',
                    text: '-'
                },
                area_value_last: {
                    value: ''
                },

                fields: {},
                success: false,
                errors: {},
                isLoading: false
            }
        },
        mounted() {
            var self = this

            $.each(this.data, function (i, data) {
                self.area_options.push({value: data.id, text: data.area_name});
            });
        },
        methods: {
            submit() {
                this.success = false;
                this.errors = {};

                if(this.area_item.value == "" || this.area_item.value == 0){
                    this.errors = { area: { 0: "Не выбрана область"}}
                }

                if(!isEmpty(this.errors)) return

                this.fields.area_id = this.area_item.value

                axios.put('/api/areas/'+this.area_item.value, this.fields).then(response => {
                    this.area_options.forEach(function(item) {
                        if(item.value == response.data.data.id) item.text = response.data.data.name;
                    });
                    this.success = true;
                    this.fields = {};
                    this.area_value_last.value = 0;
                    this.area_item = {value: '', text: ''};
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            area_id: error.response.data.data.area_id,
                            area_name: error.response.data.data.area_name
                        };
                    }
                }).finally(() => {

                });
            },
            loadCurrentArea() {
                if(this.area_item.value === this.area_value_last.value) return;

                this.area_value_last.value = this.area_item.value;

                if(this.area_item.value == "" || this.area_item.value == 0){
                    this.fields = {
                        district_name: ""
                    }
                }

                axios.get('/api/areas/'+this.area_item.value).then(response => {

                    this.fields = {
                        area_name: response.data.data.name
                    }

                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = { area: error.response.data.data.area_id};
                    }
                });
            }

        },
        components: {
            ModelSelect
        }
    }

    function isEmpty(obj) {
        for(let key in obj) {
            return false
        }
        return true
    }
</script>
