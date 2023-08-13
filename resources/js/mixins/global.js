import countries from '@/data/country.json'
export default {
    data() {
        return {
            units: [],
            taxes: [],
            currencies: [],
            countries: countries,
        }
    },

    created() {},

    methods: {
        /**
         * Get units
         *
         * @returns {Promise<void>}
         */
        getUnits() {
            this.makeHttpRequest('GET', '/api/data', null, { type: 'units' }).then((response) => {
                this.units = response.data.data
            })
        },

        /**
         * Get taxes
         *
         * @returns {Promise<void>}
         */
        getTaxes() {
            this.makeHttpRequest('GET', '/api/data', null, { type: 'taxes' }).then((response) => {
                this.taxes = response.data.data
            })
        },

        /**
         * Get currencies
         * @returns {Promise<void>}
         **/
        getCurrencies() {
            this.makeHttpRequest('GET', '/api/data', null, { type: 'currencies' }).then((response) => {
                this.currencies = response.data.data
            })
        },
    },
}
