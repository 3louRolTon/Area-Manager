<template>
    <div>
        <form @submit.prevent="submit">
            <div class="alert alert-success" v-show="success">Пользователь создан успешно.</div>
            <div class="alert alert-danger" v-if="errors && errors.message">
                {{ errors.message }}
            </div>
            <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right">Роль пользователя</label>

                <div class="col-md-6">
                    <model-select id="role" name="role" :options="role_options"
                                  v-model="role_item"
                                  placeholder="Выберите роль">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.role">
                        {{ errors.role }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="area" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <model-select id="area" name="area" :options="area_options"
                                  v-model="area_item"
                                  placeholder="select area"
                                  @input="loadDistrict">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.area">
                        {{ errors.area }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="district" class="col-md-4 col-form-label text-md-right">Район</label>

                <div class="col-md-6">
                    <model-select id="district" name="district" :options="district_options"
                                  v-model="district_item"
                                  placeholder="select district">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.district">
                        {{ errors.district }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="login" class="col-md-4 col-form-label text-md-right">Логин</label>

                <div class="col-md-6">
                    <input id="login" type="text" class="form-control" name="login" v-model="fields.login" required autocomplete="email">
                    <div class="alert alert-danger" v-if="errors && errors.login">
                        {{ errors.login[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="text" class="form-control" name="email" v-model="fields.password" required autocomplete="email">
                    <div class="alert alert-danger" v-if="errors && errors.password">
                        {{ errors.password[0] }}
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
        props: [
            'roles',
            'areas',
            'token'
        ],
        data() {
            return {
                role_options: [
                    {value: 0, text: ''}
                ],
                role_item: {
                    value: '0',
                    text: '-'
                },
                role_value_last: {
                    value: ''
                },

                area_options: [
                    {value: 0, text: '-'}
                ],
                area_item: {
                    value: '0',
                    text: '-'
                },
                area_value_last: {
                    value: ''
                },

                district_options: [
                    {value: 0, text: '-'}
                ],
                district_item: {
                    value: '0',
                    text: '-'
                },
                district_value_last: {
                    value: ''
                },

                categories: null,
                fields: {},
                success: false,
                errors: {}
            }
        },
        mounted() {
            var self = this

            JSON.parse(this.areas).forEach(function (value) {
                self.area_options.push({value: value.id, text: value.area_name})
            })

            JSON.parse(this.roles).forEach(function (value) {
                self.role_options.push({value: value, text: value})
            })
        },
        methods: {
            submit() {
                this.errors = {};
                this.success = false;

                if(this.role_item.value !== "admin" && this.role_item.value !== "user" && this.role_item.value !== "validate"){
                    this.errors.role = "Не выбрана роль";
                    return
                }
                if(this.area_item.value == 0 || this.area_item.value == "") {
                    this.errors.area = "Не выбрана область";
                    return
                }
                if(this.role_item.value !== "admin"){
                    this.errors.district = "Не выбран район";
                    return
                }
                this.fields.role = this.role_item.value
                this.fields.area = this.area_item.value
                this.fields.district = this.district_item.value

                axios.post('/api/user', this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                }).catch(error => {
                    console.log(error.response.data);
                    console.log('Error');
                });
            },
            loadDistrict() {
                if(this.area_item.value === this.area_value_last.value) return;

                this.area_value_last.value = this.area_item.value;

                if(this.area_item.value == "" || this.area_item.value == 0){
                    this.district_options = [{value: 0, text: ''}];
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
            }
        },
        components: {
            ModelSelect
        }
    }
</script>
