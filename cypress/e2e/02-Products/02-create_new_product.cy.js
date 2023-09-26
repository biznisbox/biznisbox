import { faker } from '@faker-js/faker'
describe('Create new product', () => {
    it('should create new product', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        for (let i = 0; i < 3; i++) {
            cy.visit('/products/new')
            cy.get('input[id="name_input"]').type(faker.commerce.productName())
            cy.get('div[id="select_product_type"]').click()
            cy.get('input[id="barcode_input"]').type(faker.datatype.number({ min: 1000000000000, max: 9999999999999 }))
            cy.get('span[id="sell_price_input"] input').click()
            cy.get('span[id="sell_price_input"] input').type('{selectall}').type(faker.commerce.price())
            cy.get('span[id="buy_price_input"] input').click()
            cy.get('span[id="buy_price_input"] input').type('{selectall}').type(faker.commerce.price())
            cy.get('div[id="function_buttons"] button[id="save_button"]').click()
            cy.url().should('be.equal', Cypress.config().baseUrl + '/products')
        }
    })

    it('should not create new product', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products/new')
        cy.get('input[id="barcode_input"]').type('1234567890123')
        cy.get('div[id="function_buttons"] button[id="save_button"]').click()
        cy.url().should('include', '/products/new')
    })
})
