<template>
    <div>

        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Район успешно обновлен</div>

            <div class="form-group row">
                <label for="area" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <model-select id="area" name="area" :options="area_options"
                                  v-model="area_item"
                                  placeholder="Выберите область"
                                  :required="area_item.value == ''"
                                  @input="loadDistrict">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.area">
                        {{ errors.area[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="district" class="col-md-4 col-form-label text-md-right">Район</label>

                <div class="col-md-6">
                    <model-select id="district" name="district" :options="district_options"
                                  v-model="district_item"
                                  placeholder="Выберите район" :required="district_item.value == ''"
                                  @input="loadCurrentDistrict">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.district">
                        {{ errors.district[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="district_name" class="col-md-4 col-form-label text-md-right">Название района</label>

                <div class="col-md-6">
                    <input id="district_name" type="text" class="form-control" name="district_name" v-model="fields.district_name" required>
                    <div class="alert alert-danger" v-if="errors && errors.district_name">
                        {{ errors.district_name[0] }}
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

                district_options: [

                ],
                district_item: {
                    value: '0',
                    text: '-'
                },
                district_value_last: {
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

                if(this.district_item.value == "" || this.district_item.value == 0){
                    this.errors = { district: { 0: "Не выбран район"}}
                }

                if(!isEmpty(this.errors)) return

                this.fields.area_id = this.area_item.value
                axios.put('/api/districts/'+this.district_item.value, this.fields).then(response => {
                    this.district_options.forEach(function(item) {
                        if(item.value == response.data.data.id) item.text = response.data.data.name;
                    });
                    this.success = true;
                    this.fields = {};
                    this.district_value_last.value = 0;
                    this.district_item = {value: '', text: ''};
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            area_id: error.response.data.data.area_id,
                            district_name: error.response.data.data.district_name
                        };
                    }
                }).finally(() => {

                });
            },
            loadDistrict() {
                if(this.area_item.value === this.area_value_last.value) return;

                this.area_value_last.value = this.area_item.value;

                if(this.area_item.value == "" || this.area_item.value == 0){
                    this.district_options = [];
                }

                var self = this
                this.district_options = [];
                axios.get('/api/districts/area_id/'+this.area_item.value).then(response => {

                    $.each(response.data.data, function (i, data) {
                        self.district_options.push({value: data.id, text: data.name});
                    });

                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = { area: error.response.data.data.area_id};
                    }
                });
            },
            loadCurrentDistrict() {
                if(this.district_item.value === this.district_value_last.value) return;

                this.district_value_last.value = this.district_item.value;

                if(this.district_item.value == "" || this.district_item.value == 0){
                    this.fields = {
                        district_name: ""
                    }
                }

                axios.get('/api/districts/'+this.district_item.value).then(response => {

                    this.fields = {
                        district_name: response.data.data.name
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
