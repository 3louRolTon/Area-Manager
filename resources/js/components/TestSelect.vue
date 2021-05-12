<template>
    <div>
        <form @submit.prevent="submit">
            <div class="alert alert-success" v-show="success">Ticket created successfully.</div>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Роль пользователя</label>

                <div class="col-md-6">
                    <model-select :options="area_options"
                                  v-model="area_item"
                                  placeholder="select role">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.name">
                        {{ errors.name[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Область</label>

                <div class="col-md-6">
                    <model-select :options="area_options"
                                  v-model="area_item"
                                  placeholder="select area">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.email">
                        {{ errors.email[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="category_id" class="col-md-4 col-form-label text-md-right">Район</label>

                <div class="col-md-6">
                    <model-select :options="area_options"
                                  v-model="area_item"
                                  placeholder="select district">
                    </model-select>
                    <div class="alert alert-danger" v-if="errors && errors.category_id">
                        {{ errors.category_id[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="category_id" class="col-md-4 col-form-label text-md-right">Логин</label>

                <div class="col-md-6">
                    <input id="2" type="email" class="form-control" name="email" v-model="fields.email" required autocomplete="email">
                    <div class="alert alert-danger" v-if="errors && errors.email">
                        {{ errors.email[0] }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="category_id" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="email3" type="email" class="form-control" name="email" v-model="fields.email" required autocomplete="email">
                    <div class="alert alert-danger" v-if="errors && errors.email">
                        {{ errors.email[0] }}
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
                area_options: [
                    {value: 0, text: '-'}
                ],
                area_item: {
                    value: '0',
                    text: '-'
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
                axios.post('/api/tickets', this.fields).then(response => {
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
