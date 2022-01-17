<template>
    <div>

        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Дома успешно отвязаны</div>

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
                                  @input="loadSpot">
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
                                  placeholder="Выберите участок" :required="spot_item.value == ''"
                                  @input="loadBindHouse">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.spot">
                        {{ errors.spot[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right">Города</label>

                <div class="col-md-6">
                    <multi-select id="city" name="city" :options="city_options"
                                  :selected-options="city_selected_options"
                                  @select="onSelect"
                                  placeholder="Выберите города" >
                    </multi-select>
                    <div class="alert alert-danger" v-if="errors && errors.city">
                        {{ errors.city[0] }}
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
import { MultiSelect } from 'vue-search-select'

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

            spot_options: [

            ],
            spot_item: {
                value: '',
                text: ''
            },
            spot_value_last: {
                value: ''
            },

            city_options: [

            ],
            city_selected_options: [

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
        submit() {
            this.success = false;
            this.errors = {};

            if(this.city_selected_options.length == 0){
                this.errors = { city: { 0: "Не выбраны города"}};
            }

            if(!isEmpty(this.errors)) return;

            let cities = [];
            this.city_selected_options.forEach(function(item) {
                cities.push(item.value);
            });
            this.fields.cities_id = cities;

            axios.post('/api/cities/unbind', this.fields).then(response => {
                this.success = true;
                this.fields = {};
                this.spot_value_last.value = 0;
                this.spot_item = {value: '', text: ''};
                this.city_selected_options = [];
                this.city_options = [];
            }).catch(error => {
                if (error.response.status != 200) {
                    this.errors = {
                        city: error.response.data.data.cities_id,
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
        loadSpot() {
            if(this.district_item.value === this.district_value_last.value) return;

            this.district_value_last.value = this.district_item.value;

            if(this.district_item.value == "" || this.district_item.value == 0){
                this.spot_options = [];
            }

            var self = this
            this.spot_options = [];
            axios.get('/api/spots/district_id/'+this.district_item.value).then(response => {

                $.each(response.data.data, function (i, data) {
                    self.spot_options.push({value: data.id, text: data.name});
                });

            }).catch(error => {
                if (error.response.status != 200) {
                    this.errors = { district: error.response.data.data.district_id};
                }
            });
        },
        loadBindHouse() {
            if(this.spot_item.value === this.spot_value_last.value) return;

            this.spot_value_last.value = this.spot_item.value;

            if(this.spot_item.value == "" || this.spot_item.value == 0){
                this.fields = {}
            }
            this.city_selected_options = [];
            this.city_options = [];
            var self = this;
            axios.get('/api/cities/spot_id/'+this.spot_item.value).then(response => {

                $.each(response.data.data, function (i, data) {
                    self.city_options.push({value: data.id, text: (data.type == null ? "" : data.type + " ") +
                            data.name + (data.category == null ? "" :  " " + data.category)});
                });

            }).catch(error => {
                if (error.response.status != 200) {
                    this.house = { house: error.response.data.data.house_id}
                }
            });
        },
        onSelect (items) {
            this.city_selected_options = items;
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
