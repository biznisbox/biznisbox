describe('List products', () => {
    it('should list products', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="header"]').should('contain', 'Products')
        cy.get('div[id="products_table"] table tbody tr').should('have.length.greaterThan', 0)
    })

    it('should check if new product button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="header"] a[href="/products/new"]').should('be.visible')
    })

    it('should check if product button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="header"] a[href="/products/new"]').click()
        cy.url().should('include', '/products/new')
    })
})
