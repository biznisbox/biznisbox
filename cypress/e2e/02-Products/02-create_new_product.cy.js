describe('Create New Product', () => {
    it('should create new product', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products/new')
        cy.get('input[id="name_input"]').type('Test Product')
        cy.get('input[id="barcode_input"]').type('123456789')
        cy.get('div[id="function_buttons"] button[id="save_button"]').click()
        cy.url().should('include', '/products')
    })

    it('should not create new product', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products/new')
        cy.get('input[id="barcode_input"]').type('123456789')
        cy.get('div[id="function_buttons"] button[id="save_button"]').click()
        cy.url().should('include', '/products/new')
    })
})
