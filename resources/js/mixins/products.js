export default {
    data() {
        return {
            products: [],
            product: {
                category_id: '',
                name: '',
                number: '',
                description: '',
                sell_price: 0,
                buy_price: 0,
                stock: 0,
                stock_min: 0,
                stock_max: 0,
                unit: '',
                active: true,
                type: 'product',
                barcode: '',
                tax: '',
            },
        }
    },

    created() {},

    methods: {
        /**
         * Save product
         * @returns {void}
         */
        saveProduct() {
            this.makeHttpRequest('POST', '/api/products', this.product).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'products' })
            })
        },

        /**
         * Get product
         * @param {string} id uuid of product
         * @returns {void}
         */
        getProduct(id) {
            this.makeHttpRequest('GET', '/api/products/' + id)
                .then((response) => {
                    this.product = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.$router.push({ name: 'products' })
                    }
                })
        },

        /**
         * Get all products
         * @returns {void}
         **/
        getProducts() {
            this.makeHttpRequest('GET', '/api/products')
                .then((response) => {
                    this.products = response.data.data
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.showToast(this.$t('errors.not_found_item'), this.$t('basic.error'), 'error')
                        this.$router.push({ name: 'products' })
                    }
                })
        },

        /**
         * Update product
         * @param {string} id uuid of product
         * @returns {void}
         */
        updateProduct(id) {
            this.makeHttpRequest('PUT', '/api/products/' + id, this.product).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'product-view', params: { id: id } })
            })
        },

        /**
         * Delete product
         * @param {string} id uuid of product
         * @returns {void}
         */
        deleteProduct(id) {
            this.makeHttpRequest('DELETE', '/api/products/' + id).then((response) => {
                this.showToast(response.data.message)
                this.$router.push({ name: 'products' })
            })
        },

        /**
         * Ask for confirmation before deleting product
         * @param {string} id  uuid of product
         * @returns {void}
         */
        deleteProductAsk(id) {
            this.confirmDeleteDialog(this.$t('product.delete_product_confirmation'), this.$t('basic.confirmation'), () => {
                this.deleteProduct(id)
            })
        },

        /**
         * Get product number
         * @returns {void}
         */
        getProductNumber() {
            this.makeHttpRequest('GET', '/api/product/number').then((response) => {
                this.product.number = response.data.data
            })
        },
    },
}
