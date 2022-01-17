<template>
    <div>

        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Город успешно создан</div>

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
                                  placeholder="Выберите район" :required="district_item.value == ''">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.district">
                        {{ errors.district[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="city_name" class="col-md-4 col-form-label text-md-right">Название города</label>

                <div class="col-md-6">
                    <input id="city_name" type="text" class="form-control" name="city_name" v-model="fields.city_name" required>
                    <div class="alert alert-danger" v-if="errors && errors.city_name">
                        {{ errors.city_name[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="city_type" class="col-md-4 col-form-label text-md-right">Тип улицы</label>

                <div class="col-md-6">
                    <input id="city_type" type="text" class="form-control" name="city_type" v-model="fields.city_type">
                    <div class="alert alert-danger" v-if="errors && errors.city_type">
                        {{ errors.city_type[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="city_category" class="col-md-4 col-form-label text-md-right">Сельсовет</label>

                <div class="col-md-6">
                    <input id="city_category" type="text" class="form-control" name="city_category" v-model="fields.city_category">
                    <div class="alert alert-danger" v-if="errors && errors.city_category">
                        {{ errors.city_category[0] }}
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
        props: ['data', 'district'],
        data() {
            return {
                area_options: [

                ],
                area_item: {
                    value: '',
                    text: ''
                },
                area_value_last: {
                    value: ''
                },

                district_options: [

                ],
                district_item: {
                    value: '',
                    text: ''
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
                    this.errors = { district: { 0: "Не выбран район"}};
                }

                if(!isEmpty(this.errors)) return;

                this.fields.district_id = this.area_item.value;

                axios.post('/api/cities', this.fields).then(response => {
                    this.success = true;
                    this.fields = {};
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            district: error.response.data.data.district_name,
                            city_name: error.response.data.data.city_name
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
                axios.get('/api/districts/area_id/'+this.area_item.value+"?district="+this.district).then(response => {

                    $.each(response.data.data, function (i, data) {
                        self.district_options.push({value: data.id, text: data.name});
                    });

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
