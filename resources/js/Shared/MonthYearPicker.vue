<template>
    <section>
        <b-field :label="placeholder">
            <b-datepicker
                type="month"
                :placeholder="placeholder"
                icon="calendar-today"
                trap-focus>
            </b-datepicker>
        </b-field>
    </section>
</template>

<script>
export default {
    props: {
        endpoint: {
            type: String,
        },
        placeholder: {
            type: String,
            default: 'e.g. Pick a date',
        }
    },
    data() {
        return {
            date: null,
        }
    }
}
</script>
