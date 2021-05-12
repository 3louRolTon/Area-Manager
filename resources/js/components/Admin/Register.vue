<template>
    <div>
        <form @submit.prevent="submit">
            <div class="alert alert-success" v-show="success">Ticket created successfully.</div>
            <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right">Роль пользователя</label>

                <div class="col-md-6">
                    <model-select id="role" name="role" :options="role_options"
                                  v-model="role_item"
                                  placeholder="Выберите роль">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.role">
                        {{ errors.role[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="area" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <model-select id="area" name="area" :options="area_options"
                                  v-model="area_item"
                                  placeholder="select area">
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
                                  placeholder="select district">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.district">
                        {{ errors.district[0] }}
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
        data() {
            return {
                role_options: [
                    {value: 0, text: ' '}
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

        },
        methods: {
            submit() {
                axios.post('/api/user', this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                    this.errors = {};
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.log('Error');
                });
            }
        },
        components: {
            ModelSelect
        }
    }
</script>
