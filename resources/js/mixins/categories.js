export default {
    methods: {
        /**
         * Function for retrieve all categories from API and assign to module
         * @param {string} $module
         * @return {Promise}
         *
         */
        getCategories(module) {
            return new Promise((resolve, reject) => {
                this.makeHttpRequest('GET', '/api/categories', null, { module: module })
                    .then((response) => {
                        resolve(response.data.data)
                    })
                    .catch((error) => {
                        reject(error.response.data.message)
                    })
            })
        },

        getCategory(id) {
            return new Promise((resolve, reject) => {
                this.makeHttpRequest('GET', '/api/categories/' + id)
                    .then((response) => {
                        resolve(response.data.data)
                    })
                    .catch((error) => {
                        reject(error.response.data.message)
                    })
            })
        },

        /**
         * Function for create new category
         * @param {object} data
         * @return {Promise}
         */
        createCategory(data) {
            return new Promise((resolve, reject) => {
                this.makeHttpRequest('POST', '/api/categories', data)
                    .then((response) => {
                        resolve(response.data.message)
                    })
                    .catch((error) => {
                        reject(error.response.data.message)
                    })
            })
        },

        /**
         * Function for update category
         * @param {string} id uuid of category
         * @param {object} data json object
         * @return {Promise}
         */

        updateCategory(id, data) {
            return new Promise((resolve, reject) => {
                this.makeHttpRequest('PUT', '/api/categories/' + id, data)
                    .then((response) => {
                        resolve(response.data.message)
                    })
                    .catch((error) => {
                        reject(error.response.data.message)
                    })
            })
        },

        /**
         * Function for delete category
         * @param {string} id
         */
        deleteCategory(id) {
            return new Promise((resolve, reject) => {
                this.makeHttpRequest('DELETE', '/api/categories/' + id)
                    .then((response) => {
                        resolve(response.data.message)
                    })
                    .catch((error) => {
                        this.showToast(error.response.data.message, this.$t('error'), 'error')
                        reject(error.response.data.message)
                    })
            })
        },
    },
}
