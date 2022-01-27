<template>
    <div>

        <form @submit.prevent="">

            <div class="alert alert-success" v-show="success">Участок успешно создан</div>

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
                                  placeholder="Выберите город" :required="city_item.value == ''">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.city">
                        {{ errors.city[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="spot_name" class="col-md-4 col-form-label text-md-right">Название участка</label>

                <div class="col-md-6">
                    <input id="spot_name" type="text" class="form-control" name="spot_name" v-model="fields.spot_name" required>
                    <div class="alert alert-danger" v-if="errors && errors.spot_name">
                        {{ errors.spot_name[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-right">Номер телефона</label>

                <div class="col-md-6">
                    <input id="phone_number" type="text" class="form-control" name="phone_number" v-model="fields.phone_number" required>
                    <div class="alert alert-danger" v-if="errors && errors.phone_number">
                        {{ errors.phone_number[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">Адрес</label>

                <div class="col-md-6">
                    <input id="address" type="text" class="form-control" name="address" v-model="fields.address" required>
                    <div class="alert alert-danger" v-if="errors && errors.address">
                        {{ errors.address[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="information" class="col-md-4 col-form-label text-md-right">Информация</label>

                <div class="col-md-6">
                    <input id="information" type="text" class="form-control" name="information" v-model="fields.information" required>
                    <div class="alert alert-danger" v-if="errors && errors.information">
                        {{ errors.information[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="point_x" class="col-md-4 col-form-label text-md-right">Координата X</label>

                <div class="col-md-6">
                    <input id="point_x" type="text" class="form-control" name="point_x" v-model="fields.point_x">
                    <div class="alert alert-danger" v-if="errors && errors.point_x">
                        {{ errors.point_x[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="point_y" class="col-md-4 col-form-label text-md-right">Координата Y</label>

                <div class="col-md-6">
                    <input id="point_y" type="text" class="form-control" name="point_y" v-model="fields.point_y">
                    <div class="alert alert-danger" v-if="errors && errors.point_y">
                        {{ errors.point_y[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    Привязать к
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px"  v-on:click="submitDistrict">
                        Району
                    </button>
                    <button type="submit" class="btn btn-primary" style="margin-left: 50px"  v-on:click="submitCity">
                        Городу
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

                city_options: [

                ],
                city_item: {
                    value: '',
                    text: ''
                },
                city_value_last: {
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
            submitDistrict() {
                this.success = false;
                this.errors = {};

                if(this.district_item.value == "" || this.district_item.value == 0){
                    this.errors = { district: { 0: "Не выбран район"}};
                }

                if(!isEmpty(this.errors)) return;

                this.fields.district_id = this.district_item.value;

                axios.post('/api/spots', this.fields).then(response => {
                    this.success = true;
                    this.fields = {};
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            district: error.response.data.data.district_name,
                            spot_name: error.response.data.data.spot_name,
                            information: error.response.data.data.information,
                            phone_number: error.response.data.data.phone_number,
                            address: error.response.data.data.address,
                        };
                    }
                }).finally(() => {

                });
            },
            submitCity() {
                this.success = false;
                this.errors = {};

                if(this.city_item.value == "" || this.city_item.value == 0){
                    this.errors = { city: { 0: "Не выбран город"}};
                }

                if(this.district_item.value == "" || this.district_item.value == 0){
                    this.errors = { district: { 0: "Не выбран район"}};
                }

                if(!isEmpty(this.errors)) return;

                this.fields.district_id = this.district_item.value;
                this.fields.city_id = this.city_item.value;

                axios.post('/api/spots', this.fields).then(response => {
                    this.success = true;
                    this.fields = {};
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            district: error.response.data.data.district_name,
                            spot_name: error.response.data.data.spot_name,
                            information: error.response.data.data.information,
                            phone_number: error.response.data.data.phone_number,
                            address: error.response.data.data.address,
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
