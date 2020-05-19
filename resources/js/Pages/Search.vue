<template>
    <div class="container">

        <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false">
            <b-icon
                icon="loading"
                size="is-large"
                custom-class="loading spin">
            </b-icon>
        </b-loading>

        <div class="row">

            <b-field label="Country">
                <b-select placeholder="Select a country"
                    v-model="selected.country"
                    expanded>

                    <option
                        v-for="country in countries"
                        :value="country.value"
                        :key="country.key">
                        {{ country.label }}
                    </option>

                </b-select>
            </b-field>

            <b-field label="Month / Year">
                <b-datepicker
                    v-model="selected.date"
                    type="month"
                    placeholder="Click to select..."
                    icon="calendar-today"
                    trap-focus>
                </b-datepicker>
            </b-field>

            <b-button type="is-primary"
                outlined
                icon-left="magnify"
                @click="search">Search</b-button>
        </div>

        <div class="row mt-5" v-if="holidays.data.length !== 0">

            <b-table :data="holidays.data"
                :columns="holidays.columns"
                default-sort="date">
            </b-table>

        </div>

    </div>
</template>

<script>
import MonthYearPicker from '@/Shared/MonthYearPicker'

export default {
    components: {
        MonthYearPicker
    },
    props: {
        countries: Array
    },
    mounted(){
        this.isLoading = false
    },
    data() {
        return {
            isLoading: true,

            selected: {
                country: null,
                date: null,
            },

            holidays: {
                data: [],
                columns: [],
            },

            endpoints: {
                holidays: '/api/holidays',
            },
        };
    },
    methods: {
        validate() {

            let hasError = false;
            let error;

            // Some rough error checking
            if (this.selected.country === null) {
                hasError = true;
                error = 'Please select a country';
            } else if (this.selected.date === null) {
                hasError = true;
                error = 'Please select a date';
            }

            if (hasError === true) {
                this.$buefy.toast.open({
                    duration: 2500,
                    message: error,
                    type: 'is-danger',
                });

                return false;
            }

            return true;
        },

        search() {

            // Validate the fields
            if (! this.validate()) {
                return;
            }

            this.isLoading = true;

            // Call the API
            axios.post(this.endpoints.holidays, this.selected)
                .then(response => {
                    this.holidays = response.data
                    this.isLoading = false
                })
                .catch(error => {
                    this.isLoading = false

                    console.log(error)

                    this.$buefy.toast.open({
                        duration: 2500,
                        message: `Something went wrong calling the API.`,
                        type: 'is-danger',
                    });
                })

        }
    }
}
</script>
