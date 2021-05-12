<template>
    <div>
        <model-select :options="area_options"
                      v-model="area_item"
                      placeholder="select area"
                      @input="myChange">
        </model-select>

        <model-select :options="district_options"
                      v-model="district_item"
                      placeholder="select area">
        </model-select>
    </div>
</template>

<script>
    import { ModelSelect } from 'vue-search-select'
    var self = this;
    export default {
        props: ['data'],

        data () {
            return {
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
                    value: '',
                    text: ''
                }
            }
        },
        mounted() {
            var self = this;

            $.each(this.data, function (i, data) {
                self.area_options.push({value: data.id, text: data.area_name});
            });

        },
        methods: {
            myChange () {
                if(this.area_item.value === this.area_value_last.value) return;

                this.area_value_last.value = this.area_item.value;
                this.district_options = [];
                //axios.
            }
        },
        components: {
            ModelSelect
        }
    }
</script>
