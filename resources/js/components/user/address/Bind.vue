<template>
    <div>

        <form @submit.prevent="">

            <div class="alert alert-success" v-show="success">Успешно привязано</div>

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
                <label for="spot" class="col-md-4 col-form-label text-md-right">Участок</label>

                <div class="col-md-6">
                    <model-select id="spot" name="spot" :options="spot_options"
                                  v-model="spot_item"
                                  placeholder="Выберите участок" :required="spot_item.value == ''">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.spot">
                        {{ errors.spot[0] }}
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
                                  placeholder="Выберите улицу" :required="street_item.value == ''"
                                  @input="loadHouse">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.street">
                        {{ errors.street[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="house" class="col-md-4 col-form-label text-md-right">Дома</label>

                <div class="col-md-6">
                    <multi-select id="house" name="house" :options="house_options"
                                  :selected-options="house_selected_options"
                                  @select="onSelect"
                                  placeholder="Выберите дома" >
                    </multi-select>
                    <div class="alert alert-danger" v-if="errors && errors.house">
                        {{ errors.house[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary" v-on:click="submitHouse">
                        Привязать дома
                    </button>
                    <button type="submit" class="btn btn-primary" v-on:click="submitCity">
                        Привязать город
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { ModelSelect } from 'vue-search-select'
    import { MultiSelect } from 'vue-search-select'

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

                spot_options: [

                ],
                spot_item: {
                    value: '0',
                    text: '-'
                },
                spot_value_last: {
                    value: ''
                },

                city_options: [

                ],
                city_item: {
                    value: '0',
                    text: '-'
                },
                city_value_last: {
                    value: ''
                },

                street_options: [

                ],
                street_item: {
                    value: '0',
                    text: '-'
                },
                street_value_last: {
                    value: ''
                },

                house_options: [

                ],
                house_selected_options: [

                ],

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
            submitCity() {
                this.success = false;
                this.errors = {};

                if(this.spot_item.value == "" || this.spot_item.value == 0){
                    this.errors = { spot: { 0: "Не выбран участок"}};
                }

                if(this.city_item.value == "" || this.city_item.value == 0){
                    this.errors = { city: { 0: "Не выбран город"}};
                }

                if(!isEmpty(this.errors)) return;

                this.fields.spot_id = this.spot_item.value;
                this.fields.cities_id = [this.city_item.value];

                axios.post('/api/cities/bind', this.fields).then(response => {
                    this.success = true;
                    this.fields = {};
                    this.city_item = {value: 0, text: 0};
                    this.city_value_last = 0;
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            spot: error.response.data.data.spot_id,
                            city: error.response.data.data.cities_id
                        };
                    }
                }).finally(() => {

                });
            },
            submitHouse() {
                this.success = false;
                this.errors = {};

                if(this.spot_item.value == "" || this.spot_item.value == 0){
                    this.errors = { spot: { 0: "Не выбран участок"}};
                }

                if(this.house_selected_options.length == 0){
                    this.errors = { house: { 0: "Не выбраны дома"}};
                }

                if(!isEmpty(this.errors)) return;

                let houses = [];
                this.house_selected_options.forEach(function(item) {
                    houses.push(item.value);
                });

                this.fields.spot_id = this.spot_item.value;
                this.fields.houses_id = houses;

                axios.post('/api/houses/bind', this.fields).then(response => {
                    this.success = true;
                    this.fields = {};
                    this.house_selected_options = [];
                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = {
                            spot: error.response.data.data.spot_id,
                            house: error.response.data.data.houses_id
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
            loadCity() {
                if(this.district_item.value === this.district_value_last.value) return;

                this.district_value_last.value = this.district_item.value;

                if(this.district_item.value == "" || this.district_item.value == 0){
                    this.city_options = [];
                    this.spot_options = [];
                    return;
                }

                var self = this
                this.city_options = [];
                this.spot_options = [];

                axios.get('/api/spots/district_id/'+this.district_item.value).then(response => {

                    $.each(response.data.data, function (i, data) {
                        self.spot_options.push({value: data.id, text: data.name});
                    });

                }).catch(error => {
                    if (error.response.status != 200) {
                        this.errors = { spot: error.response.data.data.spot_id};
                    }
                });

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
            },
            loadHouse() {
                if(this.street_item.value === this.street_value_last.value) return;

                this.street_value_last.value = this.street_item.value;

                if(this.street_item.value == "" || this.street_item.value == 0){
                    this.house_options = [];
                    return;
                }

                var self = this
                this.house_options = [];
                this.house_selected_options = [];
                axios.get('/api/houses/street_id/'+this.street_item.value).then(response => {

                    $.each(response.data.data, function (i, data) {
                        self.house_options.push({value: data.id, text: data.number});
                    });

                }).catch(error => {
                    if (error.response.status != 200) {
                        this.house = { house: error.response.data.data.house_id}
                    }
                });
            },
            onSelect (items) {
                this.house_selected_options = items;
            }

        },
        components: {
            ModelSelect,
            MultiSelect
        }
    }

    function isEmpty(obj) {
        for(let key in obj) {
            return false
        }
        return true
    }
</script>
