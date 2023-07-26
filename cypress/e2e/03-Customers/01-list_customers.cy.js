describe('List customers', () => {
    it('should list customers', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="header"]').should('contain', 'Customers')
        cy.get('div[id="customers_table"] table tbody tr').should('have.length.greaterThan', 0)
    })

    it('should check if new customer button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="header"] a[href="/customers/new"]').should('be.visible')
    })

    it('should check if product button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/customers')
        cy.get('div[id="header"] a[href="/customers/new"]').click()
        cy.url().should('include', '/customers/new')
    })
})
