<template>
    <div>
        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Дом успешно создан</div>

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
                                  @input="loadCity">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.district">
                        {{ errors.district[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right">Город</label>

                <div class="col-md-6">
                    <model-select id="city" name="city" :options="city_options"
                                  v-model="city_item"
                                  placeholder="Выберите город" :required="city_item.value == ''"
                                  @input="loadStreet">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.city">
                        {{ errors.city[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="street" class="col-md-4 col-form-label text-md-right">Улица</label>

                <div class="col-md-6">
                    <model-select id="street" name="street" :options="street_options"
                                  v-model="street_item"
                                  placeholder="Выберите улицу" :required="street_item.value == ''">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.street">
                        {{ errors.street[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="house_number" class="col-md-4 col-form-label text-md-right">Номер дома</label>

                <div class="col-md-6">
                    <input id="house_number" type="text" class="form-control" name="house_number" v-model="fields.house_number" required>
                    <div class="alert alert-danger" v-if="errors && errors.house_number">
                        {{ errors.house_number[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="information" class="col-md-4 col-form-label text-md-right">Информация</label>

                <div class="col-md-6">
                    <input id="information" type="text" class="form-control" name="information" v-model="fields.information">
                    <div class="alert alert-danger" v-if="errors && errors.information">
                        {{ errors.information[0] }}
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

                city_options: [

                ],
                city_item: {
                    value: '',
                    text: ''
                },
                city_value_last: {
                    value: ''
                },

                street_options: [

                ],
                street_item: {
                    value: '',
                    text: ''
                },
                street_value_last: {
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

                if(this.street_item.value == "" || this.street_item.value == 0){
                    this.errors = { street: { 0: "Не выбрана улица"}};
                }

                if(!isEmpty(this.errors)) return;

                this.fields.street_id = this.street_item.value;

                axios.post('/api/houses', this.fields).then(response => {
                    this.success = true;
                    this.fields = {};
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            house_number: error.response.data.data.house_number
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
                    if (error.response.status != 200) {
                        this.errors = { area: error.response.data.data.area_id};
                    }
                });
            },
            loadCity() {
                if(this.district_item.value === this.district_value_last.value) return;

                this.district_value_last.value = this.district_item.value;

                if(this.district_item.value == "" || this.district_item.value == 0){
                    this.city_options = [];
                    return;
                }

                var self = this
                this.city_options = [];
                axios.get('/api/cities/district_id/'+this.district_item.value).then(response => {

                    $.each(response.data.data, function (i, data) {
                        self.city_options.push({value: data.id, text:
                                (data.type == null ? "" : data.type + " ") +
                                data.name + (data.category == null ? "" :  " " + data.category)});
                    });

                }).catch(error => {
                    if (error.response.status != 200) {
                        this.city = { city: error.response.data.data.city_id}
                    }
                });
            },
            loadStreet() {
                if(this.city_item.value === this.city_value_last.value) return;

                this.city_value_last.value = this.city_item.value;

                if(this.city_item.value == "" || this.city_item.value == 0){
                    this.street_options = [];
                    return;
                }

                var self = this
                this.street_options = [];
                axios.get('/api/streets/city_id/'+this.city_item.value).then(response => {

                    $.each(response.data.data, function (i, data) {
                        self.street_options.push({value: data.id, text: data.type + " " + data.name});
                    });

                }).catch(error => {
                    if (error.response.status != 200) {
                        this.street = { street: error.response.data.data.street_id}
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
