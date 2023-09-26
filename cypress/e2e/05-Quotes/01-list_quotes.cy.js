describe('List quotes', () => {
    it('should list quotes', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="header"]').should('contain', 'Quotes')
        cy.get('div[id="quote_table"] table tbody tr').should('have.length.greaterThan', 0)
    })

    it('should check if new quote button is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="header"] a[href="/quotes/new"]').should('be.visible')
    })

    it('should check if new quote button is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="header"] a[href="/quotes/new"]').click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/quotes/new')
    })
})
