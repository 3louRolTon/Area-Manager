<template>
    <div>

        <form @submit.prevent="submit">

            <div class="alert alert-success" v-show="success">Участок загружен</div>

            <div class="form-group row">
                <label for="area" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <model-select id="area" name="area" :options="area_options"
                                  v-model="area_item"
                                  placeholder="Выберите область"
                                  :required="area_item.value == ''"
                                  @input="loadDistrict"
                                  :isDisabled="disableSelect">
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
                                  @input="loadSpot"
                                  :isDisabled="disableSelect">
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
                                  @input="loadBindHouse"
                                  :isDisabled="disableSelect">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.spot">
                        {{ errors.spot[0] }}
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">City</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items_city">
                        <th scope="row"></th>
                        <td>{{item.city_type}} {{item.city_name}} {{item.city_category}}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">City</th>
                        <th scope="col">Street</th>
                        <th scope="col">House</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items_house">
                        <th scope="row"></th>
                        <td>{{item.city_type}} {{item.city_name}} {{item.city_category}}</td>
                        <td>{{item.street_type}} {{item.street_name}}</td>
                        <td>{{item.house_number}}</td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>
</template>

<script>
import { ModelSelect } from 'vue-search-select'
import { MultiSelect } from 'vue-search-select'

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

            spot_options: [

            ],
            spot_item: {
                value: '',
                text: ''
            },
            spot_value_last: {
                value: ''
            },

            items_city: [],
            items_house: [],
            disableSelect: false,

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
            this.success = false;
            this.house_selected_options = [];
            this.house_options = [];
            this.items = [];
            this.disableSelect = true;

            var self = this;
            axios.get('/api/spots/getBind/'+this.spot_item.value).then(response => {
                this.items_city = response.data.data.city;
                this.items_house = response.data.data.house;
                this.disableSelect = false;
                this.success = true;
            }).catch(error => {
                if (error.response.status != 200) {
                    this.house = { house: error.response.data.data.house_id}
                }
            }).finally(() => {
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
