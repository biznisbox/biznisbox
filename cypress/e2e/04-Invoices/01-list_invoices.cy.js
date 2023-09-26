describe('List invoices', () => {
    it('should list invoices', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="header"]').should('contain', 'Invoices')
        cy.get('div[id="invoice_table"] table tbody tr').should('have.length.greaterThan', 0)
    })

    it('should check if new invoice button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="header"] a[href="/invoices/new"]').should('be.visible')
    })

    it('should check if new invoice button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="header"] a[href="/invoices/new"]').click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/invoices/new')
    })
})
