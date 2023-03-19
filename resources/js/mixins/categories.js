export default {
    data() {
        return {
            categories: [],
            category: {
                name: '',
                description: '',
                parent_id: null,
                color: '',
                module: '',
            },
        }
    },

    methods: {
        /**
         * Function for retrieve all categories from API and assign to module
         * @param {string} $module
         */
        getAllCategories(module) {
            this.makeHttpRequest('get', '/api/categories', null, { module: module }).then((response) => {
                this.categories = response.data.data
            })
        },

        /**
         * Function for create new category
         */
        createNewCategory() {
            this.makeHttpRequest('post', '/api/categories', this.category).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Function for update category
         * @param {string} id
         */

        updateCategory(id) {
            this.makeHttpRequest('put', '/api/categories/' + id, this.category).then((response) => {
                this.showToast(response.data.message)
            })
        },

        /**
         * Function for delete category
         * @param {string} id
         */
        deleteCategory(id) {
            this.makeHttpRequest('delete', '/api/categories/' + id, null).then((response) => {
                this.showToast(response.data.message)
            })
        },
    },
}
