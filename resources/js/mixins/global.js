import countries from '@/data/country.json'
import languages from '@/data/available_locales.json'
export default {
    data() {
        return {
            units: [],
            taxes: [],
            currencies: [],
            languages: languages,
            employees: [],
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

        /**
         * Get employees
         * @returns {Promise<void>}
         **/
        getEmployees() {
            this.makeHttpRequest('GET', '/api/data', null, { type: 'employees' }).then((response) => {
                this.employees = response.data.data
            })
        },
    },
}
